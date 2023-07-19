<div class="card-primary d-flex flex-column justify-content-end"
   style="background-image: url('<?php the_post_thumbnail_url( 'wide' ); ?>')">
    <div class="shadow"></div>
    <a class="category-name" href="<?php echo get_category_link(get_the_category()[0]); ?>">
        <?php echo get_the_category()[0]->name; ?>
    </a>
    <div class="post-card-content">
        <?php the_title( '<h2>', '</h2>' ); ?>
        <?php the_excerpt(); ?>
    </div>
    <div class="meta">
	    <?php coauthors(', ', ', '); ?>
    </div>

    <a class="post-link" href="<?php the_permalink(); ?>"></a>
</div>