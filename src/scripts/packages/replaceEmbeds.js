/**
 * Get all html elements with embed class and replace them with iframe links
 *
 * @since 2.0
 */

/**
 * Create bounce loader
 *
 * @param {HTMLElement} embed Embed element.
 */
function createLoader( embed ) {
	const loader = document.createElement( 'div' );
	loader.classList.add( 'embed__loader' );
	embed.appendChild( loader );

	const bounce = document.createElement( 'span' );
	bounce.classList.add( 'embed__loader-bounce' );
	loader.appendChild( bounce );

	return loader;
}

/**
 * Create iframe using data-embed attribute
 *
 * @param {HTMLElement} embed Embed element.
 */
function createIframe( embed ) {
	const iframe = document.createElement( 'iframe' );
	const loader = createLoader( embed );

	iframe.setAttribute( 'allow', 'autoplay' );
	iframe.setAttribute( 'frameborder', '0' );
	iframe.setAttribute( 'src', embed.dataset.embed );

	iframe.addEventListener( 'load', function() {
		loader.parentNode.removeChild( loader );
	} );

	return iframe;
}

/**
 * Default class
 *
 * @param {NodeList} embeds
 */
function replaceEmbeds( embeds ) {
	embeds.forEach( ( embed ) => {
		embed.addEventListener( 'click', function( e ) {
			if ( embed.hasAttribute( 'data-embed' ) ) {
				e.preventDefault();

				// Remove all embed child nodes
				while ( embed.firstChild ) {
					embed.removeChild( embed.firstChild );
				}

				embed.appendChild( createIframe( embed ) );
			}
		} );
	} );
}

export default replaceEmbeds;
