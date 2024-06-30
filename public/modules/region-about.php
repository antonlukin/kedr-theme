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

class Kedr_Modules_Custom_Post_Type {
    /**
     * Unique post type slug
     *
     * @var string
     */
    public static $post_type = 'region-about';

    /**
     * Load module
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'register_post_type' ) );
        add_filter( 'post_type_link', array( __CLASS__, 'post_type_permalink' ), 1, 2 );
        add_action( 'wp_insert_post', array( __CLASS__, 'set_custom_post_name' ), 10, 3 );
    }

    /**
     * Register custom post type
     */
    public static function register_post_type() {

        $labels = array(
            'name' => __( 'Экокарта' ),
            'singular_name' => __( 'Экокарта' ),
        );

          $args = array(
              'label' => __( 'Экокарта' ),
              'labels' => $labels,
              'description' => '',
              'public' => true,
              'publicly_queryable' => true,
              'show_ui' => true,
              'show_in_rest' => true,
              'rest_base' => '',
              'rest_controller_class' => 'WP_REST_Posts_Controller',
              'has_archive' => 'map',
              'show_in_menu' => true,
              'show_in_nav_menus' => true,
              'delete_with_user' => false,
              'exclude_from_search' => false,
              'capability_type' => 'post',
              'map_meta_cap' => true,
              'hierarchical' => false,
              'rewrite' => array(
                  'slug' => 'region/%region%',
                  'with_front' => true,
              ),
              'query_var' => true,
              'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'post-formats' ),
              'taxonomies' => array(),
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

    /**
     * Modify post_name for custom post type region_about
     */
    public static function set_custom_post_name( $post_ID, $post, $update ) {
        static $updating = false;
        if ( $update || $updating ) {
            return;
        }

        if ( $post->post_type == self::$post_type ) {
            $post_args = array(
                'ID' => $post_ID,
                'post_name' => 'about',
            );

            wp_update_post( $post_args );
        }
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Custom_Post_Type::load_module();
