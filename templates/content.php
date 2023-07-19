<div class="post-content">
	<div class="container">
		<div class="post-entry">
			<?php if ( has_post_thumbnail() && in_category( 'news' ) ): ?>
				<figure class="post-thumbnail_square"
						style="background-image: url('<?php the_post_thumbnail_url( 'wide' ); ?>');">
					<figcaption><?php the_post_thumbnail_caption(); ?></figcaption>
				</figure>
            <?php endif; ?>

			<?php
			$blocks = parse_blocks( get_the_content() );
			$content_markup = '';
			foreach ( $blocks as $block ) {
				$align = $block['attrs']['align'] ?? '';

				if ($block['blockName'] == 'core/image' and $align == 'full' or
					$block['blockName'] == 'core/gallery' and $align == 'full'):
					$content_markup .=
						'</div>'
						. render_block( $block ) .
						'<div>';
				elseif ($block['blockName'] == 'core/image' and $align == 'wide' or
						$block['blockName'] == 'core/gallery' and $align == 'wide'):
					$content_markup .=
						'</div>'
						. render_block( $block ) .
						'<div class="post-entry">';
				else:
					$content_markup .= render_block( $block );
				endif;
			}
			// this will apply the_content filters for shortcodes
			// and embeds to contiune working
			echo apply_filters( 'the_content', $content_markup );
			?>
		</div>
	</div>
</div>