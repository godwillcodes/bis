<?php
/**
 * Template Name: Team
 *
 * The template for displaying the Team page.
 *
 * @package BIS
 */

get_header();
get_template_part( 'components/layout/banner' );
get_template_part( 'components/layout/breadcrumb' );

// Collect team members up front so we can JSON-encode for the modal AND iterate cards.
$team_members = array();
if ( have_rows( 'team_members' ) ) :
	while ( have_rows( 'team_members' ) ) : the_row();
		$team_members[] = array(
			'name'     => get_sub_field( 'name' ),
			'title'    => get_sub_field( 'title' ),
			'photo'    => get_sub_field( 'photo' ),
			'linkedin' => get_sub_field( 'linkedin' ),
			'bio'      => get_sub_field( 'bio' ),
		);
	endwhile;
endif;
?>

<!-- Team Section -->
<section class="py-16 bg-white" aria-labelledby="team-list-heading">
	<h2 id="team-list-heading" class="sr-only"><?php esc_html_e( 'Our team', 'bis' ); ?></h2>
	<div class="max-w-7xl mx-auto px-6">
		<?php if ( ! empty( $team_members ) ) : ?>
			<ul role="list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8 lg:gap-16 list-none p-0 m-0">
				<?php foreach ( $team_members as $index => $member ) :
					$member_id    = 'team-member-' . (int) $index;
					$member_name  = (string) ( $member['name'] ?? '' );
					$member_title = (string) ( $member['title'] ?? '' );
					$member_photo = (string) ( $member['photo'] ?? '' );
					$member_link  = (string) ( $member['linkedin'] ?? '' );
					$member_bio   = (string) ( $member['bio'] ?? '' );
				?>
					<li>
						<article class="group relative h-full" aria-labelledby="<?php echo esc_attr( $member_id ); ?>-name">
							<div class="relative overflow-hidden rounded-2xl bg-white shadow-md group-hover:shadow-2xl group-focus-within:shadow-2xl transition-all duration-500 transform group-hover:-translate-y-2 group-focus-within:-translate-y-2">
								<!-- Photo -->
								<div class="relative aspect-[4/5] overflow-hidden">
									<?php if ( $member_photo ) : ?>
										<img
											src="<?php echo esc_url( $member_photo ); ?>"
											alt=""
											class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-focus-within:scale-110"
											loading="lazy"
											decoding="async"
										>
									<?php else : ?>
										<div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300" aria-hidden="true"></div>
									<?php endif; ?>
									<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition-opacity duration-500" aria-hidden="true"></div>
								</div>

								<!-- Info -->
								<div class="p-6 relative">
									<div class="absolute top-0 left-6 right-6 h-0.5 bg-gradient-to-r from-[#ed1c24] via-[#ed1c24] to-transparent transform origin-left scale-x-0 group-hover:scale-x-100 group-focus-within:scale-x-100 transition-transform duration-500" aria-hidden="true"></div>

									<div class="flex items-start justify-between gap-4">
										<div>
											<h3 id="<?php echo esc_attr( $member_id ); ?>-name" class="text-xl font-bold text-gray-900 mb-1 group-hover:text-[#ed1c24] group-focus-within:text-[#ed1c24] transition-colors duration-300">
												<?php echo esc_html( $member_name ); ?>
											</h3>
											<?php if ( $member_title ) : ?>
												<p class="text-gray-700 font-medium"><?php echo esc_html( $member_title ); ?></p>
											<?php endif; ?>
										</div>

										<div class="w-10 h-10 rounded-full bg-gray-100 group-hover:bg-[#ed1c24] group-focus-within:bg-[#ed1c24] flex items-center justify-center transition-all duration-300 flex-shrink-0" aria-hidden="true">
											<svg class="w-5 h-5 text-gray-600 group-hover:text-white group-focus-within:text-white transition-colors duration-300 transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" focusable="false">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
											</svg>
										</div>
									</div>
								</div>
							</div>

							<?php if ( ! empty( $member_bio ) ) : ?>
								<button
									type="button"
									class="team-card-trigger absolute inset-0 w-full h-full bg-transparent border-0 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed1c24] focus-visible:ring-offset-2 rounded-2xl"
									data-team-index="<?php echo (int) $index; ?>"
									aria-haspopup="dialog"
									aria-controls="bioModal"
									aria-label="<?php echo esc_attr( sprintf( __( 'View biography of %s', 'bis' ), $member_name ) ); ?>"
								>
									<span class="sr-only"><?php echo esc_html( sprintf( __( 'View biography of %s', 'bis' ), $member_name ) ); ?></span>
								</button>
							<?php endif; ?>

							<?php if ( $member_link ) : ?>
								<!-- LinkedIn link sits above the trigger button so its click isn't swallowed. -->
								<a
									href="<?php echo esc_url( $member_link ); ?>"
									target="_blank"
									rel="noopener noreferrer"
									class="absolute bottom-24 right-6 z-10 w-10 h-10 flex items-center justify-center bg-white shadow-md rounded-full text-[#0077B5] hover:bg-[#0077B5] hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-[#0077B5] focus-visible:ring-offset-2 transition-all duration-200 border border-gray-200"
									aria-label="<?php echo esc_attr( sprintf( __( '%s on LinkedIn (opens in new tab)', 'bis' ), $member_name ) ); ?>"
								>
									<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
										<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
									</svg>
								</a>
							<?php endif; ?>
						</article>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p class="text-gray-700 text-center py-12"><?php esc_html_e( 'Team information will be available soon.', 'bis' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php if ( ! empty( $team_members ) ) : ?>
<!-- Bio Modal -->
<div id="bioModal"
	class="fixed inset-0 z-50 opacity-0 transition-opacity duration-300"
	role="dialog"
	aria-modal="true"
	aria-labelledby="modalName"
	aria-describedby="modalBio"
	hidden>
	<div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/60 to-black/70 backdrop-blur-md" data-modal-backdrop aria-hidden="true"></div>

	<div class="relative flex items-center justify-center min-h-screen p-6 md:p-12" style="padding-top: 5vh; padding-bottom: 5vh;">
		<div id="bioModalContent" class="relative bg-white rounded-3xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300">
			<button
				type="button"
				data-modal-close
				class="absolute top-6 right-6 z-20 w-12 h-12 flex items-center justify-center rounded-full bg-white shadow-lg hover:shadow-xl border border-gray-200 text-gray-700 hover:text-gray-900 transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed1c24] focus-visible:ring-offset-2"
				aria-label="<?php esc_attr_e( 'Close biography', 'bis' ); ?>"
			>
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
				</svg>
			</button>

			<div class="flex flex-col md:flex-row">
				<div class="md:w-2/5 relative">
					<div class="aspect-square md:aspect-auto md:h-full">
						<img id="modalPhoto" src="" alt="" class="w-full h-full object-cover" hidden>
						<div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent md:bg-gradient-to-r" aria-hidden="true"></div>
					</div>
				</div>

				<div class="md:w-3/5 p-8 md:p-10 lg:p-12 flex flex-col justify-center">
					<div class="mb-6">
						<h3 id="modalName" tabindex="-1" class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 tracking-tight focus:outline-none"></h3>
						<div class="flex items-center gap-3">
							<div class="w-12 h-1 bg-[#ed1c24] rounded-full" aria-hidden="true"></div>
							<p id="modalTitle" class="text-lg text-gray-700 font-medium"></p>
						</div>
					</div>

					<div id="modalBio" class="mb-8 text-gray-700 leading-relaxed text-lg prose prose-lg max-w-none"></div>

					<div id="modalLinkedInWrapper" class="pt-6 border-t border-gray-100" hidden>
						<a
							id="modalLinkedIn"
							href=""
							target="_blank"
							rel="noopener noreferrer"
							class="inline-flex items-center gap-3 px-8 py-4 bg-[#0077B5] text-white rounded-xl hover:bg-[#005885] transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-[#0077B5] focus-visible:ring-offset-2"
							aria-label="<?php esc_attr_e( 'Connect on LinkedIn (opens in new tab)', 'bis' ); ?>"
						>
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
								<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
							</svg>
							<span><?php esc_html_e( 'Connect on LinkedIn', 'bis' ); ?></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
(function () {
	var members             = <?php echo wp_json_encode( $team_members ); ?>;
	var modal               = document.getElementById('bioModal');
	var modalContent        = document.getElementById('bioModalContent');
	var modalPhoto          = document.getElementById('modalPhoto');
	var modalName           = document.getElementById('modalName');
	var modalTitle          = document.getElementById('modalTitle');
	var modalBio            = document.getElementById('modalBio');
	var modalLinkedIn       = document.getElementById('modalLinkedIn');
	var modalLinkedInWrap   = document.getElementById('modalLinkedInWrapper');
	var triggers            = document.querySelectorAll('.team-card-trigger');
	var previousFocus       = null;
	var keydownHandler      = null;

	var FOCUSABLE = [
		'a[href]',
		'button:not([disabled])',
		'input:not([disabled])',
		'textarea:not([disabled])',
		'select:not([disabled])',
		'[tabindex]:not([tabindex="-1"])'
	].join(',');

	function getFocusable() {
		return Array.prototype.slice.call(modal.querySelectorAll(FOCUSABLE))
			.filter(function (el) { return el.offsetParent !== null || el === modalName; });
	}

	function trapFocus(event) {
		if (event.key !== 'Tab') { return; }
		var focusable = getFocusable();
		if (!focusable.length) { return; }
		var first = focusable[0];
		var last  = focusable[focusable.length - 1];
		if (event.shiftKey && document.activeElement === first) {
			event.preventDefault();
			last.focus();
		} else if (!event.shiftKey && document.activeElement === last) {
			event.preventDefault();
			first.focus();
		}
	}

	function openBioModal(index) {
		var m = members[index];
		if (!m) { return; }

		previousFocus = document.activeElement;

		if (m.photo) {
			modalPhoto.src    = m.photo;
			modalPhoto.alt    = '';
			modalPhoto.hidden = false;
		} else {
			modalPhoto.removeAttribute('src');
			modalPhoto.alt    = '';
			modalPhoto.hidden = true;
		}
		modalName.textContent  = m.name || '';
		modalTitle.textContent = m.title || '';
		modalBio.innerHTML     = m.bio || '';

		if (m.linkedin && String(m.linkedin).trim() !== '') {
			modalLinkedIn.href          = m.linkedin;
			modalLinkedInWrap.hidden    = false;
		} else {
			modalLinkedIn.removeAttribute('href');
			modalLinkedInWrap.hidden    = true;
		}

		modal.hidden = false;
		document.body.style.overflow = 'hidden';

		requestAnimationFrame(function () {
			modal.classList.remove('opacity-0');
			modal.classList.add('opacity-100');
			modalContent.classList.remove('scale-95');
			modalContent.classList.add('scale-100');
			modalName.focus();
		});

		keydownHandler = function (e) {
			if (e.key === 'Escape') {
				e.preventDefault();
				closeBioModal();
			} else if (e.key === 'Tab') {
				trapFocus(e);
			}
		};
		document.addEventListener('keydown', keydownHandler);
	}

	function closeBioModal() {
		modal.classList.remove('opacity-100');
		modal.classList.add('opacity-0');
		modalContent.classList.remove('scale-100');
		modalContent.classList.add('scale-95');

		window.setTimeout(function () {
			modal.hidden = true;
			document.body.style.overflow = '';
			if (keydownHandler) {
				document.removeEventListener('keydown', keydownHandler);
				keydownHandler = null;
			}
			if (previousFocus && typeof previousFocus.focus === 'function') {
				previousFocus.focus();
			}
		}, 300);
	}

	Array.prototype.forEach.call(triggers, function (btn) {
		btn.addEventListener('click', function () {
			var idx = parseInt(btn.getAttribute('data-team-index'), 10);
			if (!isNaN(idx)) { openBioModal(idx); }
		});
	});

	modal.addEventListener('click', function (e) {
		if (e.target.matches('[data-modal-close]') || e.target.closest('[data-modal-close]')) {
			closeBioModal();
		} else if (e.target.matches('[data-modal-backdrop]')) {
			closeBioModal();
		}
	});
})();
</script>
<?php endif; ?>

<?php
get_template_part( 'components/sections/cta' );
get_template_part( 'components/sections/logo-carousel' );
get_footer();
