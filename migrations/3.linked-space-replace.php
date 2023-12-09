<?php
/**
 * This migration is for removing spaces inside links
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

    $posts = $wpdb->get_results( "SELECT id, post_content FROM {$wpdb->posts} WHERE post_status = 'publish' ORDER BY id ASC" );

    foreach( $posts as $post ) {
        $content = $post->post_content;
        $updated = preg_replace( '~(<a[^>]+>)(\s+)(.*?</a>)~is', '$2$1$3', $post->post_content );

        if ( $post->post_content === $updated ) {
            continue;
        }

        $updated = esc_sql( $updated );

        $wpdb->query( "UPDATE {$wpdb->posts} SET post_content = '{$updated}' WHERE ID = " . absint( $post->id ) );
        echo WP_SITEURL .  "/?p={$post->id}\n";
    }
}
