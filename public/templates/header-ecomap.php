<header class="header header--ecomap">
    <div class="header__inner">
        <a class="header__ecomap" href="<?php echo esc_url( home_url( '/regions' ) ); ?>" aria-label="<?php esc_attr_e( 'Главная страница', 'kedr-theme' ); ?>">
            
            <img class="header__ecomap-icon" src=
                <?php
                echo esc_url( get_template_directory_uri() . '/assets/images/ecomap-logo.png' );
                ?>
            >

            <div class="header__ecomap-label">
                <?php
                echo esc_html__( 'Экокарта', 'kedr-theme' )
                ?>
            </div>
        </a>
        <?php
        $regions = kedr_theme_get( 'regions' );

        if ( ! empty( $regions ) ) :
            ?>

            <div class="header__region-select dropdown">
                <button class="header__region-select-button dropdown__button">
                    <?php
                    echo esc_html__( 'Регионы', 'kedr-theme' );
                    printf(
                        '<svg class="header__region-select-icon"><use xlink:href="%s"></use></svg>',
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

        
        <a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Главная страница', 'kedr-theme' ); ?>">
            
            <img class="header__kedr-icon" src=
                    <?php
                    echo esc_url( get_template_directory_uri() . '/assets/images/logo-ecomap.png' );
                    ?>
                >
        </a>

    </div>
</header>
