<?php
$options           = get_field( 'frontpage-latestpost', 'option' );
$primary_end       = get_field( 'primary_end', 'option' );
$frontpage_project = get_field( 'frontpage-project', 'option' );
$frontpage_news    = get_field( 'frontpage-news', 'option' );

if ( $primary_end['select_post'] ) {
	$args = array(
		'posts_per_page' => $options['posts_per_page'],
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'post__not_in'   => array( $primary_end['select_post']->ID ),
		'tax_query'      => array(
			'relation' => 'AND',
			array(
				'taxonomy'         => 'category',
				'field'            => 'term_id',
				'terms'            => array( 4, 64, 1133, 5 ),
				'operator'         => 'NOT IN',
				'include_children' => true
			)
		)
	);
} else {
	$args = array(
		'posts_per_page' => $options['posts_per_page'],
		'post_type'      => 'post',
		'post_status'    => 'publish',
//		'category__not_in' => array( 4, 5, 64 ),
		'tax_query'      => array(
			'relation' => 'AND',
			array(
				'taxonomy'         => 'category',
				'field'            => 'term_id',
				'terms'            => array( 4, 64, 1133, 5 ),
				'operator'         => 'NOT IN',
				'include_children' => true
			)
		)
	);
}
//    Исключение материалов проектов из ленты
if ( $frontpage_project['has_block'] ):
	$frontapage_project_args = array(
		'taxonomy' => 'project',
		'field'    => 'id',
		'operator' => 'NOT IN',
		'terms'    => array( $frontpage_project['taxonomy'] )
	);
	$args['tax_query'][]     = $frontapage_project_args;
endif;

$query          = new WP_Query( $args );
$counter        = 0;
$has_news_block = false;

$sticky_posts = get_option( 'sticky_posts' );
// Увеличиваем кол-во материалов в ленте если зафиксировано видео/новость/..
if ( $sticky_posts and in_category( array( 4, 64, 1133, 5 ), $sticky_posts[0] ) ) {
	$options['posts_per_page'] += 1;
}
?>

<div class="container">
	<div class="row">
		<?php if ( $query->have_posts() ):
			while ( $query->have_posts() ) : $query->the_post();

				if ( $counter < $options['primary_posts'] ): ?>

					<?php if ( $options['primary_posts'] > 1 ):
						if ( $counter == 0 ):
							$cols = 'col-12 col-md-8';
						else:
							$cols = 'col-12 col-md-4';
						endif;
					else:
						$cols = 'col-12 full-width';
					endif; ?>

					<div class="<?php echo $cols; ?>">
						<?php get_template_part( 'templates/cards/primary' ); ?>
					</div>

				<?php elseif ( $primary_end['has_block'] and $counter + 1 == $options['posts_per_page'] ):

					if ( ! $primary_end['selected_post'] ): ?>
						<div class="col-12">
							<?php get_template_part( 'templates/cards/primary' ); ?>
						</div>
					<?php else:
						$post = $primary_end['select_post']; ?>
						<div class="col-12">
							<?php get_template_part( 'templates/cards/primary', false, $post ); ?>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<?php
					//                После главных постов выводим новости

					if ( ! $has_news_block and $frontpage_news['has_block'] ):
						$current_post = $post;
						get_template_part( 'templates/loop', 'news', $frontpage_news );
						$has_news_block = true;
						$post           = $current_post;
					endif;

					//                end
					?>
					<div class="col-12 col-md-6">
						<?php get_template_part( 'templates/cards/secondary' ); ?>
					</div>
				<?php endif;

				$counter ++;

			endwhile;
			wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
</div>