<?php
/**
 * Category world handlers
 *
 * @package kedr-theme
 * @since 2.3
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_World {
    /**
     * Unique slug using for world category
     */
    public static $slug = 'world';

    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_filter( 'get_the_terms', array( __CLASS__, 'sort_categories' ), 10, 3 );
        add_filter( 'category_template', array( __CLASS__, 'include_archive' ) );
    }

    /**
     * Include custom archive template for world posts
     */
    public static function include_archive( $template ) {
        if ( ! is_feed() && is_category( self::$slug ) ) {
            $new_template = locate_template( array( 'templates/category-world.php' ) );

            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }

        return $template;
    }

    /**
     * Move world category to the end of list
     */
    public static function sort_categories( $terms, $post_id, $taxonomy ) {
        if ( ! is_array( $terms ) || $taxonomy !== 'category' ) {
            return $terms;
        }

        $sorted = array();

        foreach ( $terms as $term ) {
            if ( isset( $term->slug ) && self::$slug === $term->slug ) {
                $sorted[] = $term;
            } else {
                array_unshift( $sorted, $term );
            }
        }

        return $sorted;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_World::load_module();
