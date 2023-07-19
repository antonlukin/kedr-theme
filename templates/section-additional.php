<?php
$options           = get_field( 'frontpage-latestpost', 'option' );
$primary_end       = get_field( 'primary_end', 'option' );
$frontpage_project = get_field( 'frontpage-project', 'option' );

$exclude_posts = array_merge( get_option( 'sticky_posts' ) );

if ( $primary_end['selected_post'] ):
	$exclude_posts[] = $primary_end['select_post']->ID;
endif;

if ( $options['additional_posts'] ):
	$offset = $options['posts_per_page'] - count( $exclude_posts );

	$sticky_posts = get_option( 'sticky_posts' );
	if ( $sticky_posts and in_category( array( 4, 64, 1133, 5 ), $sticky_posts[0] ) ) {
		$offset += 1;
	}

	$args = array(
		'posts_per_page' => $options['count_additional_posts'],
		'offset'         => $offset,
		'post__not_in'   => $exclude_posts,
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'tax_query'      => array(
			'relation' => 'AND',
			array(
				'taxonomy'         => 'category',
				'field'            => 'term_id',
				'terms'            => array( 4, 64, 1133, 5 ),
				'operator'         => 'NOT IN',
				'include_children' => true
			)
		)
	);
//    Исключение материалов проектов из ленты
	if ( $frontpage_project['has_block'] ):
		$frontapage_project_args = array(
			'taxonomy' => 'project',
			'field'    => 'id',
			'operator' => 'NOT IN',
			'terms'    => $frontpage_project['taxonomy']
		);

		$args['tax_query'][] = $frontapage_project_args;

	endif;

	$query = new WP_Query( $args );
	?>

    <div class="container">
        <div class="row">
			<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

                <div class="col-12 col-md-6">
					<?php get_template_part( 'templates/cards/secondary' ); ?>
                </div>

			<?php endwhile;
				wp_reset_postdata();
			else : ?>
                <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php endif; ?>
        </div>
    </div>
<?php endif; ?>