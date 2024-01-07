/**
 * Show Telegram frame according to user's session
 *
 * @since 2.0
 */

/**
 * Default function
 *
 * @param {HTMLElement} frame Telegram frame element
 */
function showTelegramFrame( frame ) {
	if ( ! frame ) {
		return false;
	}

	const key = 'kedr-telegram-frame';

	// Get localstorage value by key
	const storage = window.localStorage.getItem( key );

	if ( storage === null ) {
		return window.localStorage.setItem( key, JSON.stringify( { skip: 1 } ) );
	}

	const options = JSON.parse( storage );
	options.skip = parseInt( options.skip ) || 0;

	if ( options.skip < 2 ) {
		options.skip = options.skip + 1;

		return window.localStorage.setItem( key, JSON.stringify( options ) );
	}

	// 2 weeks ago
	const interval = Math.floor( Date.now() / 1000 ) - ( 3600 * 24 * 45 );

	if ( options.closed && options.closed > interval ) {
		return false;
	}

	frame.querySelector( '[data-close]' ).addEventListener( 'click', ( e ) => {
		e.preventDefault();

		frame.remove();

		options.closed = Math.floor( Date.now() / 1000 );
		window.localStorage.setItem( key, JSON.stringify( options ) );
	} );

	frame.classList.add( 'frame-telegram--visible' );
}

export default showTelegramFrame;
