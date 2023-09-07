<?php
/**
 * Search template
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>

<form class="finder" action="/" method="GET">
    <div class="finder__wrapper">
        <?php
        printf(
            '<input class="finder__input input" type="text" name="s" value="%s" placeholder="%s">',
            esc_html( get_search_query() ),
            esc_html__( 'Введите ваш поисковый запрос', 'kedr-theme' )
        );

        printf(
            '<button class="finder__button button" type="submit">%s</button>',
            esc_html__( 'Искать', 'kedr-theme' )
        );
        ?>
    </div>

    <?php if ( ! have_posts() && ! empty( get_search_query() ) ) : ?>
        <div class="finder__message">
            <p><?php echo wp_kses_post( __( 'По вашему запросу ничего не найдено', 'kedr-theme' ) ); ?></p>
        </div>
    <?php endif; ?>
</form>

<?php if ( have_posts() ) : ?>
    <section class="frame-search">
        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'templates/frame', 'search' );
        endwhile;
        ?>
    </section>

    <nav class="navigate">
        <?php next_posts_link( esc_html__( 'Следуюшая страница', 'kedr-theme' ) ); ?>
    </nav>
<?php endif; ?>

<?php
get_footer();