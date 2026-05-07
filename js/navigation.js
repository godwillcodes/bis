/**
 * File navigation.js.
 *
 * Handles desktop dropdown menus and keyboard navigation.
 * Mobile menu is handled by Alpine.js in header.php.
 */
( function() {
	// Handle desktop dropdown menus
	const siteNavigation = document.getElementById( 'site-navigation' );
	if ( siteNavigation ) {
		const linksWithChildren = siteNavigation.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		// Desktop dropdown handling
		linksWithChildren.forEach( function( link ) {
			link.addEventListener( 'mouseenter', function() {
				const parent = this.parentElement;
				const submenu = parent.querySelector( '.sub-menu, .children' );
				if ( submenu ) {
					submenu.classList.add( 'show' );
				}
			} );

			link.addEventListener( 'mouseleave', function() {
				const parent = this.parentElement;
				const submenu = parent.querySelector( '.sub-menu, .children' );
				if ( submenu ) {
					submenu.classList.remove( 'show' );
				}
			} );
		} );
	}

	// Keyboard navigation for focus management (desktop menu)
	const allMenuLinks = document.querySelectorAll( '#primary-menu a' );
	allMenuLinks.forEach( function( link, index ) {
		link.addEventListener( 'keydown', function( e ) {
			// Handle arrow keys for menu navigation
			if ( e.key === 'ArrowDown' || e.key === 'ArrowUp' ) {
				e.preventDefault();
				const linksArray = Array.from( allMenuLinks );
				const currentIndex = linksArray.indexOf( this );
				let nextIndex;

				if ( e.key === 'ArrowDown' ) {
					nextIndex = currentIndex < linksArray.length - 1 ? currentIndex + 1 : 0;
				} else {
					nextIndex = currentIndex > 0 ? currentIndex - 1 : linksArray.length - 1;
				}

				linksArray[ nextIndex ].focus();
			}
		} );
	} );
}() );
