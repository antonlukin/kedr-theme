<?php
$options = get_field( 'frontpage-project', 'option' );
if ( $options['has_block'] ):
	$term = get_term( $options['taxonomy'], 'project' );
	?>

    <div class="container">
        <section class="ecodoc">
            <div class="ecodoc-body">
                <div class="row">
                    <div class="col-12 col-lg-4 d-flex">
                        <div class="ecodoc-form">
							<h3><?php echo $term->name; ?></h3>
                            <p><?php echo $options['description'] ?></p>

							<a class="btn btn-primary" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
								<?php esc_html_e( 'Читать ещё' ); ?>
							</a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="row">
							<?php
							$args  = array(
								'posts_per_page' => $options['project_count'],
								'post_type'      => 'post',
								'tax_query'      => array(
									array(
										'taxonomy' => 'project',
										'field'    => 'id',
										'terms'    => $term->term_id
									)
								)
							);
							$query = new WP_Query( $args );

							if ( $query->have_posts() ) :
								while ( $query->have_posts() ) :
									$query->the_post();

									echo '<div class="col-12 col-lg-6 ecodoc-item">';
									get_template_part( 'templates/cards/project' );
									echo '</div>';

								endwhile;
								wp_reset_postdata(); ?>

							<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php endif; ?>