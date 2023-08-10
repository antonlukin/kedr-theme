<?php
/**
 * Regions for map
 * Custom regions taxonomy settings
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Regions {
    /**
     * Unique slug using for taxonomy register and url
     *
     * @access  public
     * @var     string
     */
    public static $taxonomy = 'region';

    /**
     * Default post type with project taxonomy
     *
     * @access  public
     * @var     array
     */
    public static $post_type = array( 'post' );

    /**
     * Use this method instead of constructor to avoid setting multiple hooks
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
    }

    /**
     * Create custom taxonomy
     */
    public static function register_taxonomy() {
        register_taxonomy(
            self::$taxonomy,
            self::$post_type,
            array(
                'labels'            => array(
                    'name'              => esc_attr__( 'Регионы', 'kedr-theme' ),
                    'singular_name'     => esc_attr__( 'Регион', 'kedr-theme' ),
                    'search_items'      => esc_attr__( 'Искать регион', 'kedr-theme' ),
                    'all_items'         => esc_attr__( 'Все регионы', 'kedr-theme' ),
                    'view_item '        => esc_attr__( 'Открыть регион', 'kedr-theme' ),
                    'parent_item'       => esc_attr__( 'Родитель', 'kedr-theme' ),
                    'parent_item_colon' => esc_attr__( 'Родитель:', 'kedr-theme' ),
                    'edit_item'         => esc_attr__( 'Редактировать регионы', 'kedr-theme' ),
                    'update_item'       => esc_attr__( 'Обновить регионы', 'kedr-theme' ),
                    'add_new_item'      => esc_attr__( 'Добавить регионы', 'kedr-theme' ),
                    'new_item_name'     => esc_attr__( 'Имя региона', 'kedr-theme' ),
                    'menu_name'         => esc_attr__( 'Регионы', 'kedr-theme' ),
                    'back_to_items'     => esc_attr__( 'Назад в регионы', 'kedr-theme' ),
                ),
                'description'       => '',
                'public'            => true,
                'hierarchical'      => true,
                'rewrite'           => true,
                'capabilities'      => array(),
                'meta_box_cb'       => null,
                'show_admin_column' => false,
                'show_in_rest'      => true,
                'rest_base'         => 'regions',
            )
        );
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Regions::load_module();
