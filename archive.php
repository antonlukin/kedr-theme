<?php get_header(); ?>
    <section class="archive-header">
        <div class="container">
            <?php if ( is_category() ): ?>
                <h1><?php single_cat_title(); ?></h1>
                <?php echo category_description(); ?>

            <?php elseif ( is_tag() ): ?>
                <h1>#<?php single_cat_title(); ?></h1>
            <?php elseif ( is_author() ): ?>
                <h1>
                    Автор: <?php echo get_the_author_meta( 'first_name' ) . ' ' . get_the_author_meta( 'last_name' ); ?></h1>
            <?php endif; ?>
        </div>
    </section>
    <div class="container">
		<?php if ( is_category() ):
			$term = get_queried_object();
//			$term->parent != 0 &&
			$children = category_has_children( $term->term_id );
			if ( $children ):
				echo '<div class="row">';
				get_template_part( 'templates/loop', 'childrens', $children );
				echo '</div>';
			endif;
		endif; ?>

        <?php get_template_part( 'templates/loop', 'archive', $term); ?>

        <?php if ( have_posts() ) : ?>
        <nav class="navigate">
            <?php
                next_posts_link( esc_html__( 'Показать еще', 'knife-theme' ) );
            ?>
        </nav>
        <?php endif; ?>
    </div>


<?php get_footer(); ?>