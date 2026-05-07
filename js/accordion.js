/**
 * Accordion Functionality
 * Handles accordion toggle interactions with smooth Apple-level animations
 *
 * @package BIS
 */

(function() {
	'use strict';

	/**
	 * Initialize accordion functionality
	 * @param {string} toggleSelector - CSS selector for accordion toggle buttons
	 */
	function initAccordion(toggleSelector) {
		const accordionToggles = document.querySelectorAll(toggleSelector);
		
		if (accordionToggles.length === 0) {
			return;
		}
		
		accordionToggles.forEach(toggle => {
			toggle.addEventListener('click', function(e) {
				e.preventDefault();
				
				const accordionItem = this.closest('.accordion-item');
				const contentWrapper = this.nextElementSibling;
				const icon = this.querySelector('svg');
				const isExpanded = this.getAttribute('aria-expanded') === 'true';
				
				// Close all other accordions in the same container
				const accordionContainer = this.closest('[id^="accordion"]');
				if (accordionContainer) {
					const allToggles = accordionContainer.querySelectorAll(toggleSelector);
					allToggles.forEach(otherToggle => {
						if (otherToggle !== this) {
							const otherItem = otherToggle.closest('.accordion-item');
							const otherContent = otherToggle.nextElementSibling;
							const otherIcon = otherToggle.querySelector('svg');
							
							otherToggle.setAttribute('aria-expanded', 'false');
							
							if (otherContent) {
								// Smooth collapse
								otherContent.style.maxHeight = '0px';
								otherContent.style.opacity = '0';
							}
							
							if (otherIcon) {
								otherIcon.style.transform = 'rotate(0deg)';
							}
							
							if (otherItem) {
								otherItem.classList.remove('is-expanded');
							}
						}
					});
				}
				
				// Toggle current accordion with smooth animation
				if (isExpanded) {
					// Collapse
					this.setAttribute('aria-expanded', 'false');
					
					if (contentWrapper) {
						contentWrapper.style.maxHeight = '0px';
						contentWrapper.style.opacity = '0';
					}
					
					if (icon) {
						icon.style.transform = 'rotate(0deg)';
					}
					
					if (accordionItem) {
						accordionItem.classList.remove('is-expanded');
					}
				} else {
					// Expand
					this.setAttribute('aria-expanded', 'true');
					
					if (contentWrapper) {
						// Get the actual content height from the inner div
						const innerContent = contentWrapper.querySelector('div > div');
						if (innerContent) {
							const height = innerContent.scrollHeight;
							contentWrapper.style.maxHeight = height + 'px';
							contentWrapper.style.opacity = '1';
						} else {
							// Fallback: use the first div if structure is different
							const content = contentWrapper.querySelector('div');
							if (content) {
								const height = content.scrollHeight;
								contentWrapper.style.maxHeight = height + 'px';
								contentWrapper.style.opacity = '1';
							}
						}
					}
					
					if (icon) {
						icon.style.transform = 'rotate(180deg)';
					}
					
					if (accordionItem) {
						accordionItem.classList.add('is-expanded');
					}
				}
			});
		});
	}

	/**
	 * Initialize first accordion item to be open by default
	 */
	function initFirstAccordion() {
		const accordionContainers = document.querySelectorAll('[id^="accordion"]');
		
		accordionContainers.forEach(container => {
			const firstToggle = container.querySelector('.accordion-toggle');
			if (firstToggle && firstToggle.getAttribute('aria-expanded') === 'true') {
				const contentWrapper = firstToggle.nextElementSibling;
				if (contentWrapper && contentWrapper.hasAttribute('data-initial-open')) {
					// Find the inner content div to get the actual height
					const innerContent = contentWrapper.querySelector('div > div');
					if (innerContent) {
						const height = innerContent.scrollHeight;
						contentWrapper.style.maxHeight = height + 'px';
						contentWrapper.style.opacity = '1';
					}
				}
			}
		});
	}

	// Initialize on DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			// Initialize first accordion to be open
			initFirstAccordion();
			// Initialize default accordion
			initAccordion('.accordion-toggle');
			// Initialize resource accordion
			initAccordion('.accordion-toggle-resource');
		});
	} else {
		// DOM already loaded
		initFirstAccordion();
		initAccordion('.accordion-toggle');
		initAccordion('.accordion-toggle-resource');
	}
})();

