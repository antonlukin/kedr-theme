<?php
/**
 * Standart post format content
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<article <?php post_class( 'post' ); ?> id="post-<?php the_ID(); ?>">
    <div class="entry-header">
        <div class="entry-header__wrapper">
            <?php
            kedr_theme_info(
                'category',
                '<div class="entry-header__category">',
                '</div>'
            );

            kedr_theme_info(
                'title',
                '<h1 class="entry-header__title">',
                '</h1>'
            );
            ?>

            <div class="entry-header__meta">
                <?php
                kedr_theme_info(
                    'date',
                    '<span class="entry-header__meta-date">',
                    '</span>'
                );

                kedr_theme_info(
                    'authors',
                    '<span class="entry-header__meta-authors">',
                    '</span>'
                );

                kedr_theme_info(
                    'extrameta',
                    '<span class="entry-header__meta-extra">',
                    '</span>'
                );
                ?>
            </div>
        </div>

        <?php if ( has_post_thumbnail() ) : ?>
            <figure class="entry-header__image">
                <?php
                the_post_thumbnail(
                    'single',
                    array(
                        'class'   => 'entry-header__image-thumbnail',
                        'loading' => 'lazy',
                    )
                );

                kedr_theme_info(
                    'caption',
                    '<figcaption class="entry-header__image-caption">',
                    '</figcaption>'
                );
                ?>
            </figure>
        <?php endif; ?>
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
