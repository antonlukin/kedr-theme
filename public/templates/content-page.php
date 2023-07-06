<?php
/**
 * Page content
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<article <?php post_class( 'post' ); ?> id="post-<?php the_ID(); ?>">
    <div class="entry-header">
        <?php
        the_title(
            '<h1 class="entry-header__title">',
            '</h1>'
        );
        ?>
    </div>

    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>