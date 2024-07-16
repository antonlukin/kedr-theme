/**
 * Load more posts in archives
 *
 * @since 2.0
 */

/**
 * Handle navigate button
 *
 * @param {string} archive archive slug
 * @param {string} slug    Term slug
 * @param {number} page    Page number
 */
async function getPosts( archive, slug, page ) {
	const url = `/wp-json/kedr-loadmore/v1/${ archive }/${ slug }?page=${ page }`;

	const response = await fetch( url, {
		method: 'GET',
	} );

	return response.json();
}

/**
 * Default function
 *
 * @param {NodeList} navigate Navigate html element
 */
function loadMorePosts( navigate ) {
	if ( navigate === null ) {
		return false;
	}

	const button = navigate.querySelector( '.button[href]' );

	if ( button === null ) {
		return;
	}

	const url = new URL( button.getAttribute( 'href' ) );

	// Find category slug and page
	const matches = url.pathname.match( /^\/(.+?)\/(.+?)\/(?:page\/(\d+))?/ );

	if ( matches === null ) {
		return;
	}

	let [ , archive, slug, page ] = matches;

	// If no page set, check the data-page attribute
	let isDataAttr = false;
	if ( page === undefined ) {
		isDataAttr = true;
		page = button.getAttribute( 'data-page' );
	}
	page = parseInt( page );

	button.addEventListener( 'click', async ( e ) => {
		e.preventDefault();
		button.classList.add( 'button--preload' );

		try {
			const { output, pages } = await getPosts( archive, slug, page );

			if ( ! output ) {
				throw new Error();
			}

			navigate.previousElementSibling.innerHTML += output;

			if ( parseInt( pages?.current ) >= parseInt( pages?.total ) ) {
				return button.remove();
			}

			page = page + 1;
			if ( isDataAttr ) {
				button.setAttribute( 'data-page', page );
			} else {
				window.history.pushState( {}, '', url );
				url.pathname = `/${ archive }/${ slug }/page/${ page }`;
				button.setAttribute( 'href', url.href );
			}
		} catch ( error ) {
			return document.location.href = url.href;
		}

		button.classList.remove( 'button--preload' );
	} );
}

export default loadMorePosts;
