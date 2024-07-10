<?php

$query = kedr_theme_get( 'taxonomy_articles' );

if ( $query->have_posts() ) {
    $total_posts = $query->post_count;
	$count = 0;
	while ( $query->have_posts() ) {
		$query->the_post();
		
		// Single post case
		if ( $total_posts == 1 ) {
			echo '<div class="frame-single">';
			get_template_part( 'templates/frame', 'single' );
			echo '</div>';
			continue;
		}

		// Two posts case
		elseif ( $total_posts == 2 ) {
			echo '<div class="frame-double">';
			get_template_part( 'templates/frame', 'double' );
			$query->the_post();
			get_template_part( 'templates/frame', 'double' );
			echo '</div>';
			continue;
		}

		// Three posts case
		elseif ( $total_posts == 3 ) {
			echo '<div class="frame-triple">';
			get_template_part( 'templates/frame', 'triple' );
			$query->the_post();
			get_template_part( 'templates/frame', 'triple' );
			$query->the_post();
			get_template_part( 'templates/frame', 'triple' );
			echo '</div>';
			continue;
		}

		if ($count == 0) {
			echo '<div class="frame-single">';
			get_template_part( 'templates/frame', 'single' );
			echo '</div>';
			$count++;
			continue;
		}

		if ($count == $total_posts - 2) {
			echo '<div class="frame-double">';
			get_template_part( 'templates/frame', 'double' );
			$query->the_post();
			get_template_part( 'templates/frame', 'double' );
			echo '</div>';
			continue;
		}

		if ($count == $total_posts - 4) {
			echo '<div class="frame-double">';
			get_template_part( 'templates/frame', 'double' );
			$query->the_post();
			get_template_part( 'templates/frame', 'double' );
			echo '</div>';

			$query->the_post();
			echo '<div class="frame-double">';
			get_template_part( 'templates/frame', 'double' );
			$query->the_post();
			get_template_part( 'templates/frame', 'double' );
			echo '</div>';
			continue;
		}

		echo '<div class="frame-triple">';
		get_template_part( 'templates/frame', 'triple' );
		$query->the_post();
		get_template_part( 'templates/frame', 'triple' );
		$query->the_post();
		get_template_part( 'templates/frame', 'triple' );
		echo '</div>';

		$count+=3;
	}

    wp_reset_postdata();
}

?>
