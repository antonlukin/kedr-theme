<?php
/**
 * Gallery post format content
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<article <?php post_class( 'post' ); ?> id="post-<?php the_ID(); ?>">
    <div class="entry-feature">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="entry-feature__thumbnail">
                <?php
                the_post_thumbnail(
                    'single',
                    array(
                        'class'   => 'entry-feature__thumbnail-image',
                        'loading' => 'lazy',
                    )
                );
                ?>
            </div>
        <?php endif; ?>

        <div class="entry-feature__wrapper">
            <?php
            the_post_info(
                'category',
                '<div class="entry-feature__category">',
                '</div>'
            );

            the_title(
                '<h1 class="entry-feature__title">',
                '</h1>'
            );

            the_post_info(
                'excerpt',
                '<div class="entry-feature__excerpt">',
                '</div>'
            );
            ?>

            <div class="entry-feature__meta">
                <?php
                the_post_info(
                    'date',
                    '<span class="entry-feature__meta-date">',
                    '</span>'
                );

                the_post_info(
                    'authors',
                    '<span class="entry-feature__meta-authors">',
                    '</span>'
                );
                ?>
            </div>
        </div>
    </div>

    <div class="entry-content">
        <?php the_content(); ?>
    </div>

    <div class="entry-inpost">
        <?php
        if ( is_active_sidebar( 'kedr-inpost' ) ) :
            dynamic_sidebar( 'kedr-inpost' );
        endif;
        ?>
    </div>
</article>