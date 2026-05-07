<?php
/**
 * Template Name: Home
 *
 * The template for displaying the home page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part('components/sections/logo-carousel'); ?>

<section class="pt-10" aria-labelledby="why-choose-bis">
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <div class="">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 lg:gap-32 items-start">

                <!-- Sticky Content -->
                <div class="relative" data-aos="fade-up" data-aos-duration="300" data-aos-easing="ease-out">
                    <div class="lg:sticky lg:top-32">

                        <!-- Main Heading -->
                        <h2 id="why-choose-bis" class="text-4xl font-bold text-gray-900 mb-8">
                            <?php esc_html_e( 'Why Choose BIS?', 'bis' ); ?>
                        </h2>

                        <div class="w-24 h-px bg-gray-900 mb-12" aria-hidden="true"></div>

                        <div class="space-y-6 text-lg lg:text-xl text-gray-500 font-normal leading-relaxed">
                            <p>At BIS, we offer more than just interpreting services—we provide cultural expertise,
                                innovative solutions, and tailored accessibility to help you create inclusive
                                environments where Deaf and Hard-of-Hearing (HoH) individuals can thrive.</p>
                            <p>Whether you're expanding internationally or serving diverse communities at home, we help
                                you build the infrastructure for lasting, measurable impact.</p>
                        </div>

                        <div class="mt-16">
                            <a href="/contact"
                                class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-semibold px-6 sm:px-8 py-3 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-transparent">
                                <span>Schedule Consultation</span>
                                <svg class="w-5 h-5 ml-2 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="relative">
                    <div class="">
                        <img src="https://bisworld.com/wp-content/uploads/2026/01/FINAL-HOME-PAGE-TO-USE-1-min-scaled-e1749040010387.png"
                            alt="" role="presentation" width="600" height="750" loading="lazy" decoding="async"
                            class="w-full h-full object-contain">
                    </div>
                    <!-- Optional: Subtle border accent -->
                </div>
            </div>
        </div>
    </div>
</section>


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

<section class="py-20 bg-gray-50" aria-labelledby="services-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <div class="">
            <!-- Section Header -->
            <div class="mb-12" data-aos="fade-up">
                <h2 id="services-heading"
                class=" text-4xl font-bold text-gray-900 mb-8">
                    Our Services
                </h2>
                <div class="w-24 h-px bg-gray-900 mb-8" aria-hidden="true"></div>
                <p class="text-lg lg:text-xl text-gray-500 font-normal leading-relaxed max-w-2xl">
                    From cultural awareness training to advanced communication strategies, our services help you create
                    inclusive environments that respect and value every individual.
                </p>
            </div>

            <!-- Services Carousel -->
            <?php
            $services = get_posts([
                'post_type' => 'service',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'title',
                'order' => 'ASC',
            ]);

            if ($services):
                $carousel_id = 'services-carousel-' . uniqid();
                ?>
                <div class="owl-carousel owl-theme services-carousel bg-gray-50" id="<?php echo esc_attr($carousel_id); ?>"
                    role="region" aria-label="<?php esc_attr_e( 'Our services, slide carousel', 'bis' ); ?>">
                    <?php
                    foreach ($services as $post):
                        setup_postdata($post);

                        $description = get_field('introtext');
                        set_query_var('description', $description);
                        ?>
                        <div class="item">
                            <?php get_template_part('components/cards/service-card'); ?>
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


<section class="py-20 bg-white" aria-labelledby="resources-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <div class="">
            <!-- Section Header -->
            <div class="mb-10" data-aos="fade-up">

                <h2 id="resources-heading"
                class=" text-4xl font-bold text-gray-900 mb-8">
                    Resources
                </h2>
                <div class="w-24 h-px bg-gray-900 mb-4" aria-hidden="true"></div>
                <p class="text-lg lg:text-xl text-gray-600 max-w-3xl leading-relaxed">
                    From helpful guides to cultural insights, our resources empower clients and communities to navigate
                    communication access with confidence and ease.
                </p>
            </div>

            <!-- Resources Carousel -->
            <?php
            $resources = get_posts([
                'post_type' => 'resource',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'title',
                'order' => 'ASC',
            ]);

            if ($resources):
                $carousel_id = 'resources-carousel-' . uniqid();
                ?>
                <div class="owl-carousel owl-theme resources-carousel bg-white" id="<?php echo esc_attr($carousel_id); ?>"
                    role="region" aria-label="<?php esc_attr_e( 'Resources, slide carousel', 'bis' ); ?>">
                    <?php
                    foreach ($resources as $post):
                        setup_postdata($post);

                        $description = get_field('description');
                        set_query_var('description', $description);
                        ?>
                        <div class="item">
                            <?php get_template_part('components/cards/resource-card'); ?>
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

<?php
get_template_part('components/sections/cta');
get_footer();