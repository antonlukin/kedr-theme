<?php get_header(); ?>
<div class="container">
    <a href="https://maps.kedr.media/?from=home" target="_blank" class="w-100 mb-md-4 mb-3 d-flex border-bottom-0">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/banner_map_mob.png' ?>"
                class="d-md-none w-100 align-items-center justify-content-center">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/banner_map.png' ?>"
                class="d-none d-md-block w-100 align-items-center justify-content-center">
    </a>
</div>
<?php get_template_part( 'templates/loop', 'index' ); ?>
<?php get_template_part( 'templates/section', 'podcasts' ); ?>
<?php get_template_part( 'templates/section', 'video' ); ?>
<?php get_template_part( 'templates/section', 'ecodoc' ); ?>
<?php get_template_part( 'templates/section', 'gallery', 'middle' ); ?>
<?php get_template_part( 'templates/section', 'additional' ); ?>
<?php get_template_part( 'templates/section', 'top' ); ?>
<?php get_template_part( 'templates/section', 'partners' ); ?>
<?php get_template_part( 'templates/section', 'gallery', 'end' ); ?>

<?php get_footer(); ?>