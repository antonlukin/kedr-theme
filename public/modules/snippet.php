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
    }

    /**
     * Generate poster on post save
     */
    public static function generate_poster( $post_id ) {
        $categories = get_the_category( $post_id );

        if ( empty( $categories ) ) {
            return;
        }

        $category = $categories[0];

        if ( ! class_exists( 'PosterEditor\PosterEditor' ) ) {
            require_once get_template_directory() . '/external/poster-editor.php';
        }

        $uploads = wp_upload_dir();

        $basedir = $uploads['basedir'] . self::$upload_folder;
        $baseurl = $uploads['baseurl'] . self::$upload_folder;

        if ( ! wp_is_writable( $basedir ) && ! wp_mkdir_p( $basedir ) ) {
            return;
        }

        $filename = $post_id . uniqid( '-' ) . '.jpg';

        try {
            $options = array(
                'file'       => $basedir . $filename,
                'color'      => '#48625e',
                'label'      => esc_html( get_cat_name( $category->term_id ) ),
                'caption'    => get_the_title( $post_id ),
                'logo-green' => get_template_directory() . '/assets/images/logosign-green.png',
                'logo-white' => get_template_directory() . '/assets/images/logosign-white.png',
                'font-bold'  => get_template_directory() . '/assets/fonts/Raleway-Bold.ttf',
                'font-thin'  => get_template_directory() . '/assets/fonts/Raleway-Regular.ttf',
            );

            self::include_template( $options, $post_id, $category );
        } catch ( Exception $error ) {
            return;
        }

        update_post_meta( $post_id, self::$meta_image, $baseurl . $filename );
    }

    /**
     * Get proper template for this post
     */
    public static function include_template( $options, $post_id, $category ) {
        if ( $category->slug === 'news' ) {
            return include get_template_directory() . '/includes/posters/snippet-news.php';
        }

        if ( has_post_thumbnail( $post_id ) ) {
            $options['thumbnail'] = get_attached_file( get_post_thumbnail_id( $post_id ) );
        }

        if ( has_excerpt( $post_id ) ) {
            $options['excerpt'] = wp_strip_all_tags( get_the_excerpt( $post_id ) );
        }

        return include get_template_directory() . '/includes/posters/snippet-article.php';
    }

    /**
     * Public function to get social image outside the module
     */
    public static function get_image() {
        $image = get_template_directory_uri() . '/assets/images/poster-feature.png';

        if ( is_singular() && ! is_front_page() ) {
            $poster = get_post_meta( get_queried_object_id(), self::$meta_image, true );

            if ( ! empty( $poster ) ) {
                $image = $poster;
            }
        }

        $options = array(
            'path'   => $image,
            'width'  => 1200,
            'height' => 630,
        );

        return $options;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Snippet::load_module();
