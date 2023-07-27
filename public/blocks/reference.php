<?php
/**
 * Reference element
 * Add reference block to post editor
 *
 * @package kedr-theme
 * @version 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_Reference {
    /**
     * Init function instead of constructor
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'register_block' ) );
    }

    /**
     * Register new reference block
     */
    public static function register_block() {
        register_block_type( dirname( __DIR__ ) . '/build/reference' );
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_Reference::load_module();
