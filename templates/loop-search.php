<?php
/*
    Цикл вывода результатов поиска
*/
wp_parse_str( $GLOBALS['query_string'], $search_query );

$query = new WP_Query( $search_query );
relevanssi_do_query( $query );
?>

	<?php if ( $query->have_posts() ) : ?>
		<div class="row">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="col-12">
					<?php get_template_part( 'templates/cards/top' ); ?>
                </div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>

<?php wp_reset_postdata(); ?>