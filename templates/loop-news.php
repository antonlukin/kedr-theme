<?php
if ( $args['selected_news'] ):
	$amount_post  = 4;
	$news_counter = 1;
else:
	$amount_post  = 6;
	$news_counter = 0;
endif;

$has_thumb = false;
?>
<div class="container">
    <section class="news">
        <div class="row h-100">
			<?php
			$news_args = array(
				'posts_per_page' => $amount_post,
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'post__not_in'   => array( $args['select_news']->ID ),
				'tax_query'      => array(
					'relation' => 'AND',
					array(
						'taxonomy'         => 'category',
						'field'            => 'term_id',
						'terms'            => 1133,
						'operator'         => 'IN',
						'include_children' => true
					)
				)
			);

			$news_query = new WP_Query( $news_args );
			if ( $news_query->have_posts() ):
				if ( $args['selected_news'] ): ?>
                    <div class="col-12 col-lg-4">
						<?php
						$post = $args['select_news'];
						//                $post['selected_news'] = true;
						get_template_part( 'templates/cards/news', '', $post ); ?>
                    </div>
                    <div class="col-12 col-lg-8">
                    <div class="row h-100 news-rest">
				<?php endif;

				while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
					<?php if ( $args['selected_news'] ): ?>
                        <div class="col-12 col-lg-6 ">
							<?php get_template_part( 'templates/cards/news' ); ?>
                        </div>
					<?php else: ?>
                        <div class="col-12 col-lg-4 <?php if ( $news_counter > 3 ): echo "d-none d-md-flex"; endif; ?>">
							<?php get_template_part( 'templates/cards/news' ); ?>
                        </div>
					<?php endif; ?>

					<?php
					$news_counter += 1;
				endwhile;
				if ( $args['selected_news'] ): ?>
                    </div>
                    </div>
				<?php endif;
			endif;
			$news_query->reset_postdata(); ?>
        </div>
    </section>
</div>

<?php get_template_part( 'templates/section', 'subscribe' ); ?>