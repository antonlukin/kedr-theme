<?php get_header(); ?>
<?php $term = get_queried_object(); ?>
    <section class="archive-header">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h1><?php echo $term->name; ?></h1>
                </div>
            </div>

        </div>
    </section>
    <div class="container">
		<?php
//			$term->parent != 0 &&
            $children = category_has_children( $term->term_id );
			if ( $children ):
                echo '<div class="row">';
                get_template_part('templates/loop', 'childrens', $children);
                echo '</div>';
			endif; ?>

		<?php get_template_part( 'templates/loop', 'archive' ); ?>
    </div>


<?php get_footer(); ?>