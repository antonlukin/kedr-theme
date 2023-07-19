<div class="row">
	<?php if ( have_posts() ):
		while ( have_posts() ):
			the_post();

			if ( is_category( 'news' ) ): ?>
                <div class="col-12 col-md-4">
					<?php get_template_part( 'templates/cards/news' ); ?>
                </div>
			<?php else: ?>
                <div class="col-12 col-md-6">
					<?php get_template_part( 'templates/cards/secondary' ); ?>
                </div>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>
</div>
