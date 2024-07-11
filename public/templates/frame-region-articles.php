<?php

$query            = kedr_theme_get( 'taxonomy_articles' );
$add_region_label = kedr_theme_get( 'add_region_label' );

if ( $query->have_posts() ) {
    $total_posts = $query->post_count;
    $count       = 0;
    $frame_start = true;
    $frame_end   = true;
    $frame_type  = 'single';
    while ( $query->have_posts() ) {
        $query->the_post();

        // start frame after previous end
        $frame_start = $frame_end;
        $frame_end   = false;

        // resolve $frame_end $frame_type
        if ( $total_posts == 1 ) {
            // only one post
            $frame_end = true;
        } elseif ( $total_posts == 2 ) {
            // only 2 posts
            $frame_type = 'double';
            if ( $count == 0 ) {
                $frame_end = false;
            } else {
                $frame_end = true;
            }
        } elseif ( $total_posts == 3 ) {
            // only 3 posts
            $frame_type = 'triple';
            if ( $count == 0 ) {
                $frame_end = false;
            }
            if ( $count == 2 ) {
                $frame_end = true;
            }
        } elseif ( $count == 0 ) {
            // first post as single
            $frame_start = true;
            $frame_end   = true;
            $frame_type  = 'single';
        } elseif ( $frame_start ) {
            // if frame started
            if ( $count <= $total_posts - 5 ) {
                // if it possible to left at least 2 posts at the end
                $frame_type = 'triple';
                $frame_end  = false;
            } elseif ( $count == $total_posts - 4 ) {
                // only 4 posts left
                $frame_type = 'double';
                $frame_end  = false;
            } elseif ( $count == $total_posts - 3 ) {
                // only 3 posts left
                $frame_type = 'triple';
                $frame_end  = false;
            } elseif ( $count == $total_posts - 2 ) {
                // only 2 posts left
                $frame_type = 'double';
                $frame_end  = false;
            } elseif ( $count == $total_posts - 1 ) {
                // it's imposible
                $frame_type = 'single';
                $frame_end  = true;
            }
        } else {
            // if we are in the middle of frame
            if ( $count % 3 == 0 ) {
                // finish triple
                $frame_end = true;
            } elseif ( $count == $total_posts - 3 ) {
                // finish frame to left 2 at the end
                $frame_end = true;
            } elseif ( $count == $total_posts - 1 ) {
                // finish on last post
                $frame_end = true;
            }
        }

        $frame_args = array( 'add_region_label' => $add_region_label );
        if ( $frame_start ) {
            echo '<div class="frame-' . $frame_type . ' frame-' . $frame_type . '--ecomap">';
        }
        get_template_part( 'templates/frame', $frame_type, $frame_args );
        if ( $frame_end ) {
            echo '</div>';
        }

        ++$count;

    }

    wp_reset_postdata();
}
