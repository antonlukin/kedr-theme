function setupRegionsMap( regions ) {
	for ( let i = 0; i < regions.length; i++ ) {
		const region = regions[ i ];
		const plate = document.getElementById( region.slug );
		const tooltip = document.getElementById( 'plate-tooltip' );

		plate.setAttribute( 'data-name', region.name );
		plate.firstChild.textContent = region.name;
		plate.classList.add( 'plate--active' );

		plate.addEventListener( 'mouseover', function() {
			const rect = plate.getBoundingClientRect();
			const coords = {
				left: rect.left + window.scrollX,
				top: rect.top + window.scrollY - 40,
			};

			tooltip.style.top = coords.top + 'px';
			tooltip.style.left = coords.left + 'px';
			tooltip.textContent = region.name;

			tooltip.classList.add( 'plate-tooltip--visible' );
			plate.classList.add( 'plate--hover' );
		} );

		plate.addEventListener( 'mouseout', function() {
			tooltip.classList.remove( 'plate-tooltip--visible' );
			plate.classList.remove( 'plate--hover' );
		} );

		plate.addEventListener( 'click', function() {
			window.location.href = `/region/${ region.slug }`;
		} );
	}
}

export default setupRegionsMap;
