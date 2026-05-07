<?php
/**
 * Template Name: ASL Interpreting
 * Description: 
 */
get_header();
get_template_part('components/layout/banner');
get_template_part('components/layout/breadcrumb'); 
?>

<?php if (get_field('introduction_title') || get_field('introduction_content_section_1')): ?>
<section class="py-12 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto w-full px-6 md:px-10 lg:px-0 text-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">
            <!-- Row 1 -->
            <div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out">
                    <?php echo wp_kses_post(get_field('introduction_title')); ?>
                </h2>
                <div class="w-24 h-px bg-gray-900 mt-8" aria-hidden="true"></div>
            </div>
            <div class="prose text-lg lg:text-xl font-normal space-y-4 text-gray-600" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="100">
                <?php echo wp_kses_post(get_field('introduction_content_section_1')); ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_field('introduction_content_section_2') || get_field('mohameds_image')): ?>
<section class="pb-12 md:pb-10 bg-white">
    <div class="max-w-7xl mx-auto w-full px-6 md:px-10 lg:px-0 text-black">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-start">

            <!-- Sticky Content -->
            <div class="relative" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out">
                <div class="sticky top-24">
                    <div class="prose text-lg lg:text-2xl font-normal space-y-4">
                        <?php echo wp_kses_post(get_field('introduction_content_section_2')); ?>
                    </div>
                </div>
            </div>

            <!-- Scrollable Image -->
            <div data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="150">
                <?php if (get_field('mohameds_image')): ?>
                <img src="<?php echo wp_kses_post(get_field('mohameds_image')); ?>" 
                     alt="Globalization illustration"
                     width="600" height="500"
                     loading="lazy"
                     decoding="async"
                     class="shadow-[0_12px_50px_rgba(0,0,0,0.08)] rounded-2xl object-cover w-full max-h-[500px] sm:max-h-[500px]">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_field('video_id')): ?>
<section class="py-10 lg:py-32 bg-gray-50" aria-labelledby="animatedText">
    <div class="text-center max-w-4xl mx-auto px-6 md:px-10 lg:px-0">
        <p class="text-lg font-medium text-gray-700 mb-6"><?php echo esc_html(get_field('video_title')); ?></p>
        <?php
        // The h2 receives animated text via JS. Provide an accessible default
        // so AT users (and no-JS clients) get a meaningful heading immediately.
        $animated_text_default = get_field('animated_text_default');
        if (empty($animated_text_default)) {
            $animated_text_default = get_field('video_title') ?: __('Watch our story', 'bis');
        }
        ?>
        <h2 id="animatedText" class="text-4xl md:text-5xl font-bold" data-animated-default="<?php echo esc_attr($animated_text_default); ?>"><?php echo esc_html($animated_text_default); ?></h2>
       <div class="max-3xl mx-auto mt-8">
       <iframe 
                class="w-full h-[400px] rounded-2xl border border-gray-200 shadow-[0_12px_50px_rgba(0,0,0,0.08)]"
                src="https://www.youtube.com/embed/<?php echo esc_attr(get_field('video_id')); ?>" 
                title="Call to Action Video"
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
       </div>
        
    </div>
</section>
<?php endif; ?>

<?php if (get_field('call_to_action_image')): ?>
<section class="pb-12 md:pb-20 bg-gray-50">
    <div class="max-w-7xl mx-auto w-full px-6 md:px-10 lg:px-0 text-black">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-20 md:gap-32 items-center">
            <div data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out">
                <img src="<?php echo wp_kses_post(get_field('call_to_action_image')); ?>" 
                     alt="Call to action illustration"
                     width="600" height="500"
                     loading="lazy"
                     decoding="async"
                     class="shadow-[0_12px_50px_rgba(0,0,0,0.08)] rounded-2xl object-cover object-top-[-30px] w-full max-h-[300px] lg:max-h-[500px]">
            </div>
            <!-- Row 1 -->
            <div data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="100">
                <p class="text-lg font-medium text-gray-700 mb-6">
                    <?php echo wp_kses_post(get_field('call_to_action_subtitle')); ?></p>

                <h2 class="text-3xl md:text-4xl max-w-md font-bold mb-8">
                    <?php echo wp_kses_post(get_field('call_to_action_title')); ?></h2>


                      <a href="/services/" 
                        class="group inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-semibold px-8 py-3.5 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        <span>Explore our services</span>
                        <svg class="w-5 h-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>

            </div>

        </div>
    </div>
