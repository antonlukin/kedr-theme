<?php
/**
 * Loadmore actions
 * Add Rest API routes for loadmore posts in category archives
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Loadmore {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'rest_api_init', array( __CLASS__, 'register_rest_routes' ) );
    }

    /**
     * Register loadmore routers
     */
    public static function register_rest_routes() {
        register_rest_route(
            'kedr-loadmore/v1',
            '/(?<taxonomy>.+?)/(?<slug>.+)',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( __CLASS__, 'show_archive_posts' ),
                'permission_callback' => '__return_true',
                'args'                => array(
                    'taxonomy' => array(
                        'required'          => true,
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'slug'     => array(
                        'required'          => true,
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'page'     => array(
                        'default'           => 1,
                        'type'              => 'integer',
                        'required'          => false,
                        'sanitize_callback' => 'absint',
                    ),
                ),
            )
        );
    }

    /**
     * Show archive posts
     */
    public static function show_archive_posts( $request ) {
        $slug = $request->get_param( 'slug' );
        $page = $request->get_param( 'page' );

        if ( empty( $page ) ) {
            $page = 1;
        }

        $taxonomy = $request->get_param( 'taxonomy' );

        // Get custom WP_query by taxonomy term slug
        $query = self::get_taxonomy_query( $taxonomy, $slug, $page );

        if ( ! $query->have_posts() ) {
            return new WP_REST_Response( array( 'message' => esc_html__( 'Ничего не найдено', 'kedr-theme' ) ), 400 );
        }

        list( $partial, $options ) = self::get_taxonomy_template( $taxonomy, $slug );

        ob_start();

        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'templates/frame', $partial, $options );
        }

        wp_reset_postdata();

        $results = array(
            'output' => ob_get_clean(),
            'pages'  => array(
                'current' => $page,
                'total'   => $query->max_num_pages,
            ),
        );

        return new WP_REST_Response( $results, 200 );
    }

    /**
     * Get posts from taxonomy by slug and page
     */
    private static function get_taxonomy_query( $taxonomy, $slug, $page ) {
        $query = new WP_Query(
            array(
                'paged'               => $page,
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'tax_query'           => array( // phpcs:ignore
                    array(
                        'taxonomy' => $taxonomy,
                        'terms'    => $slug,
                        'field'    => 'slug',
                    ),
                ),
            )
        );

        return $query;
    }

    /**
     * Get taxonomy template part options by slug
     */
    public static function get_taxonomy_template( $taxonomy, $slug ) {
        $template = array( 'double', array() );

        if ( ! property_exists( 'Kedr_Modules_News', 'slug' ) ) {
            return $template;
        }

        // Check for news archive template
        if ( $taxonomy === 'category' && Kedr_Modules_News::$slug === $slug ) {
            $template = array( 'news', array( 'class' => 'common' ) );
        }

        return $template;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Loadmore::load_module();
