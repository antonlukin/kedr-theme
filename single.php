<?php get_header();

if ( is_user_logged_in() ):
	// @generate_social_thumbnail( $post->ID );
endif;

?>

    <main class="wp-block-group">
		<?php while ( have_posts() ) : the_post();
			if ( has_post_format( 'video' ) or has_post_format( 'audio' ) ) {
				get_template_part( 'templates/content', 'media' );
			} elseif ( has_post_format( 'gallery' ) ) {
				get_template_part( 'templates/content', 'gallery' );
			} else {
				get_template_part( 'templates/content', 'basic' );
			}

		endwhile; ?>

        <div class="container">
            <div class="post-entry post-donate">
                <a href="https://kedr.media/donate" target="_blank" class="btn btn-primary w-100">Поддержите «Кедр.медиа»</a>
            </div>

            <div class="post-entry">
                <?php
                    get_template_part( 'templates/section', 'socialsubscribe' );
                ?>
            </div>

            <?php if ( get_field( 'readmore_recomendation' ) ): ?>
                <div class="post-entry">
                    <?php get_template_part( 'templates/cards/readmore', false, get_field( 'readmore_recomendation' ) ); ?>
                </div>
            <?php endif; ?>

            <div class="post-entry">
                <a href="https://maps.kedr.media/?from=post" target="_blank" class="w-100 my-2 d-flex border-bottom-0">
                    <img src="<?php echo get_template_directory_uri() . '/assets/img/map.png' ?>" class="w-100 align-items-center justify-content-center">
                </a>
            </div>
        </div>

    </main>
    <script type="application/ld+json">
      {
            "@context" : "http://schema.org",
            "@type" : "NewsArticle",
            "mainEntityOfPage": {
                  "@type": "WebPage",
                  "@id": "<?php the_permalink(); ?>"
            },
            "headline" : "<?php the_title(); ?>",
            "author" : {
                  "@type" : "Person",
                  "name" : "<?php the_author(); ?>"
            },
            "publisher": {
                  "@type": "Organization",
                  "name": "Кедр",
                  "logo": {
                        "@type": "ImageObject",
                        "url": "<?php echo get_stylesheet_directory_uri() . '/assets/img/logo.png'; ?>"
                  }
            },
            "datePublished" : "<?php the_time( 'Y-m-d H:i' ); ?>",
            "dateModified" : "<?php the_time( 'Y-m-d H:i' ); ?>",
            "image" : "<?php the_post_thumbnail_url(); ?>",
            "articleBody" : "<?php echo wp_slash( wp_strip_all_tags( get_the_content(), true ) ); ?>",
            "url" : "<?php the_permalink(); ?>"
      }

    </script>
    <div class="my-4">
		<?php get_template_part( 'templates/section', 'subscribe' ); ?>
    </div>
<?php get_template_part( 'templates/readmore', 'frontpage' ); ?>
<?php get_footer(); ?>