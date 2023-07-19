<div class="post-header">
    <div class="container">
        <?php if ( has_post_thumbnail() && ! in_category( 'news' ) ): ?>
            <div class="row">
                <div class="col-12 col-md-8 order-2 order-md-1">
                    <figure class="post-thumbnail_square"
                            style="background-image: url('<?php the_post_thumbnail_url( 'wide' ); ?>');">
                        <figcaption><?php the_post_thumbnail_caption(); ?></figcaption>
                    </figure>

                </div>
                <div class="col-12 col-md-4 d-flex align-items-center order-1 order-md-2">
                    <div class="post-header_title">
                        <?php the_category(); ?>
                        <?php the_title( '<h1>', '</h1>' ); ?>
                        <?php the_excerpt(); ?>

                        <div class="meta">
                            <?php echo get_the_date(); ?>
                            <span>•</span>
                            <?php get_template_part( 'templates/parts/author', 'block' ); ?>
                        </div>

                        <a class="telegram-link" href="https://t.me/kedr_media">читайте нас в Telegram</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="post-entry">
                <div class="post-header_title">
                    <?php the_category(); ?>
                    <?php the_title( '<h1>', '</h1>' ); ?>
                    <?php the_excerpt(); ?>

                    <div class="meta">
                        <?php echo get_the_date(); ?>
                        <span>•</span>
                        <?php get_template_part( 'templates/parts/author', 'block' ); ?>
                    </div>

                    <a class="telegram-link" href="https://t.me/kedr_media">читайте нас в Telegram</a>
                </div>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php get_template_part( 'templates/content' ); ?>
