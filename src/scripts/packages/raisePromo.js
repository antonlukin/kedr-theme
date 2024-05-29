/**
 * Raise promo block inside post content
 *
 * @since 2.3
 */

/**
 * Default function
 *
 * @param {HTMLElement} content Entry content html element
 */
function raisePromo( content ) {
	if ( content === null ) {
		return false;
	}

	// At the moment it is enough to raise only the first block found.
	const promo = content.querySelector( '.frame-promo' );

	// Find the first matching paragraph
	const p = content.querySelector( ':scope > p' );

	if ( promo && p ) {
		p.insertAdjacentElement( 'afterend', promo );
	}
}

export default raisePromo;
