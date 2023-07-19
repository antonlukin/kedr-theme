<a class="card card-podcast post-link" href="<?php the_permalink(); ?>">
	<?php if ( get_the_post_thumbnail() ): ?>
        <div class="card-img-top" style="background-image: url('<?php the_post_thumbnail_url( 'card' ); ?>')"></div>
	<?php endif; ?>
    <div class="card-body d-flex flex-column">
      <h5>Выпуск <?php echo absint($args); ?></h5>
		  <?php the_title( '<p>', '</p>' ); ?>
    </div>
</a>