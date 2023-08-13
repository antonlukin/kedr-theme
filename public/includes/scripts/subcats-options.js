( function() {
	if ( typeof wp === 'undefined' || typeof wp.media === 'undefined' ) {
		return false;
	}

	const wrapper = document.getElementById( 'kedr-subcats-options' );

	const buttons = {
		select: wrapper.querySelector( 'button[data-select]' ),
		remove: wrapper.querySelector( 'button[data-remove]' ),
	};

	function updateBackground( url ) {
		if ( wrapper.querySelector( 'img' ) ) {
			wrapper.removeChild( wrapper.querySelector( 'img' ) );
		}

		const image = document.createElement( 'img' );
		image.setAttribute( 'src', url );
		image.style.maxWidth = '95%';

		wrapper.insertBefore( image, wrapper.firstChild );
		buttons.remove.removeAttribute( 'disabled' );
	}

	/**
	 * Process select image button click
	 */
	buttons.select.addEventListener( 'click', ( e ) => {
		e.preventDefault();

		const frame = wp.media( {
			multiple: false,
		} );

		frame.on( 'select', function() {
			const attachment = frame.state().get( 'selection' ).first().toJSON();
			wrapper.querySelector( 'input' ).value = attachment.id;

			updateBackground( attachment.url );
		} );

		frame.open();
	} );

	/**
	 * Delete image on link clicking
	 */
	buttons.remove.addEventListener( 'click', ( e ) => {
		e.preventDefault();

		if ( wrapper.querySelector( 'img' ) ) {
			wrapper.removeChild( wrapper.querySelector( 'img' ) );
		}

		buttons.remove.setAttribute( 'disabled', 'disabled' );
		wrapper.querySelector( 'input' ).value = '';
	} );

	if ( ! wrapper.querySelector( 'img' ) ) {
		buttons.remove.setAttribute( 'disabled', 'disabled' );
	}
}() );
