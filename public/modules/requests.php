<?php
/**
 * Requests handler
 * Handle all forms request from front-end
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Requests {
    /**
     * Store custom table options
     *
     * @access  private
     * @var     string
     */
    private static $options = null;

    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'rest_api_init', array( __CLASS__, 'register_rest_routes' ) );
        add_action( 'after_switch_theme', array( __CLASS__, 'create_table' ) );
        add_action( 'admin_menu', array( __CLASS__, 'add_mailing_page' ), 25 );
    }

    /**
     * Register requests routers
     */
    public static function register_rest_routes() {
        register_rest_route(
            'kedr-requests/v1',
            '/mailing',
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( __CLASS__, 'process_mailing_request' ),
                'permission_callback' => '__return_true',
            )
        );
    }

    public static function add_mailing_page() {
        $hookname = add_management_page(
            esc_html__( 'Адреса рассылки', 'kedr-theme' ),
            esc_html__( 'Адреса рассылки', 'kedr-theme' ),
            'edit_pages',
            'kedr-mailing',
            array( __CLASS__, 'display_mailing_page' )
        );
    }

    /**
     * Display management page
     */
    public static function display_mailing_page() {
        include_once get_template_directory() . '/includes/tables/requests-mailing.php';

        // Get mailing table instance
        $table = new Kedr_Requests_Mailing_Table();
        $table->prepare_items();

        include_once get_template_directory() . '/includes/views/requests-mailing.php';
    }

    /**
     * Process mailing request
     */
    public static function process_mailing_request( $request ) {
        $content = $request->get_param( 'email' );

        if ( ! is_email( $content ) ) {
            return self::show_error( esc_html__( 'Неверный формат адреса почты', 'kedr-theme' ) );
        }

        $exists = self::check_field( 'email', $content, 'mailing' );

        if ( ! empty( $exists ) ) {
            return self::show_error( esc_html__( 'Адрес уже подписан на рассылку', 'kedr-theme' ) );
        }

        $result = self::add_field( 'email', $content, 'mailing' );

        if ( ! empty( $result ) ) {
            return self::show_success( esc_html__( 'Адрес успешно сохранен', 'kedr-theme' ) );
        }

        return self::show_error( esc_html__( 'Не удалось сохранить адрес почты. Попробуйте позже', 'kedr-theme' ) );
    }

    /**
     * Create custom requests table on theme switch
     */
    public static function create_table() {
        global $wpdb;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $query = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}requests (
            id int(11) NOT NULL AUTO_INCREMENT,
            form varchar(128) NOT NULL,
            field varchar(256) NOT NULL,
            content text NOT NULL,
            ip varchar(128) NOT NULL,
            created datetime NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (id),
            KEY form (form)
        )
        DEFAULT CHARACTER SET {$wpdb->charset}";

        // We do not use dbDelta here cause of DESCRIBE error
        $wpdb->query( $query ); // phpcs:ignore
    }

    /**
     * Show error response
     */
    private static function show_error( $message, $status = 400 ) {
        return new WP_REST_Response( array( 'message' => $message ), $status );
    }

    /**
     * Show success response
     */
    private static function show_success( $message, $status = 200 ) {
        return new WP_REST_Response( array( 'message' => $message ), $status );
    }

    /**
     * Add requests fields to database
     */
    private static function add_field( $field, $content, $form ) {
        global $wpdb;

        $ip = null;

        if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            $ip = wp_unslash( $_SERVER['REMOTE_ADDR'] ); // phpcs:ignore
        }

        $values = array(
            'field'   => $field,
            'content' => $content,
            'form'    => $form,
            'ip'      => $ip,
        );

        return $wpdb->insert( $wpdb->prefix . 'requests', $values ); // phpcs:ignore
    }

    /**
     * Check if field already exists in database
     */
    private static function check_field( $field, $content, $form ) {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}requests WHERE field = %s AND content = %s AND form = %s",
            array( $field, $content, $form )
        );

        // phpcs:ignore
        return $wpdb->get_var( $query );
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Requests::load_module();
