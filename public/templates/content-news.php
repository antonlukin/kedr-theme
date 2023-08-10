<?php
/**
 * Standart post format content
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<article <?php post_class( 'post post--news' ); ?> id="post-<?php the_ID(); ?>">
    <div class="entry-header">
        <div class="entry-header__wrapper">
            <?php
            the_post_info(
                'category',
                '<div class="entry-header__category">',
                '</div>'
            );

            the_title(
                '<h1 class="entry-header__title">',
                '</h1>'
            );

            the_post_info(
                'excerpt',
                '<div class="entry-header__excerpt">',
                '</div>'
            );
            ?>

            <div class="entry-header__meta">
                <?php
                the_post_info(
                    'date',
                    '<span class="entry-header__meta-date">',
                    '</span>'
                );

                the_post_info(
                    'authors',
                    '<span class="entry-header__meta-authors">',
                    '</span>'
                );
                ?>
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

                    the_post_info(
                        'caption',
                        '<figcaption class="entry-header__image-caption">',
                        '</figcaption>'
                    );
                    ?>
                </figure>
            <?php endif; ?>
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