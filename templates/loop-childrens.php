<?php

for ( $i = 0; $i < count( $args ); $i ++ ) { ?>
	<?php
	$cat = get_category( $args[ $i ] );
	$category_link = get_category_link( $cat->term_id );

	?>
    <div class="col-12 col-md-3 mb-4">
        <div class="card card-project text-white" style="background-image: url(<?php the_field('poster', 'category_'.$cat->term_id); ?>);">
            <a class="card-img-overlay d-flex flex-column justify-content-end" href="<?php echo $category_link; ?>">
                <!--			<p class="card-text">Last updated 3 mins ago</p>-->
                <h5 class="card-title"><?php echo $cat->name; ?></h5>
            </a>
        </div>
    </div>
<?php } ?>