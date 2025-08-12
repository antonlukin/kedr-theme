<?php
/**
 * Snippet image
 * Create sharing image for social networks
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Snippet {
    /**
     * Backward compatibility social image meta name
     *
     * @access  public
     * @var     string
     */
    public static $meta_image = '_sharing-image';

    /**
     * Default post type with snippet image metabox
     *
     * @access  public
     * @var     array
     */
    public static $post_type = array( 'post' );

    /**
     * Directory to save social snippets images
     *
     * @access  private
     * @var     string
     */
    private static $upload_folder = '/sharing-image/';

    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'wp_after_insert_post', array( __CLASS__, 'generate_poster' ), 10, 3 );
        add_action( 'edited_' . Kedr_Modules_Regions::$taxonomy, array( __CLASS__, 'generate_region_poster' ), 10, 3 );
    }

    /**
     * Generate poster on post save
     */
    public static function generate_poster( $post_id ) {
        [$basedir, $baseurl] = self::get_upload_paths();
        if ( ! $basedir ) {
            return;
        }
        $filename = $post_id . uniqid( '-' ) . '.jpg';

        $category = null;

        // Get categories list if exist.
        $categories = get_the_category( $post_id );

        if ( ! empty( $categories ) ) {
            $category = $categories[0]->slug;
        }

        if ( empty( $category->term_id ) ) {
            return;
        }

        try {
            $options = self::generate_options(
                $basedir . $filename,
                esc_html( get_cat_name( $category->term_id ) ),
                get_the_title( $post_id )
            );

            if ( has_post_thumbnail( $post_id ) ) {
                $options['thumbnail'] = get_attached_file( get_post_thumbnail_id( $post_id ) );
            }

            if ( has_excerpt( $post_id ) ) {
                $options['excerpt'] = wp_strip_all_tags( get_the_excerpt( $post_id ) );
            }

            self::include_template( $options, $category );
        } catch ( Exception $error ) {
            return;
        }

        update_post_meta( $post_id, self::$meta_image, $baseurl . $filename );
    }

    /**
     * Generate region poster on region save
     */
    public static function generate_region_poster( $term_id ) {
        [$basedir, $baseurl] = self::get_upload_paths();
        if ( ! $basedir ) {
            return;
        }
        $filename = 'region-' . $term_id . uniqid( '-' ) . '.jpg';

        $term = get_term( $term_id, Kedr_Modules_Regions::$taxonomy );

        $options = (array) get_term_meta( $term_id, '_kedr-subcats-options', true );
        if ( ! empty( $options['attachment'] ) ) {
            $image = get_attached_file( $options['attachment'] );
        }

        if ( empty( $image ) ) {
            $image = get_template_directory_uri() . '/assets/images/region-placeholder.jpg';
        }

        try {
            $options = self::generate_options(
                $basedir . $filename,
                'Экокарта',
                $term->name,
                $image
            );

            self::include_template( $options, null );
        } catch ( Exception $error ) {
            return;
        }

        update_term_meta( $term_id, self::$meta_image, $baseurl . $filename );
    }

    /**
     * Get proper template for this post
     */
    public static function include_template( $options, $category ) {
        if ( ! class_exists( 'PosterEditor\PosterEditor' ) ) {
            require_once get_template_directory() . '/external/poster-editor.php';
        }

        if ( $category === 'news' ) {
            return include get_template_directory() . '/includes/posters/snippet-news.php';
        }

        return include get_template_directory() . '/includes/posters/snippet-article.php';
    }

    /**
     * Public function to get social image outside the module
     */
    public static function get_image() {
        $image = get_template_directory_uri() . '/assets/images/poster-feature.png';

        if ( is_post_type_archive( 'region-about' ) ) {
            $image = get_template_directory_uri() . '/assets/images/poster-ecomap.jpg';
        } elseif ( is_singular() && ! is_front_page() ) {
            $poster = get_post_meta( get_queried_object_id(), self::$meta_image, true );
        } elseif ( is_tax( Kedr_Modules_Regions::$taxonomy ) ) {
            $poster = get_term_meta( get_queried_object_id(), self::$meta_image, true );
        }

        if ( ! empty( $poster ) ) {
            $image = $poster;
        }

        $options = array(
            'path'   => $image,
            'width'  => 1200,
            'height' => 630,
        );

        return $options;
    }

    /**
     * Get upload directory paths for sharing images
     *
     * @return array
     */
    public static function get_upload_paths() {
        $uploads = wp_upload_dir();

        $basedir = $uploads['basedir'] . self::$upload_folder;

        if ( ! wp_is_writable( $basedir ) && ! wp_mkdir_p( $basedir ) ) {
            $basedir = null;
        }

        $baseurl = $uploads['baseurl'] . self::$upload_folder;

        return array( $basedir, $baseurl );
    }

    /**
     * Generate options array for the social sharing image
     *
     * @param string $filename The filename for the image.
     * @param string $label The label text for the image.
     * @param string $caption The caption text for the image.
     * @param string $image The path to the thumbnail or main image.
     * @return array The options array for generating the social sharing image.
     */
    public static function generate_options( $filename, $label, $caption, $image = null ) {
        return array(
            'file'       => $filename,
            'color'      => '#48625e',
            'label'      => $label,
            'caption'    => $caption,
            'logo-green' => get_template_directory() . '/assets/images/logosign-green.png',
            'logo-white' => get_template_directory() . '/assets/images/logosign-white.png',
            'font-bold'  => get_template_directory() . '/assets/fonts/Raleway-Bold.ttf',
            'font-thin'  => get_template_directory() . '/assets/fonts/Raleway-Regular.ttf',
            'thumbnail'  => $image,
        );
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Snippet::load_module();
