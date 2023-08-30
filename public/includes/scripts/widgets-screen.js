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

	function sendRequest( payload, success, failure ) {
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
				return failure( result.data );
			}

			return success( result.data );
		} );

		request.fail( function() {
			return failure();
		} );
	}

	/**
	 * Create
	 *
	 * @param {jQuery} linkset
	 */
	function composeLinkset( linkset ) {
		const header = linkset.find( 'header' );
		const list = linkset.find( 'ul' );

		// Create item on successful ajax request
		const createItem = function( data ) {
			const item = $( '<li>' ).appendTo( list );

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
			hidden.attr( 'name', linkset.attr( 'data-name' ) );
			hidden.attr( 'value', data.post );

			$( header ).find( 'input' ).val( '' );
		};

		// Show error after failed ajax request
		const showError = function( data ) {
			let message = header.find( 'p' );

			if ( message.length < 1 ) {
				message = $( '<p>' ).appendTo( header );
			}

			message.text( data || window.kedr_widgets.warning );
		};

		header.on( 'click', 'button', function( e ) {
			e.preventDefault();

			const value = $( header ).find( 'input' ).val();

			if ( value.length < 1 ) {
				return false;
			}

			// Hide error before ajax request
			header.find( 'p' ).remove();
			header.find( 'input' ).trigger( 'change' );

			sendRequest( { linkset: value }, createItem, showError );
		} );

		// Listen clicks on delete buttons
		list.on( 'click', 'button', function( e ) {
			e.preventDefault();

			$( this ).closest( 'li' ).remove();
			header.find( 'input' ).trigger( 'change' );
		} );
	}

	$( document ).on( 'widget-added widget-updated', function( event, widget ) {
		composeLinkset( $( widget ).find( '.kedr-widgets-linkset' ) );
	} );

	composeLinkset( $( wrapper ).find( '.kedr-widgets-linkset' ) );
} );
