/**
 * Initialize dropdown menu functionality
 *
 * @param {HTMLElement} menu         Dropdown menu HTML element
 * @param {HTMLElement} toggleButton Toggle button HTML element
 */
function dropdownMenu( toggleButton, menu ) {
	if ( ! menu || ! toggleButton ) {
		return;
	}
	menu.classList.add( 'dropdown__menu--close' );

	/**
	 * Handle click outside the dropdown to close it
	 *
	 * @param {Event} e JS event
	 */
	function handleClickOutside( e ) {
		if ( ! menu.contains( e.target ) && ! toggleButton.contains( e.target ) ) {
			menu.classList.remove( 'dropdown__menu--open' );
			menu.classList.add( 'dropdown__menu--close' );
			document.removeEventListener( 'click', handleClickOutside );
		}
	}

	// Add event listener to toggle button
	toggleButton.addEventListener( 'click', function( e ) {
		e.preventDefault();
		if ( ! menu.classList.contains( 'dropdown__menu--open' ) ) {
			menu.classList.add( 'dropdown__menu--open' );
			menu.classList.remove( 'dropdown__menu--close' );
			document.addEventListener( 'click', handleClickOutside );
		} else {
			menu.classList.remove( 'dropdown__menu--open' );
			menu.classList.add( 'dropdown__menu--close' );
			document.removeEventListener( 'click', handleClickOutside );
		}
	} );
}

function selectDropdownPairs( dropdownButtonClass, dropdownMenuClass ) {
	const dropdowns = document.querySelectorAll( dropdownButtonClass );

	const pairs = [];

	dropdowns.forEach( ( dropdown ) => {
		const nextElement = dropdown.nextElementSibling;

		if ( nextElement && nextElement.classList.contains( dropdownMenuClass ) ) {
			// Add the pair to the array
			pairs.push( [ dropdown, nextElement ] );
		}
	} );

	return pairs;
}

function initDropdownMenu( ) {
	const dropdownPairs = selectDropdownPairs( '.dropdown__button', 'dropdown__menu' );

	dropdownPairs.forEach( ( pair ) => {
		const [ dropdown, dropdownMenuElement ] = pair;
		dropdownMenu( dropdown, dropdownMenuElement );
	} );
}

export default initDropdownMenu;
