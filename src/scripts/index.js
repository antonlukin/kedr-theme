import replaceEmbeds from './packages/replaceEmbeds';
import raisePromo from './packages/raisePromo';
import showReference from './packages/showReference';
import toggleNavbar from './packages/toggleNavbar';
import initFancybox from './packages/initFancybox';
import handleRequests from './packages/handleRequests';
import loadMorePosts from './packages/loadMorePosts';
import showTelegramFrame from './packages/showTelegramFrame';
import setupRegionsMap from './packages/setupRegionsMap';
import initDropdownMenu from './packages/initDropdownMenu';

// Show post's reference blocks
showReference( document.querySelector( '.post' ) );

// Init Fancybox for post galleries
initFancybox( document.querySelector( '.post' ) );

// Raise promo blocks inside entry content
raisePromo( document.querySelector( '.entry-content' ) );

// Control header navbar
toggleNavbar( document.querySelector( '.header' ) );

// Dynamic loading more posts
loadMorePosts( document.querySelector( '.navigate--more' ) );

// Handle Telegram promo frame in flexible widget area
showTelegramFrame( document.querySelector( '.frame-telegram--flexible' ) );

// Handle preloaded embeds
replaceEmbeds( document.querySelectorAll( '[data-embed]' ) );

// Handle requests forms
handleRequests( document.querySelectorAll( '[data-requests]' ) );

// Dropdown menus
initDropdownMenu( );

document.addEventListener( 'DOMContentLoaded', function() {
	if ( typeof ecomapData !== 'undefined' && ecomapData.regions ) {
		setupRegionsMap( ecomapData.regions );
	}
} );
