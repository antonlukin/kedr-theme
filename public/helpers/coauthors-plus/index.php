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

/**
 *  Replace coauthor name in news
 */
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

/**
 * Replace coauthor link in news
 */
add_filter(
    'coauthors_posts_link',
    function( $args, $author ) {
        global $post;

        if ( ! is_single() || ! has_category( 'news', $post->ID ) ) {
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

/**
 * Search posts by authors
 *
 * @link https://gist.github.com/danielbachhuber/7126249
 */
add_filter(
    'posts_search',
    function( $where ) {
        if ( is_admin() || ! is_search() ) {
            return $where;
        }

        $query = get_query_var( 's' );

        if ( empty( $query ) ) {
            return $where;
        }

        $users = get_users(
            array(
                'search'         => sprintf( '*%s*', $query ),
                'search_columns' => array( 'display_name' ),
                'fields'         => 'user_login',
            )
        );

        if ( empty( $users ) ) {
            return $where;
        }

        $args = array(
            'post_type' => 'post',
            'tax_query' => array( // phpcs:ignore
                array(
                    'taxonomy' => 'author',
                    'field'    => 'name',
                    'terms'    => $users,
                ),
            ),
            'fields'    => 'ids',
        );

        $posts = implode( ',', get_posts( $args ) );

        return str_replace( ')))', ")) OR (wp_posts.ID IN ({$posts})))", $where );
    }
);
