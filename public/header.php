<?php
/**
 * The template for displaying the header
 *
 * @package kedr-theme
 * @since 2.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#0F2E2C">
<meta name="apple-mobile-web-app-status-bar-style" content="#0F2E2C">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php
get_template_part( 'templates/header', kedr_theme_get( 'navigation_mod' ) );
?>
