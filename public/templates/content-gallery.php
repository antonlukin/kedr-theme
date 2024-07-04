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
            <figure class="entry-feature__image">
                <?php
                the_post_thumbnail(
                    'single',
                    array(
                        'class'   => 'entry-feature__image-thumbnail',
                        'loading' => 'lazy',
                    )
                );
                ?>
            </figure>
        <?php endif; ?>

        <div class="entry-feature__wrapper">
            <?php
            kedr_theme_info(
                'category',
                '<div class="entry-feature__category">',
                '</div>'
            );

            kedr_theme_info(
                'title',
                '<h1 class="entry-feature__title">',
                '</h1>'
            );
            ?>

            <div class="entry-feature__meta">
                <?php
                kedr_theme_info(
                    'date',
                    '<span class="entry-feature__meta-date">',
                    '</span>'
                );

                kedr_theme_info(
                    'authors',
                    '<span class="entry-feature__meta-authors">',
                    '</span>'
                );

                kedr_theme_info(
                    'ecomap',
                    '<span class="entry-feature__meta-ecomap">',
                    '</span>'
                );

                kedr_theme_info(
                    'get_labelcaption',
                    '<span class="entry-feature__meta-caption">',
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
