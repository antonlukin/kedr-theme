/**
 * Show Fancybox popup for all in-content images
 *
 * @since 2.0
 */

const { __ } = wp.i18n;

/**
 * Toggle preloader on submit buttons
 *
 * @param {HTMLElement} form
 * @param {boolean}     enable
 */
function togglePreload( form, enable = true ) {
	form.querySelectorAll( '.button' ).forEach( ( button ) => {
		if ( enable ) {
			return button.classList.add( 'button--preload' );
		}

		button.classList.remove( 'button--preload' );
	} );

	form.querySelectorAll( '.input' ).forEach( ( input ) => {
		if ( enable ) {
			return input.setAttribute( 'disabled', 'disabled' );
		}

		input.removeAttribute( 'disabled' );
	} );
}

/**
 * Show requests message
 *
 * @param {HTMLElement} form
 * @param {string}      content
 * @param {boolean}     warning
 */
function showMessage( form, content = null, warning = true ) {
	const message = form.querySelector( '.form__message' );

	if ( content === null ) {
		content = __( 'Возникла непредвиденная ошибка. Попробуйте позже', 'kedr-theme' );
	}

	if ( message === null ) {
		return false;
	}

	message.classList.add( 'form__message--visible' );

	if ( warning ) {
		message.classList.add( 'form__message--warning' );
	}

	message.textContent = content;
}

/**
 * Create request on form submition
 *
 * @param {HTMLElement} form
 * @param {string}      id
 */
async function submitForm( form, id ) {
	const data = new FormData( form );

	togglePreload( form );

	try {
		const response = await fetch( '/wp-json/kedr-requests/v1/' + id, {
			method: 'POST',
			body: data,
		} );

		const answer = await response.json();

		if ( ! answer.message ) {
			return showMessage( form );
		}

		if ( response.status === 200 ) {
			return showMessage( form, answer.message, false );
		}

		return showMessage( form, answer.message );
	} catch ( err ) {
		showMessage( form );
	}

	togglePreload( form, false );
}

/**
 * Add submit listener to form
 *
 * @param {HTMLElement} form
 */
function creteListener( form ) {
	const id = form.getAttribute( 'data-requests' );

	if ( id.length < 1 ) {
		return false;
	}

	form.addEventListener( 'submit', ( e ) => {
		e.preventDefault();

		submitForm( form, id );
	} );
}

/**
 * Default function
 *
 * @param {NodeList} forms Post html element
 */
function handleRequsts( forms ) {
	forms.forEach( creteListener );
}

export default handleRequsts;
