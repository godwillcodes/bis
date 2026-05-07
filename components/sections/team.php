<?php
/**
 * Team Section Component
 * Displays team members with Alpine.js modal for bio
 *
 * @package BIS
 */

// Get data passed from parent template or use defaults
$team_label = get_query_var('team_label') ?: 'Our Team';
$team_title = get_query_var('team_title') ?: 'Meet the People Behind BIS';
$team_description = get_query_var('team_description') ?: 'Our dedicated team brings decades of experience in accessibility services and a deep commitment to the Deaf community.';
$team_members = get_query_var('team_members');

// Fallback team members if ACF is empty
if (!$team_members || !is_array($team_members)) {
	$team_members = array(
		array(
			'member_name' => 'Brian Birnbaum',
			'member_title' => 'Chief Executive Officer',
			'member_department' => 'Executive Leadership',
			'member_linkedin' => 'https://linkedin.com/in/brianbirnbaum',
			'member_image' => array('url' => 'https://placehold.co/400x400'),
			'member_bio' => 'Brian Birnbaum leads BIS with a passion for Deaf access and innovative technology solutions. As the son of founder David Birnbaum, Brian grew up immersed in the Deaf community and brings a unique perspective to accessibility services. Under his leadership, BIS has expanded its reach and capabilities while maintaining the personal touch that has defined the company since 1995.',
		),
		array(
			'member_name' => 'Fallon Martinez',
			'member_title' => 'Director of Operations',
			'member_department' => 'Operations',
			'member_linkedin' => 'https://linkedin.com/in/fallonmartinez',
			'member_image' => array('url' => 'https://placehold.co/400x400'),
			'member_bio' => 'Fallon Martinez oversees the day-to-day operations at BIS, ensuring seamless service delivery for all clients. With over 15 years of experience in accessibility services, Fallon has developed deep relationships with healthcare providers, educational institutions, and government agencies. Her dedication to quality and client satisfaction has been instrumental in BIS\'s growth.',
		),
		array(
			'member_name' => 'Marcus Chen',
			'member_title' => 'Lead Interpreter Coordinator',
			'member_department' => 'Interpreter Services',
			'member_linkedin' => 'https://linkedin.com/in/marcuschen',
			'member_image' => array('url' => 'https://placehold.co/400x400'),
			'member_bio' => '',
		),
	);
}
?>

