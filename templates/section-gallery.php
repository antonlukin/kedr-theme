<?php
$options = get_field( 'frontpage-gallery', 'option' );

if ( $options['has_block'] ):
	if ( ! $options['place'] and $args == 'middle' or $options['place'] and $args == 'end' ): ?>
        <section class="gallery-block container <?php if($options['place']): echo 'mb-0'; endif; ?>">
			<?php if ( ! $options['selected_post'] ):
				$args = array(
					'posts_per_page' => 1,
					'post_type'      => 'post',
					'category__in'   => 64
				);
				$query = new WP_Query( $args );

				if ( $query->have_posts() ) :
					while ( $query->have_posts() ) :
						$query->the_post();

						get_template_part( 'templates/cards/gallery' );

					endwhile;
					wp_reset_postdata();
				else : ?>
                    <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
				<?php endif;
			else:
				$post = $options['select_post'];
				get_template_part( 'templates/cards/gallery', false, $post );

			endif; ?>
        </section>
	<?php endif; endif; ?>
