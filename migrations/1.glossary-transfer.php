<?php
/**
 * This migration is for replacing old glossary fields with new kedr/reference block
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

    $results = $wpdb->get_results(
        "SELECT post_id, meta_key, meta_value FROM wp_posts, wp_postmeta
        WHERE wp_posts.ID = wp_postmeta.post_id AND post_status = 'publish'
        AND meta_key LIKE 'post_glossary_%_keyword' ORDER BY ID DESC"
    );

    foreach ( $results as $result ) {
        $id = str_replace( 'post_glossary_', '', str_replace( '_keyword', '', $result->meta_key ) );

        $keyword = $result->meta_value;
        $description = get_post_meta( $result->post_id, "post_glossary_{$id}_description", true );

        $content = $wpdb->get_var( "SELECT post_content FROM wp_posts WHERE ID = " . absint($result->post_id) );

        // Skip already updated keywords
        if ( preg_match( '~wp-block-kedr-reference">' . preg_quote( $keyword, '~' ) . '</span>~', $content ) ) {
            echo 'skipped: ' . $keyword . " - " . WP_SITEURL .  "/?p={$result->post_id}\n";
            continue;
        }

        $wrapped = '<span data-reference="' . $description . '" class="wp-block-kedr-reference">' . $keyword . '</span>';

        $content = preg_replace( '~' . preg_quote( $keyword, '~' ) . '~', $wrapped, $content, 1 );
        $content = esc_sql( $content );

        $wpdb->query("UPDATE {$wpdb->posts} SET post_content = '{$content}' WHERE ID = " . absint($result->post_id));
        echo $keyword . " - " . WP_SITEURL .  "/?p={$result->post_id}\n";
    }
}
