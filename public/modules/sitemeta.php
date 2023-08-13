<?php
/**
 * Site meta
 * Add custom site header meta and footer description
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Sitemeta {
    /**
     * Use this method instead of constructor to avoid setting multiple hooks
     */
    public static function load_module() {
        add_filter( 'language_attributes', array( __CLASS__, 'add_xmlns' ) );
        add_action( 'customize_register', array( __CLASS__, 'update_customizer_settings' ) );

        add_action( 'wp_head', array( __CLASS__, 'add_og_tags' ), 5 );
        add_action( 'wp_head', array( __CLASS__, 'add_icons' ), 4 );
        add_action( 'admin_head', array( __CLASS__, 'add_icons' ), 4 );

        add_action( 'wp_head', array( __CLASS__, 'add_twitter_tags' ), 5 );
        add_action( 'wp_head', array( __CLASS__, 'add_facebook_tags' ), 5 );
        add_action( 'wp_head', array( __CLASS__, 'add_telegram_tags' ), 5 );

        // Add JSON-LD microdata
        add_action( 'wp_head', array( __CLASS__, 'add_singular_microdata' ), 25 );
        add_action( 'wp_head', array( __CLASS__, 'add_frontpage_microdata' ), 25 );

        // Add custom analytics scripts
        add_action( 'wp_head', array( __CLASS__, 'add_analytics' ), 20 );
    }

    /**
     * Add og xmlns
     */
    public static function add_xmlns( $output ) {
        return 'prefix="og: http://ogp.me/ns#" ' . $output;
    }

    /**
     * Footer description option
     */
    public static function update_customizer_settings( $wp_customize ) {
        $wp_customize->add_setting( 'extra-description' );
        $wp_customize->add_setting( 'extra-meta' );

        $wp_customize->add_section(
            'kedr_extra',
            array(
                'title'    => esc_html__( 'Дополнительные настройки', 'kedr-theme' ),
                'priority' => 160,
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Code_Editor_Control(
                $wp_customize,
                'extra-description',
                array(
                    'label'     => esc_html__( 'Описание в подвале', 'kedr-theme' ),
                    'section'   => 'kedr_extra',
                    'code_type' => 'text/html',
                    'priority'  => 10,
                )
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Code_Editor_Control(
                $wp_customize,
                'extra-meta',
                array(
                    'label'     => esc_html__( 'Блок под метой записи', 'kedr-theme' ),
                    'section'   => 'kedr_extra',
                    'code_type' => 'text/html',
                    'priority'  => 10,
                )
            )
        );

        // Remove site icon customize setting
        $wp_customize->remove_control( 'site_icon' );
        $wp_customize->remove_section( 'static_front_page' );
    }

    /**
     * Add manifest and header icons
     */
    public static function add_icons() {
        $meta = array();

        $meta[] = sprintf(
            '<link rel="shortcut icon" href="%s" crossorigin="use-credentials">',
            esc_url( get_stylesheet_directory_uri() . '/assets/images/favicon.ico' )
        );

        $meta[] = sprintf(
            '<link rel="icon" type="image/png" sizes="32x32" href="%s">',
            esc_url( get_stylesheet_directory_uri() . '/assets/images/icon-32.png' )
        );

        $meta[] = sprintf(
            '<link rel="icon" type="image/png" sizes="192x192" href="%s">',
            esc_url( get_stylesheet_directory_uri() . '/assets/images/icon-192.png' )
        );

        $meta[] = sprintf(
            '<link rel="apple-touch-icon" sizes="180x180" href="%s">',
            esc_url( get_stylesheet_directory_uri() . '/assets/images/icon-180.png' )
        );

        return self::print_tags( $meta );
    }

    /**
     * Add tagmanager script to header
     */
    public static function add_analytics() {
        if ( defined( 'KEDR_TAGMANAGER' ) ) {
            include get_template_directory() . '/includes/views/sitemeta-scripts.php';
        }
    }

    /**
     * Add og tags
     *
     * @link https://developers.facebook.com/docs/sharing/webmasters
     */
    public static function add_og_tags() {
        $meta = array();

        $meta[] = sprintf(
            '<meta property="og:site_name" content="%s">',
            esc_attr( get_bloginfo( 'name' ) )
        );

        $meta[] = sprintf(
            '<meta property="og:locale" content="%s">',
            esc_attr( get_locale() )
        );

        $meta[] = sprintf(
            '<meta property="og:description" content="%s">',
            esc_attr( self::get_description() )
        );

        if ( method_exists( 'Kedr_Modules_Snippet', 'get_image' ) ) {
            $image = Kedr_Modules_Snippet::get_image();

            $meta[] = sprintf(
                '<meta property="og:image" content="%s">',
                esc_attr( $image['path'] )
            );

            $meta[] = sprintf(
                '<meta property="og:image:width" content="%s">',
                esc_attr( $image['width'] )
            );

            $meta[] = sprintf(
                '<meta property="og:image:height" content="%s">',
                esc_attr( $image['height'] )
            );
        }

        if ( is_post_type_archive() ) {
            $meta[] = sprintf(
                '<meta property="og:url" content="%s">',
                esc_url( get_post_type_archive_link( get_post_type() ) )
            );
        }

        if ( is_tax() || is_category() || is_tag() ) {
            $meta[] = sprintf(
                '<meta property="og:url" content="%s">',
                esc_url( get_term_link( get_queried_object()->term_id ) )
            );
        }

        if ( is_front_page() ) {
            $meta[] = sprintf(
                '<meta property="og:url" content="%s">',
                esc_url( home_url( '/' ) )
            );

            $meta[] = sprintf(
                '<meta property="og:title" content="%s">',
                wp_get_document_title()
            );
        }

        if ( is_singular() && ! is_front_page() ) {
            $object_id = get_queried_object_id();

            array_push( $meta, '<meta property="og:type" content="article">' );

            $meta[] = sprintf(
                '<meta property="og:url" content="%s">',
                esc_url( get_permalink( $object_id ) )
            );

            $meta[] = sprintf(
                '<meta property="og:title" content="%s">',
                esc_attr( wp_strip_all_tags( get_the_title( $object_id ) ) )
            );
        }

        if ( is_archive() ) {
            $object_type = get_queried_object();

            $meta[] = sprintf(
                '<meta property="og:title" content="%s">',
                esc_attr( wp_get_document_title() )
            );
        }

        return self::print_tags( $meta );
    }

    /**
     * Add twitter tags
     * Note: We shouldn't duplicate og tags
     *
     * @link https://developer.twitter.com/en/docs/tweets/optimize-with-cards/guides/getting-started.html
     */
    public static function add_twitter_tags() {
        $meta = array(
            '<meta name="twitter:card" content="summary_large_image">',
            '<meta name="twitter:site" content="@KedrMedia">',
        );

        if ( method_exists( 'Kedr_Modules_Snippet', 'get_image' ) ) {
            $image = Kedr_Modules_Snippet::get_image();

            $meta[] = sprintf(
                '<meta name="twitter:image" content="%s">',
                esc_attr( $image['path'] )
            );
        }

        return self::print_tags( $meta );
    }

    /**
     * Add additional Facebook tags
     */
    public static function add_facebook_tags() {
        $meta = array(
            '<meta name="facebook-domain-verification" content="u28mwryow1eqvezxc7f64xb9s51d61"/>',
        );

        return self::print_tags( $meta );
    }

    /**
     * Add Telegram meta tag
     */
    public static function add_telegram_tags() {
        $meta = array(
            '<meta name="telegram:channel" content="@kedr_media">',
        );

        return self::print_tags( $meta );
    }

    /**
     * Add JSON-LD microdata for front page template
     */
    public static function add_frontpage_microdata() {
        if ( ! is_front_page() ) {
            return;
        }

        $schema = array(
            '@context' => 'http://schema.org',
            '@type'    => 'WebSite',
            'url'      => home_url( '/' ),
        );

        $schema['potentialAction'] = array(
            '@type'       => 'SearchAction',
            'target'      => home_url( '/?s={search_term_string}' ),
            'query-input' => 'required name=search_term_string',
        );

        printf(
            '<script type="application/ld+json">%s</script>',
            wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
        );
    }

    /**
     * Add JSON-LD microdata for singular templates
     */
    public static function add_singular_microdata() {
        if ( ! is_singular() || is_front_page() ) {
            return;
        }

        $schema = array(
            '@context' => 'http://schema.org',
            '@type'    => 'Article',
        );

        $post_id = get_queried_object_id();

        if ( has_category( 'news', $post_id ) ) {
            $schema['@type'] = 'NewsArticle';
        }

        $schema['url']           = get_permalink( $post_id );
        $schema['@id']           = $schema['url'] . '#post-' . $post_id;
        $schema['datePublished'] = get_the_date( 'c', $post_id );
        $schema['dateModified']  = get_the_modified_date( 'c', $post_id );
        $schema['headline']      = wp_strip_all_tags( get_the_title( $post_id ) );

        if ( get_post_type( $post_id ) === 'post' ) {
            $content = get_the_content( null, false, $post_id );
            $content = preg_replace( '~[ \t\r\n]+~', ' ', $content );

            // Strip content tags
            $schema['text'] = wp_strip_all_tags( $content );
        }

        if ( function_exists( 'get_coauthors' ) ) {
            $authors = (array) get_coauthors( $post_id );

            foreach ( $authors as $author ) {
                $user = array(
                    'type' => 'Person',
                    'name' => $author->display_name,
                );

                $schema['author'][] = $user;
            }
        }

        printf(
            '<script type="application/ld+json">%s</script>',
            wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
        );
    }

    /**
     * Get description
     */
    private static function get_description() {
        $description = esc_html__( 'Мы говорим о том, что важно, и показываем то, что красиво. И стараемся не только делать объективный и интересный контент, но и решать накопившиеся экологические проблемы.', 'kedr-theme' );

        if ( is_singular() && ! is_front_page() ) {
            $object_id = get_queried_object_id();

            if ( has_excerpt( $object_id ) ) {
                return trim( wp_strip_all_tags( get_the_excerpt( $object_id ) ) );
            }
        }

        if ( is_archive() ) {
            $object_type = get_queried_object();

            if ( ! empty( $object_type->description ) ) {
                return wp_strip_all_tags( $object_type->description, true );
            }

            if ( ! empty( $object_type->name ) ) {
                $description = sprintf( __( 'Архив записей по теме &laquo;%s&raquo;', 'kedr-theme' ), wp_strip_all_tags( $object_type->name ) );
            }

            if ( ! empty( $object_type->label ) ) {
                $description = sprintf( __( 'Архив записей по теме &laquo;%s&raquo;', 'kedr-theme' ), wp_strip_all_tags( $object_type->label ) );
            }

            if ( get_query_var( 'paged' ) ) {
                $description = $description . sprintf( __( ' — Cтраница %d', 'kedr-theme' ), get_query_var( 'paged' ) );
            }
        }

        return $description;
    }

    /**
     * Print tags if not empty array
     */
    private static function print_tags( $meta ) {
        foreach ( $meta as $tag ) {
            echo $tag . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput
        }
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Sitemeta::load_module();
