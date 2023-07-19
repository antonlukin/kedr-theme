<div class="post-header">
    <section class="gallery-offer d-flex flex-column justify-content-end"
             style="background-image: url('<?php the_post_thumbnail_url( 'wide' ); ?>')">
        <div class="container">
            <div class="col-12 col-md-6">
                <div class="post-header_title">
					<?php the_title( '<h1>', '</h1>' ); ?>
					<?php the_excerpt(); ?>
                </div>
            </div>
        </div>
    </section>
    <div class="container">

        <div class="post-header_title py-2">
            <div class="meta">
				<?php echo get_the_date(); ?>
                <span>•</span>
				<?php get_template_part( 'templates/parts/author', 'block' ); ?>
                <span>•</span>
				<?php if ( get_the_post_thumbnail_caption() ):
					echo 'Фото: ' . get_the_post_thumbnail_caption();
				endif; ?>
            </div>
        </div>
    </div>
</div>
<?php get_template_part( 'templates/content' ); ?>
