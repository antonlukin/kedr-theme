<?php

add_filter(
    'coauthors_posts_link',
    function( $args ) {
        $args['class'] = null;

        return $args;
    }
);
