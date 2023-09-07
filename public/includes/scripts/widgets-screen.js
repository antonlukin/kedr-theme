/**
 * jQuery object
 *
 * @external jQuery
 * @see {@link http://api.jquery.com/jQuery/}
 */

window.jQuery( document ).ready( function( $ ) {
	const wrapper = $( '#widgets-right' );

	if ( wrapper.length < 1 ) {
		return false;
	}

	/**
	 * Send AJAX request to ajaxurl
	 *
	 * @param {jQuery}   context
	 * @param {Object}   payload
	 * @param {Function} success
	 * @param {Function} failure
	 */
	function sendRequest( context, payload, success, failure ) {
		if ( ! window.ajaxurl || ! window.kedr_widgets ) {
			return failure();
		}

		payload.action = window.kedr_widgets.action;
		payload.nonce = window.kedr_widgets.nonce;

		const request = $.ajax( {
			method: 'POST',
			url: window.ajaxurl,
			data: payload,
		}, 'json' );

		request.done( function( result ) {
			result.success = result.success || false;

			if ( ! result.success ) {
				return failure( context, result.data );
			}

			return success( context, result.data );
		} );

		request.fail( function() {
			return failure();
		} );
	}

	/**
	 * Create linkset element
	 *
	 * @param {jQuery} linkset
	 */
	function composeLinkset( linkset ) {
		linkset.on( 'click', 'header button', function( e ) {
			e.preventDefault();

			const input = $( this ).siblings( 'input' );

			if ( input.val().length < 1 ) {
				return false;
			}

			// Hide error before ajax request
			$( this ).closest( 'header' ).find( 'p' ).remove();
			input.trigger( 'change' );

			const context = $( this ).closest( linkset );

			sendRequest( context, { linkset: input.val() }, createItem, showError );
		} );

		linkset.on( 'click', 'ul button', function( e ) {
			e.preventDefault();

			const context = $( this ).closest( linkset );
			context.find( 'header input' ).trigger( 'change' );

			$( this ).closest( 'li' ).remove();
		} );

		const createItem = function( context, data ) {
			const item = $( '<li>' ).appendTo( context.find( 'ul' ) );

			if ( data.image ) {
				$( '<img>', { src: data.image } ).appendTo( item );
			}

			const link = $( '<a>' ).appendTo( item );

			link.attr( 'href', data.link );
			link.attr( 'target', '_blank' );
			link.text( data.title );

			$( '<button>', { type: 'button' } ).appendTo( item );

			const hidden = $( '<input>' ).appendTo( item );

			hidden.attr( 'type', 'hidden' );
			hidden.attr( 'name', context.attr( 'data-name' ) );
			hidden.attr( 'value', data.post );

			context.find( 'header input' ).val( '' );
		};

		const showError = function( context, data ) {
			let message = context.find( 'header p' );

			if ( message.length < 1 ) {
				message = $( '<p>' ).appendTo( context.find( 'header' ) );
			}

			message.text( data || window.kedr_widgets.warning );
		};
	}

	$( document ).on( 'widget-added widget-updated', function( event, widget ) {
		composeLinkset( $( widget ).find( '.kedr-widgets-linkset' ) );
	} );

	composeLinkset( $( wrapper ).find( '.kedr-widgets-linkset' ) );
} );
