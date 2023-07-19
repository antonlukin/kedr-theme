<div class="card card-project text-white" style="background-image: url('<?php the_post_thumbnail_url( 'card' ); ?>');">
    <a class="card-img-overlay post-link d-flex flex-column justify-content-start h-100 w-100" href="<?php the_permalink(); ?>">
        <?php the_title('<h5 class="card-title">', '</h5>'); ?>
        <?php the_excerpt(); ?>
    </a>
</div>