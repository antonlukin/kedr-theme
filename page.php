<?php get_header(); ?>
<main class="wp-block-group">
    <div class="container">
        <div class="post-header">
            <div class="post-entry">
                <h1><?php the_title() ?></h1>
            </div>
        </div>
    </div>

    <?php get_template_part( 'templates/content' ); ?>
</main><!-- .site-main -->
<?php get_footer(); ?>

