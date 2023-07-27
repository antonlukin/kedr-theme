<?php
/**
 * Blocks filters
 * All filters to replace core blocks default behavior
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Filters_Blocks {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'after_setup_theme', array( __CLASS__, 'register_custom_blocks' ) );
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'remove_block_styles' ) );

        add_filter( 'allowed_block_types_all', array( __CLASS__, 'disable_core_blocks' ), 20 );
        add_filter( 'block_type_metadata_settings', array( __CLASS__, 'remove_gallery_gaps' ) );
    }

    /**
     *
     */
    public static function register_custom_blocks() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        require_once get_stylesheet_directory() . '/blocks/details.php';
        require_once get_stylesheet_directory() . '/blocks/help.php';
        require_once get_stylesheet_directory() . '/blocks/reference.php';
        require_once get_stylesheet_directory() . '/blocks/related.php';
        require_once get_stylesheet_directory() . '/blocks/topnews.php';
    }

    /**
     * Remove default inline core/gallery block gap styles
     */
    public static function remove_gallery_gaps( $args ) {
        $callback = 'block_core_gallery_render';

        if ( isset( $args['render_callback'] ) && $args['render_callback'] === $callback ) {
            $args['render_callback'] = null;
        }

        return $args;
    }

    /**
     * Remove default Gutenberg styles and fonts
     */
    public static function remove_block_styles() {
        wp_dequeue_style( 'global-styles' );
        wp_dequeue_style( 'wp-webfonts' );
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
    }

    /**
     * Disable some core blocks
     */
    public static function disable_core_blocks( $allowed ) {
        $blocks = array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() );

        // foreach ( $blocks as $block ) {
        //     echo "'$block',\n";
        // }

        // Alloweed core blocks
        $allowed = array(
            'core/paragraph',
            'core/image',
            'core/embed',
            'core/separator',
            'core/spacer',
            'core/html',
            'core/code',
            // 'core/video',
            // 'core/audio',
            'core/quote',
            'core/list',
            'core/list-item',
            'core/gallery',
            'core/heading',
            'core/block',
        );

        // $allowed = array(
        //     // 'core/legacy-widget',
        //     // 'core/widget-group',
        //     // 'core/archives',
        //     // 'core/avatar',
        //     'core/block',
        //     // 'core/calendar',
        //     // 'core/categories',
        //     // 'core/comment-author-name',
        //     // 'core/comment-content',
        //     // 'core/comment-date',
        //     // 'core/comment-edit-link',
        //     // 'core/comment-reply-link',
        //     // 'core/comment-template',
        //     // 'core/comments',
        //     // 'core/comments-pagination',
        //     // 'core/comments-pagination-next',
        //     // 'core/comments-pagination-numbers',
        //     // 'core/comments-pagination-previous',
        //     // 'core/comments-title',
        //     // 'core/cover',
        //     // 'core/file',
        //     // 'core/gallery',
        //     // 'core/heading',
        //     // 'core/home-link',
        //     // 'core/image',
        //     // 'core/latest-comments',
        //     // 'core/latest-posts',
        //     // 'core/loginout',
        //     // 'core/navigation',
        //     // 'core/navigation-link',
        //     // 'core/navigation-submenu',
        //     // 'core/page-list',
        //     // 'core/pattern',
        //     // 'core/post-author',
        //     // 'core/post-author-biography',
        //     // 'core/post-author-name',
        //     // 'core/post-comments-form',
        //     // 'core/post-content',
        //     // 'core/post-date',
        //     // 'core/post-excerpt',
        //     // 'core/post-featured-image',
        //     // 'core/post-navigation-link',
        //     // 'core/post-template',
        //     // 'core/post-terms',
        //     // 'core/post-title',
        //     // 'core/query',
        //     // 'core/query-no-results',
        //     // 'core/query-pagination',
        //     // 'core/query-pagination-next',
        //     // 'core/query-pagination-numbers',
        //     // 'core/query-pagination-previous',
        //     // 'core/query-title',
        //     // 'core/read-more',
        //     // 'core/rss',
        //     // 'core/search',
        //     // 'core/shortcode',
        //     // 'core/site-logo',
        //     // 'core/site-tagline',
        //     // 'core/site-title',
        //     // 'core/social-link',
        //     // 'core/tag-cloud',
        //     // 'core/template-part',
        //     // 'core/term-description',
        //     // 'core/audio',
        //     // 'core/button',
        //     // 'core/buttons',
        //     // 'core/code',
        //     // 'core/column',
        //     // 'core/columns',
        //     // 'core/embed',
        //     // 'core/freeform',
        //     // 'core/group',
        //     // 'core/html',
        //     // 'core/list',
        //     // 'core/list-item',
        //     // 'core/media-text',
        //     // 'core/missing',
        //     // 'core/more',
        //     // 'core/nextpage',
        //     // 'core/page-list-item',
        //     'core/paragraph',
        //     // 'core/preformatted',
        //     // 'core/pullquote',
        //     // 'core/quote',
        //     // 'core/separator',
        //     // 'core/social-links',
        //     'core/spacer',
        //     // 'core/table',
        //     // 'core/text-columns',
        //     // 'core/verse',
        //     // 'core/video',
        //     // 'kedr/help',
        //     // 'kedr/details',
        //     // 'kedr/related',
        //     'core/post-comments',
        // );

        $whitelist = array();

        foreach ( $blocks as $block ) {
            list( $prefix, ) = explode( '/', $block );

            if ( $prefix !== 'core' || in_array( $block, $allowed, true ) ) {
                $whitelist[] = $block;
            }
        }

        return $whitelist;
    }
}

/**
 * Load current module environment
 */
Kedr_Filters_Blocks::load_module();