</section>
<?php endif; ?>

<?php if( have_rows('green_benefits_card_repeater') ): ?>
<section class="py-16 lg:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <div class="text-center mb-10 max-w-4xl mx-auto">
            <h2 class="text-3xl sm:text-4xl lg:text-4xl font-bold tracking-tight" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out">
                <?php echo esc_html(get_field('repeater_benefits_title')); ?>
            </h2>
        </div>

    <!-- //repeatable cards -->
        <div class="aboutus-carousel owl-carousel owl-theme relative" style="
        mask: linear-gradient(to right, 
            transparent 0%, 
            black 5%, 
            black 95%, 
            transparent 100%
        );
        -webkit-mask: linear-gradient(to right, 
            transparent 0%, 
            black 5%, 
            black 95%, 
            transparent 100%
        );
        ">
        <?php $card_index = 0; ?>
        <?php while( have_rows('green_benefits_card_repeater') ): the_row(); ?>
            <?php 
                $icon = get_sub_field('icon');
                $title = get_sub_field('title');
                $description = get_sub_field('description');
            ?>

            <!-- Card -->
            <div class="item group relative h-full rounded-2xl bg-white/70 backdrop-blur-sm border border-white/60 shadow-[0_1px_3px_rgba(0,0,0,0.04)] p-8 flex flex-col transition-all duration-500 ease-out hover:-translate-y-1 hover:bg-white/90 hover:border-[#ed3437]/20 hover:shadow-[0_8px_30px_rgba(237,52,55,0.08)]"
                 data-aos="fade-up" 
                 data-aos-duration="600" 
                 data-aos-easing="ease-out-cubic" 
                 data-aos-delay="<?php echo $card_index * 100; ?>">
                 
                <div class="mb-8" aria-hidden="true">
                    <?php if($icon): ?>
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#ed3437]/10 to-[#ed3437]/5 flex items-center justify-center transition-all duration-500 group-hover:from-[#ed3437]/15 group-hover:to-[#ed3437]/10 group-hover:shadow-[0_4px_12px_rgba(237,52,55,0.12)]">
                            <img src="<?php echo esc_url($icon); ?>" 
                                alt="<?php echo esc_attr($title); ?> icon"
                                width="32" height="32"
                                loading="lazy"
                                decoding="async"
                                class="w-8 h-8 object-contain transition-transform duration-500 ease-out group-hover:scale-110">
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($title): ?>
                    <h3 class="text-lg font-semibold leading-snug text-gray-900 mb-4 tracking-tight"><?php echo esc_html($title); ?></h3>
                <?php endif; ?>

                <?php if($description): ?>
                    <p class="text-sm leading-relaxed text-gray-600 flex-1 mb-0">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>
            <?php $card_index++; ?>
        <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_field('additional_title') || get_field('additional_content')): ?>
<section class="py-12 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto w-full px-6 md:px-10 lg:px-0 text-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">
            <!-- Row 1 -->
            <div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out">
                    <?php echo wp_kses_post(get_field('additional_title')); ?>
                </h2>
                <div class="w-24 h-px bg-gray-900 mt-8" aria-hidden="true"></div>
            </div>
            <div class="prose text-lg lg:text-xl font-normal space-y-4 text-gray-600" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="100">
                <?php echo wp_kses_post(get_field('additional_content')); ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>




