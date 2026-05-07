/**
 * Alpine.js Configuration
 * 
 * This file allows you to configure Alpine.js before it initializes.
 * Alpine.js will auto-initialize when loaded with defer attribute.
 * 
 * @package BIS
 */

(function() {
	'use strict';

	// Wait for Alpine to be available
	document.addEventListener('alpine:init', () => {
		// Configure Alpine.js here if needed
		// Example: Add custom data or methods
		
		// Example: Add a global store
		// Alpine.store('theme', {
		// 	darkMode: false,
		// 	toggle() {
		// 		this.darkMode = !this.darkMode;
		// 	}
		// });
		
		// Example: Add a custom directive
		// Alpine.directive('custom-directive', (el, { expression }, { evaluate }) => {
		// 	// Your custom directive logic
		// });
	});

	// If Alpine is already loaded (edge case)
	if (window.Alpine) {
		document.dispatchEvent(new Event('alpine:init'));
	}
})();

