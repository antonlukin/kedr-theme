<?php
/**
 * Content filters
 * Show additional content blocks and fix small problems on post save.
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Content {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_filter( 'content_save_pre', array( __CLASS__, 'remove_linked_space' ) );
        add_filter( 'content_save_pre', array( __CLASS__, 'add_links_target' ) );
        add_filter( 'the_content', array( __CLASS__, 'add_map_promo' ) );
    }

    /**
     * Remove linked spaces
     */
    public static function remove_linked_space( $content ) {
        $content = preg_replace( '~(<a[^>]+>)(\s+)(.*?</a>)~is', '$2$1$3', wp_unslash( $content ) );

        return wp_slash( $content );
    }

    /**
     * Add target attr to links
     */
    public static function add_links_target( $content ) {
        $content = links_add_target( wp_unslash( $content ) );

        return wp_slash( $content );
    }

    /**
     * Add custom extra block for Map promo.
     *
     * @since 2.3
     */
    public static function add_map_promo( $content ) {
        $extra = get_theme_mod( 'extra-map' );

        if ( empty( $extra ) ) {
            return $content;
        }

        global $post;

        if ( ! property_exists( 'Kedr_Modules_Regions', 'taxonomy' ) ) {
            return $content;
        }

        if ( ! has_term( '', Kedr_Modules_Regions::$taxonomy, $post ) ) {
            return $content;
        }

        $ecologo = file_get_contents( get_template_directory() . '/assets/images/ecomap.svg' );

        $extra = sprintf(
            '<figure class="frame-promo frame-promo--map"><div class="frame-promo--map__logo">%1$s</div>%2$s<a class="frame-promo--map__button button" href="https://maps.kedr.media/" target="_blank" rel="noopener">Читать</a></figure>',
            $ecologo,
            wpautop( strip_tags( $extra, '<a>' ) )
        );

        return $content . $extra;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Content::load_module();
