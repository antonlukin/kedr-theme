<?php
/**
 * Dropdown list template
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<?php

$options = $args['options'];

if ( ! empty( $options ) ) :
	?>
	<ul class="dropdown__menu">
		<div class="dropdown__items">
			<?php foreach ( $options as $option ) : ?>
				<li class="dropdown__item">
					<a href="<?php echo esc_url( '/region/' . $option->slug . '/' ); ?>" class="dropdown__link">
						<?php echo esc_html( $option->name ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</div>
	</ul>
<?php endif; ?>

