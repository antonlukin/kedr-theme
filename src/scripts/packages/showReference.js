/**
 * Create and display reference popup using text from data attribute
 *
 * @since 2.0
 */

/**
 * Create reference popup
 *
 * @param {string} html Reference text
 */
function createPopup( html ) {
	const popup = document.createElement( 'div' );
	popup.classList.add( 'reference' );
	popup.setAttribute( 'id', 'reference' );

	const content = document.createElement( 'div' );
	content.classList.add( 'reference__content' );
	content.innerHTML = ( html + '' ).replace( /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2' );
	popup.appendChild( content );

	const button = document.createElement( 'button' );
	button.classList.add( 'reference__content-close' );
	content.appendChild( button );

	document.body.appendChild( popup );

	return popup;
}

/**
 * Move popup to visible area
 *
 * @param {HTMLElement} popup  Popup element
 * @param {HTMLElement} target Target clicked span element
 */
function movePopup( popup, target ) {
	const rect = target.getBoundingClientRect();

	// Get offset from top
	const offset = rect.top + document.documentElement.scrollTop;
	popup.style.top = offset + 'px';
}

/**
 * Default function
 *
 * @param {HTMLElement} post Post html element
 */
function showReference( post ) {
	if ( post === null ) {
		return false;
	}

	post.addEventListener( 'click', function( e ) {
		const target = e.target;

		// Trigger only elements with data-reference attribute inside content
		if ( target.hasAttribute( 'data-reference' ) ) {
			let popup = document.getElementById( 'reference' );

			if ( popup !== null ) {
				popup.parentNode.removeChild( popup );
			}

			popup = createPopup( target.getAttribute( 'data-reference' ) );

			// Move reference popup
			movePopup( popup, target );

			target.setAttribute( 'data-active', true );
			document.body.classList.add( 'is-reference' );

			const closePopup = ( event ) => {
				if ( event.target === popup || event.target.classList.contains( 'reference__content-close' ) ) {
					e.preventDefault();

					popup.parentNode.removeChild( popup );

					target.removeAttribute( 'data-active' );
					document.body.classList.remove( 'is-reference' );
				}
			};

			popup.addEventListener( 'click', closePopup );
			popup.addEventListener( 'touchend', closePopup );
		}
	} );
}

export default showReference;