<?php if( have_rows('bentobox_repeater') ): ?>
<section class="bg-gray-900 py-20 px-6 lg:px-0">
    <div class="max-w-7xl mx-auto">
        <!-- Heading -->
        <div class="text-center mb-12">
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-2 tracking-tight"><?php echo wp_kses_post(get_field('bentobox_title')); ?></h2>
            <div class="text-gray-300 mt-4 text-lg max-w-2xl mx-auto">
                <?php echo wp_kses_post(get_field('bentobox_description')); ?>
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php 
                $counter = 0;
                while ( have_rows('bentobox_repeater') ) : the_row();
                    $title = get_sub_field('title');
                    $description = get_sub_field('description');
                    $image = get_sub_field('image'); // expected array with url
                    $image_url = $image ? (is_array($image) && isset($image['url']) ? $image['url'] : $image) : '';

                    if ( $counter % 3 == 0 ) : 
                // First item: Tall card with background image, overlay, text block
                ?>
            <div class="md:row-span-2 relative overflow-hidden rounded-2xl h-96 md:h-auto shadow-[0_12px_50px_rgba(0,0,0,0.35)]" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="<?php echo $counter * 100; ?>"
                style="background-image: url('<?php echo esc_url($image_url); ?>'); background-size: cover; background-position: center;">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="relative z-10 flex flex-col justify-end h-full w-[65%]">
                    <div class="bg-white/10 backdrop-blur-md p-8 flex flex-col justify-between text-white border border-white/10 min-h-56">
                        <h3 class="text-2xl font-bold tracking-tight"><?php echo esc_html($title); ?></h3>
                        <p class="text-base text-white/80 max-w-[280px] leading-relaxed"><?php echo esc_html($description); ?></p>
                    </div>

                </div>
            </div>
            <?php elseif ( $counter % 3 == 1 ): 
                // Second item: Card (text) on left, image block on right; actually, for grid formatting, output card here
                ?>
            <div class="bg-white/70 backdrop-blur-sm border border-white/60 p-8 flex flex-col justify-between text-gray-900 shadow-[0_1px_3px_rgba(0,0,0,0.04)] rounded-2xl min-h-48" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="<?php echo $counter * 100; ?>">
                <h3 class="text-2xl font-bold tracking-tight"><?php echo esc_html($title); ?></h3>
                <p class="text-base text-gray-600 max-w-[280px] leading-relaxed"><?php echo esc_html($description); ?></p>
            </div>

            <div class="relative overflow-hidden shadow-[0_12px_50px_rgba(0,0,0,0.12)] rounded-2xl min-h-48" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="<?php echo ($counter + 1) * 100; ?>">
                <img src="<?php echo esc_url($image_url); ?>" 
                     alt="<?php echo esc_attr($title); ?>"
                     width="400" height="300"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-[300px] object-cover transition-transform duration-500 hover:scale-105">
                <div class="absolute inset-0 bg-black/10"></div>
            </div>

            <?php elseif ( $counter % 3 == 2 ):
                // Third item: Image block
                ?>

            <div class="relative overflow-hidden shadow-[0_12px_50px_rgba(0,0,0,0.12)] rounded-2xl min-h-48" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="<?php echo $counter * 100; ?>">
                <img src="<?php echo esc_url($image_url); ?>" 
                     alt="<?php echo esc_attr($title); ?>"
                     width="400" height="300"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-[300px] object-cover transition-transform duration-500 hover:scale-105">
                <div class="absolute inset-0 bg-black/10"></div>
            </div>
            <div class="bg-red-600 p-8 flex flex-col justify-between text-white shadow-[0_12px_50px_rgba(237,52,55,0.20)] rounded-2xl min-h-48" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="<?php echo ($counter + 1) * 100; ?>">
                <h3 class="text-2xl font-bold tracking-tight"><?php echo esc_html($title); ?></h3>
                <p class="text-base text-white/90 max-w-[280px] leading-relaxed"><?php echo esc_html($description); ?></p>
            </div>

            <?php endif; ?>
            <?php 
            $counter++;
        endwhile;
        ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="mt-20  pb-20 bg-white" aria-labelledby="industries-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <div class="">
            <!-- Section Header -->
            <div class="mb-12" data-aos="fade-up">
                <h2 id="industries-heading"
                class=" text-4xl font-bold text-gray-900 mb-8">
                    Industries We Serve
                </h2>
                <div class="w-24 h-px bg-gray-900 mb-8" aria-hidden="true"></div>
                <p class="text-lg lg:text-xl text-gray-500 font-normal leading-relaxed max-w-2xl">
                    Regardless of your industry, our services are tailored to meet the specific needs and challenges of
                    your field.
                </p>
            </div>

            <!-- Industries Carousel -->
            <?php
            $industries = get_posts([
                'post_type' => 'industry',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'title',
                'order' => 'ASC',
            ]);

            if ($industries):
                $carousel_id = 'industries-carousel-' . uniqid();
                ?>
                <div class="owl-carousel owl-theme industries-carousel bg-white" id="<?php echo esc_attr($carousel_id); ?>"
                    role="region" aria-label="<?php esc_attr_e( 'Industries we serve, slide carousel', 'bis' ); ?>">
                    <?php
                    foreach ($industries as $post):
                        setup_postdata($post);

                        // Assumes ACF fields on the Industry CPT
                        $icon = get_field('icon');        // SVG / HTML
                        $description = get_field('introtext'); // Optional override
                        ?>
                        <div class="item">
                            <?php
                            set_query_var('description', $description);
                            get_template_part('components/cards/industry-card');
                            ?>
                        </div>
                        <?php
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php if (have_rows('timeline_repeater')): ?>
<section class="grid grid-cols-1 lg:grid-cols-20 gap-8 max-w-7xl mx-auto py-16 lg:py-24 px-6 lg:px-0">
    <!-- 30%: Sticky Title -->
    <div class="lg:col-span-6">
        <div class="lg:sticky lg:top-24" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out">
            <p class="text-3xl md:text-5xl font-bold leading-tight">From startup to strategic partner</p>
        </div>
    </div>

    <!-- 25%: Vertical Timeline -->
    <div class="lg:col-span-5">
        <div class="lg:sticky lg:top-32" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="100">
            <p class="text-base text-left lg:text-center mx-auto font-bold leading-tight mb-8">Milestones along the way
            </p>

            <!-- Timeline bar -->
            <div class="hidden lg:flex justify-center">
                <div class="relative w-px bg-gray-300" style="height: 215px;">
                    <?php 
                        $total_items = count(get_field('timeline_repeater'));
                        $count = 0;
                        while (have_rows('timeline_repeater')): the_row();
                            $count++;
                            $top_percent = $total_items > 1 ? (($count - 1) * 100 / ($total_items - 1)) : 0;
                    ?>
                    <div class="absolute left-1/2 w-3 h-3 rounded-full -translate-x-1/2 timeline-dot"
                        data-timeline-index="<?= esc_attr($count - 1); ?>"
                        style="top:<?= $top_percent ?>%;background: linear-gradient(180deg, #ed3437 0%, #b5282b 100%);">
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>


    <!-- 45%: Timeline Cards -->
    <div class="lg:col-span-9 space-y-24">
        <?php 
            $timeline_index = 0;
            while (have_rows('timeline_repeater')): the_row();
                $title       = get_sub_field('title');
                $description = get_sub_field('description');
                $icon        = get_sub_field('icon'); // icon url or svg
        ?>
        <div class="relative timeline-card" data-timeline-index="<?php echo esc_attr($timeline_index); ?>" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="<?php echo $timeline_index * 120; ?>">
            <div class="hidden lg:block absolute -left-2 top-1/2 transform -translate-y-1/2 w-0 h-0 border-t-[12px] border-t-transparent border-b-[12px] border-b-transparent border-r-[16px] border-r-white"></div>
            <div class="bg-white/70 backdrop-blur-sm border border-white/60 p-6 md:p-8 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.04)] transition-all duration-300 hover:shadow-lg hover:-translate-y-1 flex flex-col gap-4">
                <?php if ($title): ?>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 tracking-tight"><?= esc_html($title); ?></h3>
                <?php endif; ?>
                <?php if ($description): ?>
                <p class="text-gray-600 text-base md:text-lg"><?= esc_html($description); ?></p>
                <?php endif; ?>
                <?php if ($icon): ?>
                <div class="mt-auto pt-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#ed3437]/10 to-[#ed3437]/5 flex items-center justify-center">
                        <img src="<?= esc_url($icon); ?>" 
                            alt="<?= esc_attr($title); ?> icon"
                            width="32" height="32"
                            loading="lazy"
                            decoding="async"
                            class="w-6 h-6 object-contain">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php $timeline_index++; ?>
        <?php endwhile; ?>
    </div>
