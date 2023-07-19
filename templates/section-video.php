<?php
$options = get_field('frontpage-video', 'option');

if ($options['has_block']):
    echo '<div class="container"><section class="last-video">';
    if (!$options['selected_post']):
        $args = array(
            'posts_per_page' => 1,
            'post_type' => 'post',
            'category__in' => 4
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) :
                $query->the_post();

                get_template_part('templates/cards/video');

            endwhile;
            wp_reset_postdata();
        else : ?>
            <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif;
    else:
        $post = $options['select_post'];
        get_template_part('templates/cards/video', false, $post);

    endif;
    echo '</section></div>';
endif; ?>
