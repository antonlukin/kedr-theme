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
        add_action( 'admin_menu', array( __CLASS__, 'add_donation_page' ), 25 );

        add_filter( 'the_content', array( __CLASS__, 'append_donation_form' ), 20 );
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

        register_rest_route(
            'kedr-requests/v1',
            '/canceling',
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( __CLASS__, 'process_canceling_request' ),
                'permission_callback' => '__return_true',
            )
        );
    }

    /**
     * Add mailing addresses page
     */
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
     * Add canceling recurrent donations page
     */
    public static function add_donation_page() {
        $hookname = add_management_page(
            esc_html__( 'Отмена платежей', 'kedr-theme' ),
            esc_html__( 'Отмена платежей', 'kedr-theme' ),
            'edit_pages',
            'kedr-canceling',
            array( __CLASS__, 'display_canceling_page' )
        );
    }

    /**
     * Display mailing page
     */
    public static function display_mailing_page() {
        include_once get_template_directory() . '/includes/tables/requests-mailing.php';

        // Get mailing table instance
        $table = new Kedr_Requests_Mailing_Table();
        $table->prepare_items();

        include_once get_template_directory() . '/includes/views/requests-mailing.php';
    }

    /**
     * Display recurrent page
     */
    public static function display_canceling_page() {
        include_once get_template_directory() . '/includes/tables/requests-canceling.php';

        // Get recurrent table instance
        $table = new Kedr_Requests_Canceling_Table();
        $table->prepare_items();

        include_once get_template_directory() . '/includes/views/requests-canceling.php';
    }

    public static function append_donation_form( $content ) {
        if ( ! is_page( 'cancel-donation' ) ) {
            return $content;
        }

        ob_start();

        get_template_part( 'templates/frame', 'canceling' );

        $output = sprintf(
            '<div class="frame-canceling">%s</div>',
            ob_get_clean()
        );

        return $content . $output;
    }

    /**
     * Process mailing request
     */
    public static function process_mailing_request( $request ) {
        $content = $request->get_param( 'email' );

        if ( ! is_email( $content ) ) {
            return new WP_REST_Response( array( 'message' => esc_html__( 'Неверный формат адреса почты', 'kedr-theme' ) ), 400 );
        }

        $exists = self::find_row( $content, 'mailing' );

        if ( ! empty( $exists ) ) {
            return new WP_REST_Response( array( 'message' => esc_html__( 'Адрес уже подписан на рассылку', 'kedr-theme' ) ), 400 );
        }

        $result = self::add_row( $content, 'mailing' );

        if ( ! empty( $result ) ) {
            return new WP_REST_Response( array( 'message' => esc_html__( 'Адрес успешно сохранен', 'kedr-theme' ) ), 200 );
        }

        return new WP_REST_Response( array( 'message' => esc_html__( 'Не удалось сохранить адрес почты. Попробуйте позже', 'kedr-theme' ) ), 500 );
    }

    /**
     * Process canceling request
     */
    public static function process_canceling_request( $request ) {
        $content = $request->get_param( 'first' ) . '...' . $request->get_param( 'last' );

        $exists = self::find_row( $content, 'canceling' );

        if ( ! empty( $exists ) ) {
            return new WP_REST_Response( array( 'message' => esc_html__( 'Номер карты уже исключен', 'kedr-theme' ) ), 400 );
        }

        $result = self::add_row( $content, 'canceling' );

        if ( ! empty( $result ) ) {
            return new WP_REST_Response( array( 'message' => esc_html__( 'Номер карты записан и вскоре будет исключен', 'kedr-theme' ) ), 200 );
        }

        return new WP_REST_Response( array( 'message' => esc_html__( 'Не удалось записать номер карты. Попробуйте позже', 'kedr-theme' ) ), 500 );
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
     * Add requests fields to database
     */
    private static function add_row( $content, $form ) {
        global $wpdb;

        $ip = null;

        if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            $ip = wp_unslash( $_SERVER['REMOTE_ADDR'] ); // phpcs:ignore
        }

        $values = array(
            'content' => $content,
            'form'    => $form,
            'ip'      => $ip,
        );

        return $wpdb->insert( $wpdb->prefix . 'requests', $values ); // phpcs:ignore
    }

    /**
     * Check if field already exists in database
     */
    private static function find_row( $content, $form ) {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}requests WHERE content = %s AND form = %s",
            array( $content, $form )
        );

        // phpcs:ignore
        return $wpdb->get_var( $query );
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Requests::load_module();
