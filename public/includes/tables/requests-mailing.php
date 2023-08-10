<?php
/**
 * Requests mailing table class
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Kedr_Requests_Mailing_Table extends WP_List_Table {
    /**
     * Requests mailing table constructor
     */
    public function __construct() {
        parent::__construct(
            array(
                'plural' => 'mailing',
                'ajax'   => false,
            )
        );

        $this->screen = get_current_screen();
    }

    /**
     * Default column render
     */
    public function column_default( $item, $column_name ) {
        if ( isset( $item[ $column_name ] ) ) {
            return $item[ $column_name ];
        }

        return null;
    }

    /**
     * Get columns to show in the list table.
     */
    public function get_columns() {
        $columns = array(
            'email'   => esc_html__( 'E-mail', 'kedr-theme' ),
            'created' => esc_html__( 'Дата добавления', 'kedr-theme' ),
            'ip'      => esc_html__( 'IP-адрес', 'kedr-theme' ),
        );

        return $columns;
    }

    /**
     * Get rows from database and prepare them to be showed in table
     */
    public function prepare_items() {
        global $wpdb;

        $current_page = $this->get_pagenum();
        $limit        = 20;
        $offset       = ( $current_page - 1 ) * $limit;

        // phpcs:ignore
        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT SQL_CALC_FOUND_ROWS * FROM {$wpdb->prefix}requests WHERE form = 'mailing' ORDER BY id DESC LIMIT %d, %d",
                array( $offset, $limit )
            )
        );

        if ( ! $wpdb->last_error ) {
            $total_count = $wpdb->get_var( 'SELECT FOUND_ROWS()' ); // phpcs:ignore
        }

        foreach ( $results as $result ) {
            $item = array(
                'email'   => $result->content,
                'created' => $result->created,
                'ip'      => $result->ip,
            );

            $this->items[] = $item;
        }

        $this->set_pagination_args(
            array(
                'total_items' => $total_count,
                'per_page'    => $limit,
            )
        );

        $this->_column_headers = array( $this->get_columns() );
    }
}
