/**
 * Show Fancybox popup for all in-content images
 *
 * @since 2.0
 */

import { Fancybox } from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox/fancybox.css';

/**
 * Default function
 *
 * @param {HTMLElement} post Post html element
 */
function initFancybox( post ) {
	Fancybox.bind( post, '.entry-content .wp-block-image > img', {
		groupAll: true,
		Thumbs: false,
		zoomOpacity: 'auto',
	} );
}

export default initFancybox;
