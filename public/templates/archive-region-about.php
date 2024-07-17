<?php
/**
 * The template for displaying categories that have subcategories
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>


<section class="content region">
    <div class="region__double">
        <div class="region__content">
            <h1 class="caption__title region__content-title">
                <?php
                echo esc_html__( 'Экологическая карта России', 'kedr-theme' );
                ?>
            </h1>

            <?php
            echo wp_kses_post( get_theme_mod( 'extra-ecomap-description' ) );
            ?>

            <?php
            $regions = kedr_theme_get( 'regions' );
            if ( ! empty( $regions ) ) :
                ?>
                <div class="dropdown">
                    <button class="region__content-button dropdown__button dropdown__toggle button">
                    <?php
                    echo esc_html__( 'Выбрать регион', 'kedr-theme' );
                    ?>
                    <?php
                        printf(
                            '<svg class="dropdown__toggle-icon"><use xlink:href="%s"></use></svg>',
                            esc_url( get_template_directory_uri() . '/assets/images/icons-sprite.svg#kedr-icon-chevron' )
                        );
                    ?>
                    </button>

                    <?php
                    $options = array( 'options' => $regions );
                    get_template_part( 'templates/frame', 'region-dropdown-menu', $options );
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="region__image">
            <img class="region__image-thumbnail" src=
                <?php
                echo esc_url( get_template_directory_uri() . '/assets/images/region-placeholder.jpg' );
                ?>
            >
        </div>
    </div>

    <div class="region__map">
        <?php
        get_template_part( 'templates/frame', 'map' );
        ?>
    </div>

    <?php
    get_template_part( 'templates/frame', 'region-articles' );
    ?>
</section>

<?php
get_footer();
