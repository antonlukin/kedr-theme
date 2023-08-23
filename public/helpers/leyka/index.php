<?php

/**
 * Update leyka head scripts
 */
remove_action( 'wp_head', 'leyka_inline_scripts' );

add_action(
    'wp_head',
    function() {
        echo '<script>document.documentElement.classList.add("leyka-js");</script>' . PHP_EOL;
    }
);

/**
 * Add donation form and styles to donate page
 */
add_action(
    'wp',
    function() {
        if ( ! is_page( 'donate' ) ) {
            return false;
        }

        $version = wp_get_theme()->get( 'Version' );

        wp_enqueue_style(
            'kedr-helpers-leyka',
            get_template_directory_uri() . '/helpers/leyka/styles.css',
            array(),
            $version
        );

        add_filter( 'leyka_form_is_screening', '__return_true' );
        add_filter( 'leyka_modern_template_displayed', '__return_true' );

        add_filter(
            'the_content',
            function( $content ) {
                $content = $content . do_shortcode( '[leyka_campaign_form id="1060"]' );

                return $content;
            }
        );
    }
);

add_action(
    'widgets_init',
    function() {
        unregister_widget( 'Leyka_Campaigns_List_Widget' );
        unregister_widget( 'Leyka_Campaign_Card_Widget' );
        unregister_widget( 'Leyka_Donations_List_Widget' );
    },
    20
);
