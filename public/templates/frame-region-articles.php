<?php

$query       = kedr_theme_get( 'taxonomy_articles' );
$frame_args  = array( 'add_region_label' => kedr_theme_get( 'add_region_label' ) );
$frame_types = array( 'single', 'double', 'triple' );

if ( $query->have_posts() ) {
    $total_posts = $query->post_count;

    for ( $count = 0; $count < $total_posts; $count += $frame_size ) {
        $frame_size = kedr_theme_get( 'post_row_size', $total_posts, $total_posts - $count );
        if ( $frame_size <= 0 ) {
            break;
        }

        $frame_type = $frame_types[ $frame_size - 1 ];
        echo '<div class="frame-' . $frame_type . ' frame-' . $frame_type . '--ecomap">'; // phpcs:ignore
        for ( $i = 0; $i < $frame_size; $i++ ) {
            $query->the_post();
            get_template_part( 'templates/frame', $frame_type, $frame_args );
        }
        echo '</div>';
    }

    wp_reset_postdata();
}
