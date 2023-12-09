<?php
/**
 * This migration is for regenerating snippet posters for all posts
 */

if ( php_sapi_name() !== 'cli' ) {
    exit;
}

$_SERVER = array(
    "SERVER_PROTOCOL" => "HTTP/1.1",
    "HTTP_HOST"       => "kedr.media",
    "SERVER_NAME"     => "kedr.media",
    "REQUEST_URI"     => "/",
    "REQUEST_METHOD"  => "GET",
    "PHP_SELF"        => "",
);

define( 'WP_CACHE', false );
define( 'WP_DEBUG', true );
define( 'WP_USE_THEMES', false );

require( __DIR__ . '/../wordpress/wp-load.php' );


{
    global $wpdb;

    $posts = $wpdb->get_results(
        "SELECT id FROM wp_posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY ID DESC"
    );

    foreach ( $posts as $post ) {
        if ( ! method_exists( 'Kedr_Modules_Snippet', 'generate_poster' ) ) {
            break;
        }

        Kedr_Modules_Snippet::generate_poster( $post->id );

        echo  WP_SITEURL .  "/?p={$post->id}\n";
    }
}
