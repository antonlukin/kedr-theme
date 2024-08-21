<footer class="footer footer--ecomap">
    <div class="footer__inner">
        <div class="footer__description">
            <?php echo wp_kses_post( get_theme_mod( 'extra-ecomap-footer-description' ) ); ?>
        </div>
        <div class="footer__contacts">
            <div class="footer__contacts-description" >
                <?php echo wp_kses_post( get_theme_mod( 'extra-ecomap-contacts' ) ); ?>
            </div>
            <a class="footer__itcoop-logo" href="https://itcoop.site">
                <img class="footer__itcoop-logo-image" src="
                    <?php
                    echo esc_url( get_template_directory_uri() . '/assets/images/itcoop-logo.png' );
                    ?>
                ">
            </a>
        </div>
    </div>
</footer>
