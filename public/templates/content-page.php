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
        <div class="entry-header__wrapper">
            <?php
            the_title(
                '<h1 class="entry-header__title">',
                '</h1>'
            );
            ?>
        </div>
    </div>

    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>