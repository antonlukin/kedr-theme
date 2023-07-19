<?php
$options = get_field( 'partners_group', 'option' );
if ( !empty($options['has_block'] )) : ?>
    <div class="container">
        <section class="partners">
            <div class="top-body">
                <div class="row">
					<?php foreach ( $options['partners'] as $post ): ?>
                        <div class="col-4 col-md-3 py-3 d-flex align-items-center">
                            <img class="avatar avatar-lg avatar-4x3 avatar-centered w-100" src="<?php echo $post['logo']; ?>" alt="">
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
        </section>
    </div>

<?php endif; ?>