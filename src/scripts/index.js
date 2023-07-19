import replaceEmbeds from './packages/replaceEmbeds';
import showReference from './packages/showReference';
import toggleNavbar from './packages/toggleNavbar';

( function() {
	const post = document.querySelector( '.post' );

	if ( post !== null ) {
		showReference( post );
	}

	const header = document.querySelector( '.header' );

	if ( header !== null ) {
		toggleNavbar( header );
	}

	replaceEmbeds( document.querySelectorAll( '.embed' ) );
}() );
