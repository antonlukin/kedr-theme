<?php
/**
 * Site meta
 * Add custom site header meta and footer description
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Meta_Filters {
    /**
     * Use this method instead of constructor to avoid setting multiple hooks
     */
    public static function load_module() {
        add_action( 'customize_register', array( __CLASS__, 'update_customize_settings' ) );
    }

    /**
     * Footer description option
     */
    public static function update_customize_settings( $wp_customize ) {
        $wp_customize->add_setting( 'footer-description' );

        $wp_customize->add_section(
            'kedr_footer',
            array(
                'title'    => esc_html__( 'Подвал сайта', 'kedr-theme' ),
                'priority' => 160,
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Code_Editor_Control(
                $wp_customize,
                'footer-description',
                array(
                    'label'     => esc_html__( 'Описание в подвале', 'kedr-theme' ),
                    'section'   => 'kedr_footer',
                    'code_type' => 'text/html',
                    'priority'  => 10,
                )
            )
        );

        // Remove site icon controls from admin customizer
        $wp_customize->remove_control( 'site_icon' );
    }
}


/**
 * Load current module environment
 */
Kedr_Meta_Filters::load_module();
