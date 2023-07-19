<div class="container">
    <section class="podcasts">
        <div class="podcasts-header">
            <h3>Подкасты</h3>
        </div>

        <div class="col-12">
            <div class="row">
                <?php
                $args  = array(
                    'posts_per_page' => 4,
                    'post_type'      => 'post',
                    'category_name'  => 'podcast'
                );

                $current = 0;
                $query = new WP_Query( $args );

                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) :
                        $query->the_post();

                        echo '<div class="col-12 col-lg-6 col-xl-3 postcasts-item">';
                        get_template_part( 'templates/cards/podcast', null, $query->found_posts - $current++ );
                        echo '</div>';

                    endwhile;
                    wp_reset_postdata(); ?>

                <?php endif; ?>
            </div>
        </div>
    </section>
</div>