<div class="card-video">
    <div class="row">
        <div class="col-12 col-md-6">
            <a class="d-flex flex-column h-100" href="<?php the_permalink(); ?>">
				<?php the_title( '<h5>', '</h5>' ); ?>
				<?php if ( get_field( 'alt_excerpt' ) ):
					echo '<p>' . get_field( 'alt_excerpt' ) . '</p>';
				else:
					the_excerpt();
				endif; ?>
                <div class="meta">
					<?php echo get_the_date(); ?>
                    <span>•</span>
					<?php
					$author_description = get_the_author_meta( 'description', $post->post_author );
					echo get_the_author_meta( 'first_name', $post->post_author ) . ' ' . get_the_author_meta( 'last_name', $post->post_author );
					if ( $author_description != '' ):
						echo ', ' . get_the_author_meta( 'description', $post->post_author );
					endif;
					?>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6">
            <div class="video-block">
                <iframe width="100%" height="100%"
                        src="<?php the_field( 'video_frame' ); ?>?rel=0&modestbranding=1&autohide=1&showinfo=0&controls=0"
                        title="YouTube video player"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>