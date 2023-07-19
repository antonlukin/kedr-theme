<div class="card card-secondary">
	<?php if ( get_the_post_thumbnail() ): ?>
        <div class="card-img-top" style="background-image: url('<?php the_post_thumbnail_url( 'card' ); ?>')"></div>
	<?php elseif ( has_category( 'videos' ) ): ?>
        <iframe width="100%" height="320px" src="<?php the_field( 'video_frame' ); ?>?controls=0"
                title="YouTube video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
	<?php endif; ?>
    <div class="card-body d-flex flex-column">
        <a class="category-name" href="<?php echo get_category_link(get_the_category()[0]); ?>">
            <?php echo get_the_category()[0]->name; ?>
        </a>
		<?php the_title( '<h5 class="card-title">', '</h5>' ); ?>
		<?php the_excerpt(); ?>
        <div class="meta d-flex">
	        <?php coauthors(', ', ', '); ?>
            <?php if (get_the_category()[0]->parent == '4' or get_the_category()[0]->parent == '10'): ?>
                <p class="ms-2"><?php the_post_thumbnail_caption(); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <a class="post-link" href="<?php the_permalink(); ?>"></a>
</div>