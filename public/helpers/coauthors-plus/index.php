<?php

/**
 * Return default class for author post link
 */
add_filter(
    'coauthors_posts_link',
    function( $args ) {
        $args['class'] = null;

        return $args;
    }
);

add_filter(
    'get_coauthors',
    function( $coauthors, $post_id ) {
        if ( ! has_category( 'news', $post_id ) ) {
            return $coauthors;
        }

        $updated = array();

        foreach ( $coauthors as $couathor ) {
            if ( in_array( $couathor->ID, wp_list_pluck( $updated, 'ID' ), true ) ) {
                continue;
            }

            if ( user_can( $couathor->ID, 'edit_pages' ) ) {
                $updated[] = get_user_by( 'login', 'editor' );
            }
        }

        return $updated;
    },
    10,
    2
);

add_filter(
    'coauthors_posts_link',
    function( $args, $author ) {
        if ( ! is_single() || ! has_category( 'news', get_queried_object_id() ) ) {
            return $args;
        }

        if ( empty( $author->data->user_login ) || ! $author->data->user_login === 'editor' ) {
            return $args;
        }

        $args['href'] = get_category_link( get_category_by_slug( 'news' ) );

        return $args;
    },
    10,
    2
);
