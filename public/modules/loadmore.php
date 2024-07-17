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
            '/(?<archive>.+?)/(?<slug>.+)',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( __CLASS__, 'show_archive_posts' ),
                'permission_callback' => '__return_true',
                'args'                => array(
                    'archive' => array(
                        'required'          => true,
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'slug'    => array(
                        'required'          => true,
                        'sanitize_callback' => array( __CLASS__, 'sanitize_slug' ),
                    ),
                    'page'    => array(
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
     * Sanitize slug field
     */
    public static function sanitize_slug( $slug ) {
        return sanitize_text_field( urldecode( $slug ) );
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

        $archive = $request->get_param( 'archive' );

        if ( $archive === 'search' ) {
            $query    = self::get_search_posts( $slug, $page );
            $template = array( 'search', null );
            return self::show_posts( $query, $template, $page );
        }
        if ( $archive === 'region' ) {
            if ( $slug === 'all' ) {
                $slug = null;
            }
            $query    = self::get_ecomap_posts( $slug, $page );
            $template = array( 'triple', array( 'add_region_label' => ! isset( $slug ) ) );
            return self::show_posts( $query, $template, $page );
        }

        if ( taxonomy_exists( $archive ) ) {
            $query    = self::get_taxonomy_posts( $archive, $slug, $page );
            $template = self::get_taxonomy_template( $archive, $slug );

            return self::show_posts( $query, $template, $page );
        }
    }

    /**
     * Get posts only for search page
     */
    private static function get_search_posts( $slug, $page ) {
        $query = new WP_Query(
            array(
                'paged'               => $page,
                's'                   => $slug,
                'post_status'         => 'any',
                'ignore_sticky_posts' => true,
            )
        );
        return $query;
    }

    /**
     * Get posts only for ecomap pages
     */
    private static function get_ecomap_posts( $slug, $page ) {
        $query = kedr_theme_get( 'taxonomy_articles', $page, $slug );

        return $query;
    }

    /**
     * Get posts only for taxonomy archives
     */
    private static function get_taxonomy_posts( $taxonomy, $slug, $page ) {
        $query = new WP_Query(
            array(
                'paged'       => $page,
                'post_type'   => 'post',
                'post_status' => 'publish',
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
     * Show posts
     */
    private static function show_posts( $query, $template, $page ) {
        if ( ! $query->have_posts() ) {
            return new WP_REST_Response( array( 'message' => esc_html__( 'Ничего не найдено', 'kedr-theme' ) ), 400 );
        }

        list( $partial, $options ) = $template;

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
     * Get taxonomy template part options by slug
     */
    public static function get_taxonomy_template( $taxonomy, $slug ) {
        $template = array( 'double', array() );

        // Check for news archive template
        if ( $taxonomy === 'category' && $slug === 'news' ) {
            $template = array( 'news', array( 'class' => 'common' ) );
        }

        return $template;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Loadmore::load_module();
