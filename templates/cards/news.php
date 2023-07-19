<div class="card card-top card-news post-link" href="<?php the_permalink(); ?>">
    <div class="news-item d-flex flex-column h-100">
		<?php if ( $args ): ?>
            <div class="card-img-top mb-2" style="background-image: url('<?php the_post_thumbnail_url( 'card' ); ?>')"></div>
		<?php endif; ?>

        <a class="category-name" href="<?php echo get_category_link(get_the_category()[0]); ?>">
            <?php echo get_the_category()[0]->name; ?>
        </a>

		<?php the_title( '<h5 class="card-title">', '</h5>' ); ?>
        <div class="meta">
			<?php echo get_the_date(); ?>
        </div>

        <a class="post-link" href="<?php the_permalink(); ?>"></a>
    </div>
</div>