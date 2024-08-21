<?php
/**
 * The template for displaying categories that have subcategories
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>


<div class="content region">
    <div class="region__main-wrapper">
        <div class="region__main-background"> </div>
        <div class="region__main">
            <div class="region__main-subtitle">
                <?php
                echo esc_html__( 'Спецпроект «Кедр.медиа»', 'kedr-theme' );
                ?>
            </div>
            <div class="region__main-title">
                <?php
                echo esc_html__( 'Экологическая карта России', 'kedr-theme' );
                ?>
            </div>

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


        <div class="region__main-arrow">
            <?php
            printf(
                '<svg class="region__main-arrow-icon"><use xlink:href="%s"></use></svg>',
                esc_url( get_template_directory_uri() . '/assets/images/icons-sprite.svg#kedr-icon-chevron' )
            );
            ?>
        </div>
    </div>

    <div class="region__map">
        <?php
        get_template_part( 'templates/frame', 'map' );
        ?>
    </div>

    <section class="region__articles">
        <?php
        get_template_part( 'templates/frame', 'region-articles' );
        ?>
    </section>
</div>

<?php
get_footer();
