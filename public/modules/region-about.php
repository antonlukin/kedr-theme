<?php
/**
 * Custom Post Type and Taxonomy Handling
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Region_About {
    /**
     * Unique post type slug
     *
     * @var string
     */
    public static $post_type = 'region-about';

    /**
     * Postname
     *
     * @access  public
     * @var string
     */
    public static $post_name = 'about';

    /**
     * Load module
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'register_post_type' ) );
        add_filter( 'post_type_link', array( __CLASS__, 'post_type_permalink' ), 1, 2 );
    }

    /**
     * Register custom post type
     */
    public static function register_post_type() {

        $labels = array(
            'name'          => __( 'Экокарта' ),
            'singular_name' => __( 'Экокарта' ),
        );

        $args = array(
            'label'                 => esc_html__( 'Экокарта', 'kedr-theme' ),
            'labels'                => $labels,
            'description'           => '',
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_rest'          => true,
            'rest_base'             => '',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'has_archive'           => 'map',
            'show_in_menu'          => true,
            'show_in_nav_menus'     => true,
            'delete_with_user'      => false,
            'exclude_from_search'   => false,
            'capability_type'       => 'post',
            'map_meta_cap'          => true,
            'hierarchical'          => false,
            'rewrite'               => array(
                'slug'       => Kedr_Modules_Regions::$taxonomy . '/%region%',
                'with_front' => true,
            ),
            'query_var'             => true,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'post-formats' ),
            'taxonomies'            => array(),
        );

        register_post_type( self::$post_type, $args );
    }

    /**
     * Modify permalink for custom post type
     */
    public static function post_type_permalink( $permalink, $post ) {
        if ( is_object( $post ) && $post->post_type == self::$post_type ) {
            $terms = wp_get_object_terms( $post->ID, 'region' );
            if ( $terms ) {
                return str_replace( '%region%', $terms[0]->slug, $permalink );
            }
        }
        return $permalink;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Region_About::load_module();
