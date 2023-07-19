<?php
$options = get_field( 'top_group', 'option' );
if ( $options['has_block'] ): ?>
    <div class="container">
        <section class="top">
            <div class="top-header">
                <h3><?php echo $options['title']; ?></h3>
            </div>
            <div class="top-body">
                <div class="row">
					<?php foreach ( $options['top_posts'] as $post ): ?>
                        <div class="col-12 col-md-6 col-lg-4">
							<?php get_template_part( 'templates/cards/top' ); ?>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
        </section>
    </div>

<?php endif; ?>