</section>
<?php endif; ?>


<?php 
    $images = get_field('affiliations'); // Gallery field returning URLs
    $certifications = get_field('certifications');
    if ($images || $certifications): 
?>
<section class="max-w-7xl mx-auto px-6 lg:px-0 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left Column -->
        <div data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out">
            <?php 
            if ($images): 
                $col1 = [];
                $col2 = [];
                foreach ($images as $i => $image) {
                    if ($i % 2 == 0) {
                        $col1[] = $image;
                    } else {
                        $col2[] = $image;
                    }
                }
            ?>
            <div class="grid grid-cols-2 gap-6 items-center">
                <!-- Column 1 -->
                <div class="lg:space-y-16 space-y-6 lg:pt-24">
                    <?php foreach ($col1 as $img): ?>
                    <img src="<?= esc_url($img); ?>" 
                         alt="Affiliation logo"
                         width="100" height="100"
                         loading="lazy"
                         decoding="async"
                         class="h-[70px] w-[70px] mx-auto lg:h-[100px] lg:w-[100px] object-contain transition duration-300 ease-in-out grayscale hover:grayscale-0">
                    <?php endforeach; ?>
                </div>

                <!-- Column 2 -->
                <div class="lg:space-y-16 space-y-6">
                    <?php foreach ($col2 as $img): ?>
                    <img src="<?= esc_url($img); ?>" 
                         alt="Affiliation logo"
                         width="100" height="100"
                         loading="lazy"
                         decoding="async"
                         class="h-[70px] w-[70px] mx-auto lg:h-[100px] lg:w-[100px] object-contain transition duration-300 ease-in-out grayscale hover:grayscale-0">
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right Column -->
        <div class="text-start lg:sticky lg:top-32 self-start" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="100">
            <p class="text-lg font-medium text-gray-700 mb-6">
                Affiliations & Certifications
            </p>
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                We are a certified minority-owned business and trusted partner for public and private institutions.
            </h2>

            <?php if ($certifications): ?>
            <div class="flex flex-wrap md:flex-nowrap gap-4 items-center mt-10">
                <?php foreach ($certifications as $cert): ?>
                <img src="<?php echo esc_url($cert); ?>" 
                     alt="Certification logo"
                     width="100" height="100"
                     loading="lazy"
                     decoding="async"
                     class="h-[70px] w-[70px] lg:h-[100px] lg:w-[100px] object-contain object-center transition duration-300 ease-in-out grayscale hover:grayscale-0">
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<?php 
    $hubspot_form = get_field('cta_hubspot_link');
    if ($hubspot_form): 