<section class="py-20 bg-gradient-to-br from-gray-50/80 via-white to-gray-50/60"
	aria-labelledby="team-heading"
	x-data="{
	modalOpen: false,
	activeMember: null,
	previousFocus: null,
	openModal(member) {
		this.previousFocus = document.activeElement;
		this.activeMember = member;
		this.modalOpen = true;
		document.body.classList.add('overflow-hidden');
		// Land focus on the dialog title once it is in the DOM and visible.
		this.$nextTick(() => {
			const heading = this.$refs.modalTitle;
			if (heading) { heading.focus(); }
		});
	},
	closeModal() {
		this.modalOpen = false;
		this.activeMember = null;
		document.body.classList.remove('overflow-hidden');
		// Return focus to the trigger that opened the modal.
		this.$nextTick(() => {
			if (this.previousFocus && typeof this.previousFocus.focus === 'function') {
				this.previousFocus.focus();
			}
			this.previousFocus = null;
		});
	},
	trapFocus(event) {
		if (event.key !== 'Tab' || !this.modalOpen) { return; }
		const dialog = this.$refs.modalDialog;
		if (!dialog) { return; }
		const focusable = dialog.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex=\'-1\'])');
		const visible = Array.from(focusable).filter(el => el.offsetParent !== null || el === this.$refs.modalTitle);
		if (!visible.length) { return; }
		const first = visible[0];
		const last  = visible[visible.length - 1];
		if (event.shiftKey && document.activeElement === first) {
			event.preventDefault();
			last.focus();
		} else if (!event.shiftKey && document.activeElement === last) {
			event.preventDefault();
			first.focus();
		}
	}
}">
	<style>
		.sr-only {
			position: absolute;
			width: 1px;
			height: 1px;
			padding: 0;
			margin: -1px;
			overflow: hidden;
			clip: rect(0, 0, 0, 0);
			white-space: nowrap;
			border-width: 0;
		}
	</style>
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
		<!-- Section Header -->
		<div class="text-center mb-16">
			<span class="text-xs font-medium tracking-widest uppercase text-[#ed3437] mb-4 block" aria-label="Section label"><?php echo esc_html($team_label); ?></span>
			<h2 id="team-heading" class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
				<?php echo esc_html($team_title); ?>
			</h2>
			<p class="text-gray-500 max-w-2xl mx-auto">
				<?php echo esc_html($team_description); ?>
			</p>
		</div>

		<!-- Team Grid -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php foreach ($team_members as $member) : 
				$name = $member['member_name'] ?? '';
				$title = $member['member_title'] ?? '';
				$department = $member['member_department'] ?? '';
				$linkedin = $member['member_linkedin'] ?? '';
				$image = $member['member_image']['url'] ?? 'https://placehold.co/400x400';
				$bio = $member['member_bio'] ?? '';
				
				// Escape for JS
				$js_name = esc_js($name);
				$js_title = esc_js($title);
				$js_department = esc_js($department);
				$js_linkedin = esc_js($linkedin);
				$js_image = esc_js($image);
				$js_bio = esc_js($bio);
			?>
			<div class="group">
				<article 
					class="team-card relative h-full rounded-2xl bg-white/70 backdrop-blur-sm border border-white/60 shadow-[0_1px_3px_rgba(0,0,0,0.04)] transition-all duration-500 hover:bg-white/90 hover:border-[#ed3437]/20 hover:shadow-[0_8px_30px_rgba(237,52,55,0.08)] overflow-hidden"
					x-data="{
						name: '<?php echo $js_name; ?>',
						title: '<?php echo $js_title; ?>',
						department: '<?php echo $js_department; ?>',
						linkedin: '<?php echo $js_linkedin; ?>',
						image: '<?php echo $js_image; ?>',
						bio: '<?php echo $js_bio; ?>'
					}"
				>
					<!-- Image -->
					<div class="aspect-[4/5] overflow-hidden">
						<img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>, <?php echo esc_attr($title); ?>" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" />
					</div>
					
					<!-- Content -->
					<div class="p-6 lg:p-8">
						<h3 class="text-lg font-semibold text-gray-900 mb-1 tracking-tight transition-colors duration-500 group-hover:text-gray-950"><?php echo esc_html($name); ?></h3>
						<p class="text-sm text-[#ed3437] font-medium mb-1"><?php echo esc_html($title); ?></p>
						<p class="text-xs text-gray-700 mb-4"><?php echo esc_html($department); ?></p>

						<!-- Actions -->
						<div class="flex items-center justify-between pt-4 border-t border-gray-100">
							<!-- LinkedIn -->
							<?php if ($linkedin) : ?>
							<a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer"
								class="inline-flex items-center text-gray-700 hover:text-[#0077b5] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#0077b5] focus-visible:ring-offset-2 rounded-sm transition-colors duration-300"
								@click.stop
								aria-label="<?php echo esc_attr( sprintf( __( 'Connect with %s on LinkedIn (opens in new tab)', 'bis' ), $name ) ); ?>">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
								</svg>
								<span class="sr-only">LinkedIn</span>
							</a>
							<?php else : ?>
							<span></span>
							<?php endif; ?>
							
							<!-- View Bio Button -->
							<?php if ($bio) : ?>
							<button
								@click="$dispatch('open-modal', { name, title, department, linkedin, image, bio })"
								class="inline-flex items-center text-xs font-semibold text-gray-700 tracking-wider uppercase transition-all duration-500 hover:text-[#ed3437] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed3437] focus-visible:ring-offset-2 rounded-sm"
								type="button"
								aria-haspopup="dialog"
								aria-label="<?php echo esc_attr( sprintf( __( 'View biography of %s', 'bis' ), $name ) ); ?>">
								<span>View Bio</span>
								<svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
									<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
								</svg>
							</button>
							<?php endif; ?>
						</div>
					</div>
				</article>
			</div>
			<?php endforeach; ?>
		</div>
	</div>

	<!-- Modal -->
	<div 
		x-show="modalOpen"
		x-transition:enter="transition ease-out duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition ease-in duration-200"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		@open-modal.window="openModal($event.detail)"
		@keydown.escape.window="closeModal()"
		@keydown.window="trapFocus($event)"
		class="fixed inset-0 z-50 flex items-center justify-center p-4"
		role="dialog"
		aria-modal="true"
		aria-labelledby="modal-title"
		style="display: none;"
	>
		<!-- Backdrop -->
		<div 
			class="absolute inset-0 bg-black/60 backdrop-blur-sm"
			@click="closeModal()"
			aria-hidden="true"
		></div>

		<!-- Modal Content -->
		<div
			x-ref="modalDialog"
			x-show="modalOpen"
			x-transition:enter="transition ease-out duration-300"
			x-transition:enter-start="opacity-0 scale-95 translate-y-4"
			x-transition:enter-end="opacity-100 scale-100 translate-y-0"
			x-transition:leave="transition ease-in duration-200"
			x-transition:leave-start="opacity-100 scale-100 translate-y-0"
			x-transition:leave-end="opacity-0 scale-95 translate-y-4"
			class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden"
			@click.stop
		>
			<!-- Close Button -->
			<button 
				@click="closeModal()"
				type="button"
				aria-label="Close modal"
				class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-gray-500 hover:text-gray-900 hover:bg-white transition-all duration-300 shadow-lg focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-offset-2"
			>
				<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
				</svg>
			</button>

			<div class="flex flex-col md:flex-row">
				<!-- Image -->
				<div class="md:w-2/5 aspect-square md:aspect-auto">
					<img :src="activeMember?.image" :alt="activeMember?.name" class="w-full h-full object-cover" />
				</div>

				<!-- Content -->
				<div class="md:w-3/5 p-8 lg:p-10">
					<div class="mb-6">
						<h3 id="modal-title" x-ref="modalTitle" tabindex="-1" class="text-2xl font-bold text-gray-900 mb-2 focus:outline-none" x-text="activeMember?.name"></h3>
						<p class="text-[#ed3437] font-medium mb-1" x-text="activeMember?.title"></p>
						<p class="text-sm text-gray-700" x-text="activeMember?.department"></p>
					</div>

					<div class="prose prose-gray">
						<p class="text-gray-600 leading-relaxed" x-text="activeMember?.bio"></p>
					</div>

					<!-- LinkedIn in Modal -->
					<div class="mt-8 pt-6 border-t border-gray-100">
						<a 
							:href="activeMember?.linkedin" 
							target="_blank" 
							rel="noopener noreferrer" 
							class="inline-flex items-center gap-2 text-sm font-medium text-[#0077b5] hover:text-[#005582] transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#0077b5] focus:ring-offset-2"
							:aria-label="'Connect with ' + activeMember?.name + ' on LinkedIn'"
						>
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
							</svg>
							<span>Connect on LinkedIn</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
