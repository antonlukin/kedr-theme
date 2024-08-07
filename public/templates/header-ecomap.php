
<header class="header header--ecomap">
    <div class="header__inner">
        <a class="header__ecomap" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Главная страница', 'kedr-theme' ); ?>">
            
            <img class="header__search-icon" src=
                <?php
                echo esc_url( get_template_directory_uri() . '/assets/images/ecomap-small.png' );
                ?>
            >
        </a>

        <div class="header__navbar">
            Экокарта
        </div>
        <button class="header__region-select">
            Регионы
                <?php
                printf(
                    '<svg class="header__region-select-icon"><use xlink:href="%s"></use></svg>',
                    esc_url( get_template_directory_uri() . '/assets/images/icons-sprite.svg#kedr-icon-chevron' )
                );
                ?>
        </button>

        
        <a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Главная страница', 'kedr-theme' ); ?>">
            
            <img class="header__search-icon" src=
                    <?php
                    echo esc_url( get_template_directory_uri() . '/assets/images/logo-ecomap.png' );
                    ?>
                >
        </a>

    </div>
</header>
