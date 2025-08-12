<?php
/**
 * Subcategory archive handler.
 * Custom options for categories.
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Subcats {

    /**
     * Taxonomies, that have subcats
     *
     * @access  public
     * @var     array
     */
    public static $allowed_taxonomies = array( 'category', 'region' );

    /**
     * Unique meta
     *
     * @access  public
     * @var     string
     */
    public static $term_meta = '_kedr-subcats-options';

    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'admin_init', array( __CLASS__, 'add_options_fields' ) );
        add_filter( 'category_template', array( __CLASS__, 'include_archive' ) );
    }

    /**
     * Include custom archive template for categories with subcategries
     */
    public static function include_archive( $template ) {
        $children = self::get_subcategories();

        if ( ! is_feed() && ! empty( $children ) ) {
            $new_template = locate_template( array( 'templates/archive-subcats.php' ) );

            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }

        return $template;
    }

    /**
     * Add adminside edit form fields
     */
    public static function add_options_fields() {
        add_action( 'category_edit_form_fields', array( __CLASS__, 'print_options_row' ), 9 );
        add_action( 'edited_category', array( __CLASS__, 'save_options_meta' ) );

        add_action( 'region_edit_form_fields', array( __CLASS__, 'print_options_row' ), 9 );
        add_action( 'edited_region', array( __CLASS__, 'save_options_meta' ) );

        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_options_assets' ) );
    }

    /**
     * Display custom special options row
     */
    public static function print_options_row( $term ) {
        $options = (array) get_term_meta( $term->term_id, self::$term_meta, true );

        if ( empty( $options['attachment'] ) ) {
            $options['attachment'] = null;
        }

        include_once get_template_directory() . '/includes/views/subcats-options.php';
    }

    /**
     * Enqueue assets to term edit screen only
     */
    public static function enqueue_options_assets( $hook ) {
        $screen = get_current_screen();

        if ( $hook !== 'term.php' || ! in_array( $screen->taxonomy, self::$allowed_taxonomies, true ) ) {
            return;
        }

        $version = wp_get_theme()->get( 'Version' );

        wp_enqueue_media();

        wp_enqueue_script(
            'kedr-theme-subcats',
            get_template_directory_uri() . '/includes/scripts/subcats-options.js',
            array( 'jquery' ),
            $version,
            true
        );
    }

    /**
     * Save term options
     */
    public static function save_options_meta( $term_id ) {
        if ( ! current_user_can( 'edit_term', $term_id ) ) {
            return;
        }

        $options = array();

        if ( ! empty( $_REQUEST[ self::$term_meta ]['attachment'] ) ) {
            $options['attachment'] = absint( $_REQUEST[ self::$term_meta ]['attachment'] );
        }

        if ( empty( $options ) ) {
            return delete_term_meta( $term_id, self::$term_meta );
        }

        return update_term_meta( $term_id, self::$term_meta, $options );
    }

    /**
     * Get all subcategories for current screen term
     */
    public static function get_subcategories() {
        $term = get_queried_object();

        if ( empty( $term ) ) {
            return array();
        }

        $children = get_categories(
            array(
                'child_of'   => $term->term_id,
                'taxonomy'   => $term->taxonomy,
                'hide_empty' => false,
                'fields'     => 'ids',
            )
        );

        return $children;
    }

    /**
     * Get custom subcats cover
     */
    public static function get_image( $term_id, $size = 'card', $output = '' ) {
        if ( empty( $term_id ) ) {
            return null;
        }

        $options = (array) get_term_meta( $term_id, self::$term_meta, true );

        if ( ! empty( $options['attachment'] ) ) {
            $output = wp_get_attachment_image_url( $options['attachment'], $size );
        }

        return $output;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Subcats::load_module();
