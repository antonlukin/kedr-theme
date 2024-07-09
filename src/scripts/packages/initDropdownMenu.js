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

	/**
	 * Toggle the visibility of the dropdown menu
	 */
	function toggleDropdown() {
		menu.classList.toggle( 'dropdown__menu--open' );
	}

	/**
	 * Handle click outside the dropdown to close it
	 *
	 * @param {Event} e JS event
	 */
	function handleClickOutside( e ) {
		if ( ! menu.contains( e.target ) && ! toggleButton.contains( e.target ) ) {
			menu.classList.remove( 'dropdown__menu--open' );
			document.removeEventListener( 'click', handleClickOutside );
		}
	}

	// Add event listener to toggle button
	toggleButton.addEventListener( 'click', function( e ) {
		e.stopPropagation();
		toggleDropdown();
		if ( menu.classList.contains( 'dropdown__menu--open' ) ) {
			document.addEventListener( 'click', handleClickOutside );
		} else {
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
