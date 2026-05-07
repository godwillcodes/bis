<?php
/**
 * Template Name: About22
 *
 * The template for displaying the about page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part('components/layout/breadcrumb');

// Get ACF fields
$timeline_items = get_field('about_timeline_items');
$team_label = get_field('team_section_label') ?: 'Our Team';
$team_title = get_field('team_section_title') ?: 'Meet the People Behind BIS';
$team_description = get_field('team_section_description') ?: 'Our dedicated team brings decades of experience in accessibility services and a deep commitment to the Deaf community.';
$team_members = get_field('team_members');
$testimonials_label = get_field('testimonials_section_label') ?: 'Testimonials';
$testimonials_title = get_field('testimonials_section_title') ?: 'What Our Clients Say';
$testimonials_description = get_field('testimonials_section_description') ?: 'Hear from the organizations and individuals who trust BIS for their accessibility needs.';
$testimonials_items = get_field('testimonials_items');
$mission_label = get_field('mission_section_label') ?: 'Our Mission';
$mission_title = get_field('mission_section_title') ?: 'Building bridges';
$mission_subtitle = get_field('mission_section_subtitle') ?: 'through communication';
$mission_statements = get_field('mission_statements');
$staffing_title = get_field('staffing_section_title') ?: 'Staffing';
$staffing_content = get_field('staffing_content');
$staffing_cta_text = get_field('staffing_cta_text');
$staffing_cta_link = get_field('staffing_cta_link');
?>

<?php if ($timeline_items && is_array($timeline_items) && count($timeline_items) >= 1) : 
	$first_item = $timeline_items[0];
	$first_image = $first_item['timeline_image']['url'] ?? 'https://placehold.co/640x800';
	$first_caption = $first_item['timeline_caption'] ?: $first_item['timeline_title'];
?>
<!-- Timeline Section -->
<section class="relative overflow-hidden py-20 bg-gray-50" aria-labelledby="timeline-heading">
	<h2 id="timeline-heading" class="sr-only"><?php esc_html_e( 'Our company timeline', 'bis' ); ?></h2>
	<div class="max-w-6xl mx-auto">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

			<!-- Left: Image + Caption -->
			<figure class="sticky top-32 self-start" data-aos="fade-right">
				<div class="relative overflow-hidden rounded-lg shadow-lg">
					<img id="timeline-image" src="<?php echo esc_url($first_image); ?>" alt="<?php echo esc_attr($first_caption); ?>"
						class="w-full h-[420px] lg:h-[640px] object-cover transition-opacity duration-500" />
					<!-- Caption overlay at bottom -->
					<div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/70 to-transparent px-6 py-6">
						<figcaption id="timeline-caption" class="text-sm text-white leading-relaxed">
							<?php echo esc_html($first_caption); ?>
						</figcaption>
					</div>
				</div>
			</figure>

			<!-- Right: Timeline -->
			<div class="space-y-8" id="timeline" data-aos="fade-left" data-aos-delay="200">
				<?php foreach ($timeline_items as $index => $item) :
					$is_first  = ($index === 0);
					$image_url = $item['timeline_image']['url'] ?? 'https://placehold.co/640x800';
					$caption   = $item['timeline_caption'] ?: $item['timeline_title'];
					$panel_id  = 'timeline-panel-' . $index;
				?>
				<div class="timeline-item group border-l-2 <?php echo $is_first ? 'border-red-600' : 'border-gray-200'; ?> pl-6 transition-all duration-300 hover:border-red-600 <?php echo $is_first ? 'is-active' : ''; ?>">
					<button type="button"
						class="timeline-toggle block w-full text-left bg-transparent border-0 p-0 m-0 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600 focus-visible:ring-offset-2 rounded-sm"
						data-image="<?php echo esc_url($image_url); ?>"
						data-caption="<?php echo esc_attr($caption); ?>"
						aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
						aria-controls="<?php echo esc_attr($panel_id); ?>">
						<h3 class="text-xl font-semibold <?php echo $is_first ? 'text-red-600' : 'text-gray-900'; ?> mb-4 group-hover:text-red-500 transition-colors duration-300">
							<?php echo esc_html($item['timeline_title']); ?>
						</h3>
					</button>
					<div id="<?php echo esc_attr($panel_id); ?>"
						class="timeline-panel blog-text space-y-4"
						<?php echo $is_first ? '' : 'hidden'; ?>>
						<?php echo wp_kses_post($item['timeline_content']); ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<script>
(function () {
	var items   = document.querySelectorAll('.timeline-item');
	var buttons = document.querySelectorAll('.timeline-toggle');
	var image   = document.getElementById('timeline-image');
	var caption = document.getElementById('timeline-caption');

	function activate(button) {
		var targetItem = button.closest('.timeline-item');
		if (!targetItem) { return; }

		items.forEach(function (item) {
			var btn   = item.querySelector('.timeline-toggle');
			var panel = item.querySelector('.timeline-panel');
			var h3    = item.querySelector('h3');
			item.classList.remove('is-active', 'border-red-600');
			item.classList.add('border-gray-200');
			if (btn)   { btn.setAttribute('aria-expanded', 'false'); }
			if (panel) { panel.hidden = true; }
			if (h3)    { h3.classList.remove('text-red-600'); h3.classList.add('text-gray-900'); }
		});

		var activeBtn   = targetItem.querySelector('.timeline-toggle');
		var activePanel = targetItem.querySelector('.timeline-panel');
		var activeH3    = targetItem.querySelector('h3');
		targetItem.classList.add('is-active', 'border-red-600');
		targetItem.classList.remove('border-gray-200');
		if (activeBtn)   { activeBtn.setAttribute('aria-expanded', 'true'); }
		if (activePanel) { activePanel.hidden = false; }
		if (activeH3)    { activeH3.classList.add('text-red-600'); activeH3.classList.remove('text-gray-900'); }

		if (image && button.dataset.image) {
			image.src = button.dataset.image;
			image.alt = button.dataset.caption || image.alt;
		}
		if (caption && button.dataset.caption) {
			caption.textContent = button.dataset.caption;
		}
	}

	buttons.forEach(function (button) {
		button.addEventListener('click', function () { activate(button); });
	});
})();
</script>
<?php endif; ?>

<?php 
// Only show team section if there's at least one team member in ACF
if ($team_members && is_array($team_members) && count($team_members) >= 1) :
	set_query_var('team_label', $team_label);
	set_query_var('team_title', $team_title);
	set_query_var('team_description', $team_description);
	set_query_var('team_members', $team_members);
	get_template_part('components/sections/team'); 
endif;
?>

<?php if ($testimonials_items && is_array($testimonials_items) && count($testimonials_items) >= 1) : 
	$testimonials_carousel_id = 'testimonials-carousel-' . uniqid();
?>
<!-- Testimonials Section -->
<section class="py-16 lg:py-24 bg-white" aria-labelledby="testimonials-heading">
	<div class="max-w-7xl mx-auto px-6 lg:px-0">
		<!-- Section Header -->
		<div class="mb-12" data-aos="fade-up">
			<h2 id="testimonials-heading" class="text-4xl font-bold text-gray-900 mb-8">
				<?php echo esc_html($testimonials_title); ?>
			</h2>
			<div class="w-24 h-px bg-gray-900 mb-8" aria-hidden="true"></div>
			<p class="text-lg lg:text-xl text-gray-500 font-normal leading-relaxed max-w-2xl">
				<?php echo esc_html($testimonials_description); ?>
			</p>
		</div>

		<!-- Testimonials Carousel -->
		<div class="owl-carousel owl-theme testimonials-carousel" id="<?php echo esc_attr($testimonials_carousel_id); ?>"
			role="region" aria-label="<?php esc_attr_e( 'Customer testimonials, slide carousel', 'bis' ); ?>">
			<?php foreach ($testimonials_items as $testimonial) : ?>
			<div class="item h-full">
				<article class="group h-full p-8 lg:p-10 bg-gray-50 rounded-2xl border border-gray-100 transition-all duration-300 hover:border-gray-200 hover:shadow-lg"
					aria-label="Testimonial from <?php echo esc_attr($testimonial['testimonial_author']); ?>">
					<!-- Quote Icon -->
					<div class="mb-6" aria-hidden="true">
						<svg class="w-8 h-8 text-[#ed3437]/20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
							<path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/>
						</svg>
					</div>

					<!-- Quote Text -->
					<blockquote class="mb-8">
						<p class="text-base lg:text-lg text-gray-600 leading-relaxed">
							"<?php echo esc_html($testimonial['testimonial_quote']); ?>"
						</p>
					</blockquote>

					<!-- Author -->
					<footer class="mt-auto pt-6 border-t border-gray-200">
						<cite class="not-italic flex items-center gap-3">
							<div class="w-10 h-10 rounded-full bg-[#ed3437]/10 flex items-center justify-center flex-shrink-0" aria-hidden="true">
								<span class="text-[#ed3437] text-sm font-semibold" aria-hidden="true"><?php echo esc_html(mb_substr($testimonial['testimonial_author'], 0, 1)); ?></span>
							</div>
							<div>
								<span class="block text-sm font-semibold text-gray-900">
									<?php echo esc_html($testimonial['testimonial_author']); ?>
								</span>
								<?php if (!empty($testimonial['testimonial_note'])) : ?>
								<span class="block text-xs text-gray-400 mt-0.5">
									<?php echo esc_html($testimonial['testimonial_note']); ?>
								</span>
								<?php endif; ?>
							</div>
						</cite>
					</footer>
				</article>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ($mission_statements && is_array($mission_statements) && count($mission_statements) >= 1) : ?>
<!-- Mission Section -->
<section class="relative py-16 lg:py-24 bg-gray-900 overflow-hidden" aria-labelledby="mission-heading">
	<!-- Background Pattern -->
	<div class="absolute inset-0 opacity-5" aria-hidden="true"
		style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/patterns-01-scaled.webp'); background-repeat: repeat; background-size: cover;">
	</div>

	<!-- Decorative gradient orbs -->
	<div class="absolute top-0 left-1/4 w-[400px] h-[400px] bg-[#ed3437]/5 rounded-full blur-[100px] -translate-y-1/2" aria-hidden="true"></div>
	<div class="absolute bottom-0 right-1/4 w-[300px] h-[300px] bg-white/[0.02] rounded-full blur-[80px] translate-y-1/2" aria-hidden="true"></div>

	<div class="relative max-w-7xl mx-auto px-6 lg:px-0 z-10">
		<!-- Header - matching home page style -->
		<div class="mb-12" data-aos="fade-up">
			<h2 id="mission-heading" class="text-4xl font-bold text-white mb-8">
				<?php echo esc_html($mission_title); ?> <?php echo esc_html($mission_subtitle); ?>
			</h2>
			<div class="w-24 h-px bg-white mb-8" aria-hidden="true"></div>
			<p class="text-lg lg:text-xl text-gray-400 font-normal leading-relaxed max-w-2xl">
				Our commitment to accessibility and equal communication access.
			</p>
		</div>

		<!-- Mission Cards -->
		<ul class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 list-none p-0 m-0" role="list" aria-label="<?php esc_attr_e( 'Mission statements', 'bis' ); ?>">
			<?php foreach ($mission_statements as $index => $statement) : ?>
			<li>
				<article class="group h-full p-6 lg:p-8 rounded-2xl bg-white/[0.03] border border-white/[0.08] transition-all duration-300 hover:bg-white/[0.05] hover:border-white/[0.12]">
					<!-- Quote content -->
					<blockquote class="mb-6">
						<p class="text-base lg:text-lg leading-relaxed text-gray-300 font-light">
							"<?php echo esc_html($statement['mission_quote']); ?>"
						</p>
					</blockquote>

					<!-- Author -->
					<footer class="flex items-center gap-3 pt-6 border-t border-white/[0.08]">
						<div class="w-10 h-10 rounded-full bg-[#ed3437]/10 flex items-center justify-center flex-shrink-0" aria-hidden="true">
							<span class="text-[#ed3437] text-sm font-semibold" aria-hidden="true"><?php echo esc_html($statement['mission_author_initials']); ?></span>
						</div>
						<div>
							<cite class="not-italic">
								<span class="block text-sm font-semibold text-white"><?php echo esc_html($statement['mission_author_name']); ?></span>
								<span class="block text-xs text-gray-500 mt-0.5"><?php echo esc_html($statement['mission_author_title']); ?></span>
							</cite>
						</div>
					</footer>
				</article>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php if ($staffing_content) : 
	$cta_url = $staffing_cta_link['url'] ?? '#';
	$cta_target = $staffing_cta_link['target'] ?? '_self';
?>
<!-- Staffing Section -->
<section class="pt-20" aria-labelledby="staffing-heading">
	<div class="container mx-auto px-4">
		<div class="max-w-6xl mx-auto" data-aos="fade-up">
			<h2 id="staffing-heading" class="text-3xl md:text-4xl text-center font-bold text-gray-900 mb-8"><?php echo esc_html($staffing_title); ?></h2>
			<div class="blog-text prose-lg max-w-none">
				<?php echo wp_kses_post($staffing_content); ?>
			</div>
			<?php if ($staffing_cta_text && $staffing_cta_link) : ?>
			<div class="flex justify-center mt-8">
				<a href="<?php echo esc_url($cta_url); ?>" target="<?php echo esc_attr($cta_target); ?>"
					class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-semibold px-8 py-4 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
					<span><?php echo esc_html($staffing_cta_text); ?></span>
					<svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
					</svg>
				</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
get_template_part('components/sections/cta');
get_template_part('components/sections/logo-carousel');
get_footer();
?>