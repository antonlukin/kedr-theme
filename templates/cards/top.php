<div class="card card-top" href="<?php the_permalink(); ?>">
    <div class="card-body d-flex flex-column">
        <a class="category-name" href="<?php echo get_category_link(get_the_category()[0]); ?>">
            <?php echo get_the_category()[0]->name; ?>
        </a>

		<?php the_title( '<h5 class="card-title">', '</h5>' ); ?>
		<?php the_excerpt(); ?>

        <a class="post-link" href="<?php the_permalink(); ?>"></a>
    </div>
</div>