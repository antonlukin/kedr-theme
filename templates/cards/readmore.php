<div class="readmore-post">
    <a href="<?php the_permalink(); ?>">
        <div class="row">
            <div class="col-12 col-md-5">
                <strong class="d-md-none">Читайте также</strong>
                <div class="readmore-thumbnail w-100" style="background-image: url('<?php the_post_thumbnail_url( 'card' ); ?>');"></div>
            </div>
            <div class="col-12 col-md-7">
                <strong class="d-none d-md-block">Читайте также</strong>
                <?php the_title('<h5>', '</h5>'); ?>
                <p><?php the_excerpt(); ?></p>
            </div>
        </div>
    </a>
</div>