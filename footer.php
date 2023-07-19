<div class="container">
    <footer>
        <div class="row">
            <div class="col-4 d-none d-xl-block col-md-1 mb-3">
                <a class="navbar-brand" href="<?php bloginfo( 'url' ); ?>"><img
                            src="<?php echo get_template_directory_uri() . '/assets/img/logo.svg' ?>"
                            alt="Логотип Кедр"></a>
            </div>
            <div class="col-12 col-md-12 order-2 order-lg-0 col-lg-4 mb-3 footer-copy">
                <p>© <?php echo gmdate('Y'); ?>. Издание «Кедр.медиа».<br>Все права защищены. 18+</p>

                <p>Написать в редакцию: <a href="mailto:info@kedr.media">info@kedr.media</a><br>
                    По вопросам партнерств и рекламы: <a href="mailto:hellokedr@gmail.com">hellokedr@gmail.com</a></p>

                <a href="https://kedr.media/privacy-policy">Политика конфиденциальности</a><br><a
                        href="https://kedr.media/oferta">Публичная оферта</a>

            </div>
            <div class="col-12 col-md-8 col-lg-4 offset-lg-1 mb-3">
				<?php
				wp_nav_menu( array(
					'theme_location'  => 'footer',
					'depth'           => 2,
					'container'       => 'div',
					'container_class' => '',
					'container_id'    => 'footer-nav-1',
					'menu_class'      => 'nav navbar-nav',
					'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
					'walker'          => new WP_Bootstrap_Navwalker(),
				) );
				?>
            </div>
            <div class="col-12 col-md-4 col-lg-3 col-xl-2 mb-3 footer-social">
				<?php get_template_part( 'templates/list', 'social', $search = false ); ?>
                <a href="https://kedr.media/donate" class="btn btn-primary my-2">Поддержать</a>
            </div>
        </div>
    </footer>
</div>

<?php

if ( ! defined( 'WP_DEBUG' ) || WP_DEBUG === false ) {
    get_template_part( 'counters' );
}

wp_footer();
?>
</body>
</html>
