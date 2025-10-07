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
        add_filter( 'the_content', array( __CLASS__, 'prepend_help_block' ), 5 );
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
     * Prepend the mandatory help block to post content.
     *
     * @param string $content Post content.
     *
     * @return string
     */
    public static function prepend_help_block( $content ) {
        if ( is_admin() && ! wp_doing_ajax() ) {
            return $content;
        }

        global $post;

        if ( empty( $post ) || $post->post_type !== 'post' ) {
            return $content;
        }

        $help_text = esc_html__( 'НАСТОЯЩИЙ МАТЕРИАЛ (ИНФОРМАЦИЯ) ПРОИЗВЕДЕН И РАСПРОСТРАНЕН ИНОСТРАННЫМ АГЕНТОМ «КЕДР.МЕДИА» ЛИБО КАСАЕТСЯ ДЕЯТЕЛЬНОСТИ ИНОСТРАННОГО АГЕНТА «КЕДР.МЕДИА». 18+', 'kedr-theme' );

        $block = sprintf(
            '<div class="wp-block-kedr-help"><p>%s</p></div>' . "\n",
            wp_kses_post( $help_text )
        );

        return $block . ltrim( $content );
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

        $extra = sprintf(
            '<figure class="frame-promo frame-map"><div class="frame-map__logo"></div>%1$s<a class="frame-map__button button" href="https://kedr.media/regions/" target="_blank" rel="noopener">%2$s</a></figure>',
            wpautop( strip_tags( $extra, '<a>' ) ),
            esc_html__( 'Читать', 'kedr-theme' )
        );

        return $content . $extra;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Content::load_module();
