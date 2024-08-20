<?php

$query       = kedr_theme_get( 'taxonomy_articles' );
$region_tax  = kedr_theme_get( 'region_taxonomy' );
$frame_args  = array( 'add_region_label' => ! isset( $region_tax ) );
$frame_types = array( 'single', 'double', 'triple' );

if ( $query->have_posts() ) {
    $total_posts = $query->post_count;

    for ( $count = 0, $frame_size = 0; $count < $total_posts; $count += $frame_size ) {
        $frame_size = kedr_theme_get( 'post_row_size', $total_posts, $total_posts - $count );
        if ( $frame_size <= 0 ) {
            break;
        }

        $frame_type = $frame_types[ $frame_size - 1 ];
        echo '<div class="frame-' . $frame_type . ' frame-' . $frame_type . '--ecomap">'; // phpcs:ignore
        for ( $i = 0; $i < $frame_size; $i++ ) {
            if ( ! $query->have_posts() ) {
                break;
            }
            $query->the_post();
            get_template_part( 'templates/frame', $frame_type, $frame_args );
        }
        echo '</div>';
    }

    wp_reset_postdata();
}

if ( ! isset( $region_tax ) ) {
    $region_tax = 'all';
}

if ( $query->max_num_pages > 1 ) :
    $navigate_url = home_url( '/region/' . $region_tax . '/' );
    ?> 
            <nav class="navigate navigate--more">
                <a href="<?php echo $navigate_url; ?>" class="navigate__button button" data-page="2">
                <?php
                echo esc_html__( 'Показать еще', 'kedr-theme' );
                ?>
                </a>   
            </nav>
        <?php
        endif;
?>
