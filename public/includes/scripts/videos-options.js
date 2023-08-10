( function() {
	if ( typeof wp === 'undefined' || typeof wp.media === 'undefined' ) {
		return false;
	}

	const wrapper = document.getElementById( 'kedr-videos-options' );

	function toggleBackground() {
		let image = wrapper.querySelector( 'img' );

		if ( image !== null ) {
			wrapper.removeChild( image );
		}

		const source = wrapper.querySelector( 'input' );

		// Set disabled attribute by default
		wrapper.querySelector( 'button[data-remove]' ).setAttribute( 'disabled', 'disabled' );

		if ( source.value.length > 1 ) {
			image = document.createElement( 'img' );
			image.setAttribute( 'src', source.value );
			image.style.maxWidth = '95%';

			wrapper.insertBefore( image, wrapper.firstChild );
			wrapper.querySelector( 'button[data-remove]' ).removeAttribute( 'disabled' );
		}
	}

	/**
	 * Process select image button click
	 */
	wrapper.querySelector( 'button[data-select]' ).addEventListener( 'click', ( e ) => {
		e.preventDefault();

		const frame = wp.media( {
			multiple: false,
		} );

		frame.on( 'select', function() {
			const attachment = frame.state().get( 'selection' ).first().toJSON();
			wrapper.querySelector( 'input' ).value = attachment.url;

			toggleBackground();
		} );

		frame.open();
	} );

	/**
	 * Delete image on link clicking
	 */
	wrapper.querySelector( 'button[data-remove]' ).addEventListener( 'click', ( e ) => {
		e.preventDefault();
		wrapper.querySelector( 'input' ).value = '';

		toggleBackground();
	} );

	toggleBackground();
}() );
