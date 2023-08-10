import replaceEmbeds from './packages/replaceEmbeds';
import showReference from './packages/showReference';
import toggleNavbar from './packages/toggleNavbar';
import initFancybox from './packages/initFancybox';
import handleRequests from './packages/handleRequests';

( function() {
	const post = document.querySelector( '.post' );

	if ( post !== null ) {
		initFancybox( post );
		showReference( post );
	}

	const header = document.querySelector( '.header' );

	if ( header !== null ) {
		toggleNavbar( header );
	}

	replaceEmbeds( document.querySelectorAll( '[data-embed]' ) );
	handleRequests( document.querySelectorAll( '[data-requests]' ) );
}() );
