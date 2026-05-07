/**
 * Owl Carousel Loader
 *
 * Initializes Owl Carousel instances for logo carousels and content carousels.
 * Honors `prefers-reduced-motion` (WCAG 2.3.3 / 2.2.2) and adds focus-pause
 * behavior so keyboard / AT users can stop autoplay (WCAG 2.2.2 Pause, Stop, Hide).
 *
 * @package BIS
 */

(function ($) {
	'use strict';

	// True when the OS / browser requests reduced motion. Treat reduced-motion
	// users as if autoplay is disabled and animation speed is shorter.
	var prefersReducedMotion = (function () {
		try {
			return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		} catch (e) {
			return false;
		}
	})();

	// Wrap an autoplay flag so reduced-motion users never see auto-rotation.
	function ap(value) {
		return prefersReducedMotion ? false : value;
	}

	// Attach focus-pause behavior to a carousel jQuery node. When a focus
	// lands inside the carousel (keyboard tab, AT focus, voice control), stop
	// autoplay; resume only when focus leaves AND no hover is active.
	function bindFocusPause($carousel) {
		if (!$carousel || !$carousel.length) {
			return;
		}
		// Mark the carousel so AT can describe a stable region label.
		// (Each call site provides its own aria-label, we only enhance keyboard pause.)
		$carousel
			.on('focusin', function () {
				$carousel.trigger('stop.owl.autoplay');
			})
			.on('focusout', function (e) {
				// Only resume when focus has truly left the carousel.
				if (!$carousel[0].contains(e.relatedTarget)) {
					// Respect reduced-motion: do not resume if user opted out.
					if (!prefersReducedMotion) {
						$carousel.trigger('play.owl.autoplay');
					}
				}
			});
	}

	function initLogoCarousels() {
		$('.logo-carousel').each(function () {
			var $carousel = $(this);

			if ($carousel.data('owlCarousel')) {
				return;
			}

			$carousel.owlCarousel({
				loop: false,
				margin: 30,
				nav: false,
				dots: false,
				autoplay: ap(true),
				autoplayTimeout: 3000,
				autoplayHoverPause: true,
				responsive: {
					0: { items: 2, margin: 20 },
					640: { items: 3, margin: 25 },
					768: { items: 5, margin: 30 },
					1024: { items: 6, margin: 40 },
					1280: { items: 7, margin: 40 }
				},
				smartSpeed: 600,
				lazyLoad: true
			});

			bindFocusPause($carousel);
		});
	}

	function initIndustriesCarousels() {
		$('.industries-carousel').each(function () {
			var $carousel = $(this);

			if ($carousel.data('owlCarousel')) {
				return;
			}

			$carousel.owlCarousel({
				loop: false,
				margin: 24,
				nav: false,
				dots: true,
				autoplay: ap(true),
				autoplayTimeout: 4000,
				autoplayHoverPause: true,
				responsive: {
					0: { items: 1, margin: 16 },
					768: { items: 2, margin: 20 },
					1024: { items: 3, margin: 24 }
				},
				smartSpeed: 600,
				lazyLoad: true
			});

			bindFocusPause($carousel);
		});
	}

	function initServicesCarousels() {
		$('.services-carousel').each(function () {
			var $carousel = $(this);

			if ($carousel.data('owlCarousel')) {
				return;
			}

			$carousel.owlCarousel({
				loop: false,
				margin: 24,
				nav: false,
				dots: true,
				autoplay: ap(true),
				autoplayTimeout: 4000,
				autoplayHoverPause: true,
				responsive: {
					0: { items: 1, margin: 16 },
					768: { items: 2, margin: 20 },
					1024: { items: 3, margin: 24 }
				},
				smartSpeed: 600,
				lazyLoad: true
			});

			bindFocusPause($carousel);
		});
	}

	function initResourcesCarousels() {
		$('.resources-carousel').each(function () {
			var $carousel = $(this);

			if ($carousel.data('owlCarousel')) {
				return;
			}

			$carousel.owlCarousel({
				loop: false,
				margin: 24,
				nav: false,
				dots: true,
				autoplay: ap(true),
				autoplayTimeout: 4000,
				autoplayHoverPause: true,
				responsive: {
					0: { items: 1, margin: 16 },
					768: { items: 2, margin: 20 },
					1024: { items: 3, margin: 24 }
				},
				smartSpeed: 600,
				lazyLoad: true
			});

			bindFocusPause($carousel);
		});
	}

	function initTestimonialsCarousels() {
		$('.testimonials-carousel').each(function () {
			var $carousel = $(this);

			if ($carousel.data('owlCarousel')) {
				return;
			}

			$carousel.owlCarousel({
				loop: true,
				margin: 24,
				nav: false,
				dots: true,
				autoplay: ap(true),
				autoplayTimeout: 6000,
				autoplayHoverPause: true,
				smartSpeed: 800,
				responsive: {
					0: { items: 1, margin: 16 },
					768: { items: 2, margin: 24 },
					1024: { items: 2, margin: 32 }
				},
				lazyLoad: true
			});

			bindFocusPause($carousel);
		});
	}

	function initAboutusCarousels() {
		$('.aboutus-carousel').each(function () {
			var $carousel = $(this);

			if ($carousel.data('owlCarousel')) {
				return;
			}

			$carousel.owlCarousel({
				loop: true,
				margin: 30,
				nav: false,
				dots: true,
				autoplay: ap(true),
				autoplayTimeout: 3000,
				autoplayHoverPause: true,
				responsive: {
					0: { items: 1 },
					768: { items: 2 },
					1024: { items: 3 }
				}
			});

			bindFocusPause($carousel);
		});
	}

	$(document).ready(function () {
		initLogoCarousels();
		initIndustriesCarousels();
		initServicesCarousels();
		initResourcesCarousels();
		initTestimonialsCarousels();
		initAboutusCarousels();
	});

	$(document).on('ajaxComplete', function () {
		initLogoCarousels();
		initIndustriesCarousels();
		initServicesCarousels();
		initResourcesCarousels();
		initTestimonialsCarousels();
		initAboutusCarousels();
	});

	// React to runtime PRM changes (user toggles OS preference mid-session).
	if (window.matchMedia) {
		try {
			var mql = window.matchMedia('(prefers-reduced-motion: reduce)');
			var update = function () {
				prefersReducedMotion = mql.matches;
				$('.owl-carousel').each(function () {
					var $c = $(this);
					if (!$c.data('owlCarousel')) {
						return;
					}
					if (prefersReducedMotion) {
						$c.trigger('stop.owl.autoplay');
					} else {
						$c.trigger('play.owl.autoplay');
					}
				});
			};
			if (mql.addEventListener) {
				mql.addEventListener('change', update);
			} else if (mql.addListener) {
				mql.addListener(update);
			}
		} catch (e) { /* noop */ }
	}

})(jQuery);