?>
<section class="py-12" aria-labelledby="asl-cta-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <div class="relative bg-gray-900 text-white rounded-3xl overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-5" aria-hidden="true"
                style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/patterns-01-scaled.webp'); background-repeat: repeat; background-size: cover;">
            </div>

            <div class="relative z-10 px-8 lg:px-16 py-16 lg:py-20 text-center">
                <h2 id="asl-cta-heading" class="text-3xl md:text-5xl text-white font-semibold mb-4 tracking-tight" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out"><?php echo wp_kses_post(get_field('cta_title')); ?></h2>
                <p class="text-base lg:text-xl font-light text-gray-300 max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out" data-aos-delay="100"><?php echo wp_kses_post(get_field('cta_description')); ?></p>

                <div class="max-w-4xl mx-auto mt-10">
                    <?php echo do_shortcode($hubspot_form); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
.fade-word {
    opacity: 0.4;
    transition: opacity 1s ease, color 1s ease;
}

.fade-word.visible {
    opacity: 1;
    color: #111827;
    /* Tailwind gray-900 for normal words */
}

.fade-word.highlight.visible {
    color: #ed3437;
    /* highlight in soft red */
}

.about-header span {
    color: #ed3437 !important;
}

/* Ensure About page carousel cards are equal height (match tallest) */
.aboutus-carousel .owl-stage {
    display: flex;
}
.aboutus-carousel .owl-item {
    display: flex;
    height: auto;
}
.aboutus-carousel .owl-item > div {
    height: 100%;
}
</style>

