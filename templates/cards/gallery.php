<a class="gallery-link" href="<?php the_permalink(); ?>">
    <section class="gallery-offer d-flex flex-column justify-content-end"
             style="background-image: url('<?php the_post_thumbnail_url( 'wide' ); ?>')">
        <div class="container">
            <div class="col-12 col-md-6">
                <div class="post-header_title">
					<?php the_title( '<h1>', '</h1>' ); ?>
					<?php the_excerpt(); ?>
                    <div class="meta d-flex">
						<?php coauthors( ', ', ', ' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</a>