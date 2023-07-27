<?php
/**
 * Details element
 * Add details block to post editor
 *
 * @package kedr-theme
 * @version 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_Details {
    /**
     * Init function instead of constructor
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'register_block' ) );
    }

    /**
     * Register new details block
     */
    public static function register_block() {
        register_block_type( __DIR__ . '/build/details' );
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_Details::load_module();
