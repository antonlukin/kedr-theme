<?php
/**
 * Postinfo filters
 * Helper class for template-tags to get post info inside loop
 * Use get_ prefix for public methods
 *
 * @package kedr-theme
 * @since 2.0
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Postsettings {
    /**
     * Get navigation mod
     */
    public static function get_navigation_mod( $output = '' ) {
        global $wp;

        if ( isset( $wp->query_vars['region'] ) ) {
            $current_url           = home_url( $wp->request );
            $taxonomy_base_url     = home_url( Kedr_Modules_Regions::get_addr( $wp->query_vars['region'] ) );
            $region_about_base_url = home_url( Kedr_Modules_Region_About::get_addr( $wp->query_vars['region'] ) );

            // temporary hide header/footer for ecomap
            if ( /* $current_url === $taxonomy_base_url || */ $current_url === $region_about_base_url ) {
                return 'ecomap';
            }
        }
        return $output;
    }
}