<script>
const textElement = document.getElementById("animatedText");
<?php
$animated_text = get_field('animated_text') ?: 'Making cross-cultural operations easier, smarter, and more human.';
// Convert to JavaScript-safe string
$js_text = json_encode($animated_text);
echo "const fullText = {$js_text};\n";
?>

// Function to detect pillar words (important/impactful words)
function detectPillarWords(text) {
    // Common pillar word patterns
    const pillarPatterns = [
        /\b\w+er\b/gi,        // words ending in -er (easier, smarter)
        /\b\w+ful\b/gi,       // words ending in -ful
        /\b\w+less\b/gi,      // words ending in -less
        /\b\w+ment\b/gi,      // words ending in -ment
        /\b\w+tion\b/gi,      // words ending in -tion
        /\b\w+ness\b/gi,      // words ending in -ness
        /\b\w+ity\b/gi,       // words ending in -ity
    ];
    
    // Words that are typically impactful
    const impactWords = [
        'easier', 'smarter', 'better', 'faster', 'stronger',
        'human', 'simple', 'clear', 'effective', 'efficient',
        'innovative', 'strategic', 'essential', 'critical', 'vital'
    ];
    
    const words = text.split(" ");
    const highlights = [];
    
    words.forEach(word => {
        const cleanWord = word.toLowerCase().replace(/[.,!?;:]/g, '');
        
        // Check if it's an impact word
        if (impactWords.includes(cleanWord)) {
            highlights.push(word);
            return;
        }
        
        // Check pillar patterns
        for (const pattern of pillarPatterns) {
            if (pattern.test(cleanWord)) {
                highlights.push(word);
                break;
            }
        }
    });
    
    return highlights;
}

const words = fullText.split(" ");
const highlight = detectPillarWords(fullText);

function runAnimation() {
    // render all words with low opacity
    textElement.innerHTML = words.map(word => {
        const isHighlight = highlight.includes(word);
        return `<span class="fade-word${isHighlight ? ' highlight' : ''}">${word}</span>`;
    }).join(" ");

    const spans = textElement.querySelectorAll(".fade-word");

    spans.forEach((span, i) => {
        setTimeout(() => {
            span.classList.add("visible");
        }, i * 300);
    });

    // reset after all words + extra delay
    const totalTime = spans.length * 300 + 1500;
    setTimeout(() => {
        spans.forEach(span => span.classList.remove("visible"));
        setTimeout(runAnimation, 500); // restart
    }, totalTime);
}

// start loop
runAnimation();
</script>


<script>
// Timeline active dot on scroll
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.timeline-card');
    const dots = document.querySelectorAll('.timeline-dot');

    if (!cards.length || !dots.length) return;

    // Initialize dots inactive (do not alter transform to preserve centering)
    dots.forEach(dot => {
        dot.style.opacity = '0.35';
        dot.style.boxShadow = 'none';
    });

    const setActive = (index) => {
        dots.forEach(dot => {
            dot.style.opacity = '0.35';
            dot.style.boxShadow = 'none';
        });
        const active = document.querySelector(`.timeline-dot[data-timeline-index="${index}"]`);
        if (active) {
            active.style.opacity = '1';
            active.style.boxShadow = '0 0 0 4px rgba(237,52,55,0.25)';
            // Avoid scaling to keep the dot perfectly centered on the line
        }
    };

    // Observe cards to set active dot as they enter viewport
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const idx = entry.target.getAttribute('data-timeline-index');
                setActive(idx);
            }
        });
    }, {
        root: null,
        threshold: 0.5
    });

    cards.forEach(card => observer.observe(card));

    // Set first active by default
    setActive(0);
});
</script>


<?php
get_footer();