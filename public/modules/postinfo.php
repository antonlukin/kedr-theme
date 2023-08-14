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

class Kedr_Modules_Postinfo {
    /**
     * Get link to parent category
     */
    public static function get_category( $output = '' ) {
        $categories = get_the_category();

        if ( empty( $categories ) ) {
            return null;
        }

        $category = $categories[0];

        // Get only the first category
        $cat_id = $category->term_id;

        if ( ! empty( $category->parent ) ) {
            $ancestors = get_ancestors( $category->term_id, 'category' );

            // Get top level category id
            $cat_id = end( $ancestors );
        }

        $output = sprintf(
            '<a href="%s" title="%s">%s</a>',
            esc_url( get_category_link( $cat_id ) ),
            esc_html__( 'Открыть все записи из категории', 'kedr-theme' ),
            esc_html( get_cat_name( $cat_id ) )
        );

        return $output;
    }

    /**
     * Get list of post authors
     */
    public static function get_authors( $output = '' ) {
        if ( function_exists( 'coauthors_posts_links' ) ) {
            $output = coauthors_posts_links( ', ', ', ', null, null, false );
        }

        return $output;
    }

    /**
     * Get post excerpt if exists
     */
    public static function get_excerpt( $output = '' ) {
        if ( has_excerpt() ) {
            $output = apply_filters( 'the_excerpt', get_the_excerpt() );
        }

        return $output;
    }

    /**
     * Get post publish date
     */
    public static function get_date() {
        return esc_html( get_the_date() );
    }

    /**
     * Get thumbnail caption
     */
    public static function get_caption( $output = '' ) {
        $caption = get_the_post_thumbnail_caption();

        if ( ! empty( $caption ) ) {
            $output = esc_html( $caption );
        }

        return $output;
    }

    /**
     * Get thumbnail caption with label
     */
    public static function get_labelcaption( $output = '' ) {
        $caption = get_the_post_thumbnail_caption();

        if ( ! empty( $caption ) ) {
            $output = esc_html( __( 'Фото: ', 'kedr-theme' ) . $caption );
        }

        return $output;
    }

    /**
     * Get oEmbed code for first video from post content
     */
    public static function get_video( $output = '' ) {
        $url = self::parse_video_url( get_the_content() );

        if ( ! empty( $url ) ) {
            $output = wp_oembed_get( $url );
        }

        return $output;
    }

    /**
     * Get custom video lead from block
     */
    public static function get_videolead( $output = '' ) {
        if ( property_exists( 'Kedr_Blocks_Videolead', 'meta' ) ) {
            $output = get_post_meta( get_the_ID(), Kedr_Blocks_Videolead::$meta, true );

            if ( ! empty( $output ) ) {
                return apply_filters( 'the_excerpt', $output );
            }
        }

        return self::get_excerpt();
    }

    /**
     * Get extrameta from customizer settings
     */
    public static function get_extrameta( $output = '' ) {
        $meta = get_theme_mod( 'extra-meta' );

        if ( ! empty( $meta ) ) {
            $output = $meta;
        }

        return $output;
    }

    /**
     * Get first url to YouTube video from content blocks
     */
    private static function parse_video_url( $content ) {
        if ( ! has_blocks( $content ) ) {
            return null;
        }

        $blocks = parse_blocks( $content );

        foreach ( $blocks as $block ) {
            if ( empty( $block['blockName'] ) || $block['blockName'] !== 'core/embed' ) {
                continue;
            }

            if ( empty( $block['attrs']['providerNameSlug'] ) ) {
                continue;
            }

            if ( $block['attrs']['providerNameSlug'] !== 'youtube' ) {
                continue;
            }

            if ( empty( $block['attrs']['url'] ) ) {
                continue;
            }

            return $block['attrs']['url'];
        }

        return null;
    }
}
