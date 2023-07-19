const toggle = document.getElementById( 'toggle-menu' );

/**
 * Save body scrollTop here
 */
let scrollTop = 0;

/**
 * Toggle all elements before header
 *
 * @param {HTMLElement} header  Header HTML element
 * @param {string}      display Style display property
 */
function toggleHeader( header, display ) {
	// Get first header parent child
	let sibling = header.parentElement.firstChild;

	while ( sibling && sibling !== header ) {
		if ( sibling.nodeType === global.Node.ELEMENT_NODE ) {
			sibling.style.display = display;
		}

		sibling = sibling.nextSibling;
	}
}

/**
 * Close event menu outside
 *
 * @param {Event} e JS event
 */
function clickOutside( e ) {
	if ( e.target === document.body ) {
		e.stopPropagation();

		// Remove events
		document.body.removeEventListener( 'click', clickOutside );

		return toggle.click();
	}
}

/**
 * Default function
 *
 * @param {HTMLElement} header Header HTML element
 */
function toggleNavbar( header ) {
	const body = document.body;

	toggle.addEventListener( 'click', function( e ) {
		e.preventDefault();

		toggle.classList.toggle( 'header__toggle--expand' );

		// Set navbar expand class
		header.querySelector( '.header__navbar' ).classList.toggle( 'header__navbar--expand' );

		if ( body.classList.contains( 'is-navbar' ) ) {
			body.classList.remove( 'is-navbar' );
			body.style.top = '';

			// Remove useless onclick attribute
			body.removeAttribute( 'onclick', '' );

			window.scrollTo( 0, scrollTop );

			return toggleHeader( header, '' );
		}

		scrollTop = window.scrollY;

		body.classList.add( 'is-navbar' );
		body.style.top = -scrollTop + 'px';

		// Set attribite for iOS Safari
		body.setAttribute( 'onclick', '' );
		body.addEventListener( 'click', clickOutside );

		// Hide all elements before header
		return toggleHeader( header, 'none' );
	} );
}

export default toggleNavbar;
