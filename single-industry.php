<?php
get_header();
get_template_part('components/layout/banner');
get_template_part('components/layout/breadcrumb');

// Store page ID to prevent context pollution from relationship field loops
$page_id = get_queried_object_id();
?>

<?php if (get_field('why_piedmont_global_new_title', $page_id)): ?>
    <section class="bg-gradient-to-b from-gray-50 to-white py-20 lg:py-16" aria-labelledby="why-piedmont-title">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-[65%_35%] gap-0">

                    <!-- Left side: Title and Description -->
                    <div class="p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
                        <h2 id="why-piedmont-title" class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight mb-6">
                            <?php echo esc_html(get_field('why_piedmont_global_new_title', $page_id)); ?>
                        </h2>
                        <div class="text-base lg:text-lg text-gray-600 leading-relaxed prose prose-gray max-w-none mb-8">
                            <?php echo wp_kses_post(get_field('why_piedmont_global_new_description', $page_id)); ?>
                        </div>

                        <!-- Two column row with ticks -->
                        <?php if (have_rows('why_piedmont_global_list', $page_id)): ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                                <?php
                                while (have_rows('why_piedmont_global_list', $page_id)):
                                    the_row();
                                    $item = get_sub_field('item');
                                    if ($item):
                                        ?>
                                        <div class="flex items-start gap-3 group">
                            <div
                                class="flex-shrink-0 w-6 h-6 rounded-full bg-[#ed3437]/10 flex items-center justify-center mt-0.5" aria-hidden="true">
                                <svg class="w-4 h-4 text-[#ed3437]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                                            <span
                                                class="text-sm lg:text-base text-gray-700 font-medium"><?php echo esc_html($item); ?></span>
                                        </div>
                                        <?php
                                    endif;
                                endwhile;
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        $why_link = get_field('why_piedmont_global_link_new', $page_id);
                        $link_url = $why_link ? esc_url($why_link) : home_url('/services/');
                        ?>
                        <a href="<?php echo $link_url; ?>"
                            class="inline-flex items-center gap-2 bg-[#ed3437] text-white font-semibold px-6 py-3 rounded-full hover:bg-[#d42d30] focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-offset-2 transition-all duration-300 group self-start shadow-lg shadow-[#ed3437]/25 hover:shadow-xl hover:shadow-[#ed3437]/30"
                            aria-label="Explore full capabilities">
                            <span>Explore Full Capabilities</span>
                            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Right side: Image -->
                    <div class="relative lg:min-h-[500px]">
                        <img src="<?php echo esc_url(get_field('why_piedmont_global_photo_new', $page_id)); ?>"
                            alt="<?php echo esc_attr(get_the_title($page_id)); ?> - BIS World"
                            class="w-full h-full object-cover absolute inset-0">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent lg:bg-gradient-to-r lg:from-white lg:via-transparent lg:to-transparent">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


<?php
// Get first tab key for default active state
$first_tab_key = '';
if (have_rows('tabs', $page_id)) {
    while (have_rows('tabs', $page_id)) {
        the_row();
        $first_tab_key = get_sub_field('tab_key');
        break;
    }
    reset_rows();
}
?>
<?php if (have_rows('tabs', $page_id)): ?>
    <section class="bg-white py-20 lg:py-16" data-aos="fade-up" data-aos-delay="100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-data="{ activeTab: '<?php echo esc_attr($first_tab_key); ?>' }">

                <!-- Header -->
                <header class="text-center mb-12 lg:mb-16" data-aos="fade-up">
                    <h2 id="tabbed-section-title"
                        class="text-3xl lg:text-4xl xl:text-5xl font-bold text-gray-900 leading-tight mb-4">
                        <?php echo esc_html(get_field('tab_section_heading', $page_id)); ?>
                    </h2>
                    <p class="text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        <?php echo wp_kses_post(get_field('tab_section_description', $page_id)); ?>
                    </p>
                </header>

                <?php if (have_rows('tabs', $page_id)): ?>
                    <!-- Tabs -->
                    <div class="flex justify-center mb-12" role="tablist" aria-label="Production Tabs">
                        <div class="inline-flex bg-gray-100 rounded-full p-1.5 gap-1">
                            <?php while (have_rows('tabs', $page_id)):
                                the_row();
                                $tab_key = get_sub_field('tab_key');
                                $tab_title = get_sub_field('tab_title');
                                ?>
                                    <button @click="activeTab = '<?php echo esc_attr($tab_key); ?>'"
                                    :class="activeTab === '<?php echo esc_attr($tab_key); ?>' ? 'bg-[#ed3437] text-white shadow-lg shadow-[#ed3437]/25' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200'"
                                    class="px-5 sm:px-8 py-2.5 rounded-full text-sm font-semibold transition-all duration-300"
                                    role="tab" :aria-selected="activeTab === '<?php echo esc_attr($tab_key); ?>'"
                                    :tabindex="activeTab === '<?php echo esc_attr($tab_key); ?>' ? '0' : '-1'"
                                    aria-controls="<?php echo esc_attr($tab_key); ?>-production"
                                    :id="'tab-<?php echo esc_attr($tab_key); ?>'">
                                    <?php echo esc_html($tab_title); ?>
                                </button>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <!-- Tab Panels -->
                    <?php reset_rows(); ?>
                    <?php while (have_rows('tabs', $page_id)):
                        the_row();
                        $tab_key = get_sub_field('tab_key');
                        // Count cards to determine if carousel is needed
                        $cards_data = get_sub_field('cards');
                        $card_count = is_array($cards_data) ? count($cards_data) : 0;
                        $use_carousel = $card_count > 4;
                        $carousel_id = $use_carousel ? 'cards-carousel-' . $tab_key . '-' . uniqid() : '';
                        $lg_cols = ($card_count > 0 && $card_count < 4) ? $card_count : 4;
                        ?>
                        <div x-show="activeTab === '<?php echo esc_attr($tab_key); ?>'"
                            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
                            id="<?php echo esc_attr($tab_key); ?>-production"
                            role="tabpanel" :aria-labelledby="'tab-<?php echo esc_attr($tab_key); ?>'"
                            tabindex="0">

                            <?php if (have_rows('cards')): ?>
                                <?php if ($use_carousel): ?>
                                    <!-- Carousel for more than 4 cards -->
                                    <div class="owl-carousel owl-theme cards-carousel" id="<?php echo esc_attr($carousel_id); ?>"
                                        role="region" aria-label="<?php echo esc_attr( sprintf( __( '%s cards, slide carousel', 'bis' ), $tab_title ) ); ?>">
                                <?php else: ?>
                                    <!-- Grid layout for 4 or fewer cards -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-<?php echo esc_attr($lg_cols); ?> gap-6 lg:gap-8">
                                <?php endif; ?>
                                
                                <?php
                                $card_index = 0;
                                while (have_rows('cards')):
                                    the_row(); ?>
                                    <?php if ($use_carousel): ?>
                                        <div class="item">
                                    <?php endif; ?>
                                    <article
                                        class="group bg-gray-50 hover:bg-white rounded-2xl p-6 lg:p-8 border border-gray-100 hover:border-gray-200 hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300"
                                        data-aos="fade-up" data-aos-delay="<?php echo ($card_index * 100); ?>"
                                        aria-labelledby="card-title-<?php echo esc_attr($tab_key . '-' . $card_index); ?>">
                                        <?php
                                        $card_icon = get_sub_field('card_icon');
                                        $icon_url = '';
                                        if ($card_icon) {
                                            $icon_url = is_array($card_icon) ? $card_icon['url'] : $card_icon;
                                        }
                                        ?>
                                        <?php if ($icon_url): ?>
                                            <div
                                                class="mb-5 w-12 h-12 rounded-xl bg-[#ed3437]/10 flex items-center justify-center group-hover:bg-[#ed3437]/15 transition-colors duration-300" aria-hidden="true">
                                                <img src="<?php echo esc_url($icon_url); ?>" alt="" class="w-6 h-6">
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="text-lg lg:text-xl font-semibold text-gray-900 mb-4"
                                            id="card-title-<?php echo esc_attr($tab_key . '-' . $card_index); ?>">
                                            <?php the_sub_field('card_title'); ?>
                                        </h3>
                                        <?php if (have_rows('card_items')): ?>
                                            <ul class="space-y-3">
                                                <?php while (have_rows('card_items')):
                                                    the_row(); ?>
                                                    <li class="flex items-start gap-3 text-gray-600">
                                                        <span class="flex-shrink-0 w-1.5 h-1.5 rounded-full bg-[#ed3437] mt-2" aria-hidden="true"></span>
                                                        <span class="text-sm lg:text-base"><?php the_sub_field('item_text'); ?></span>
                                                    </li>
                                                <?php endwhile; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </article>
                                    <?php if ($use_carousel): ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php
                                    $card_index++;
                                endwhile; ?>
                                
                                <?php if ($use_carousel): ?>
                                    </div>
                                <?php else: ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <style>
        /* Screen reader only utility */
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
        
        /* Cards Carousel Styles */
        .cards-carousel .owl-stage {
            display: flex;
            align-items: stretch;
        }
        .cards-carousel .owl-item {
            display: flex;
            height: auto;
        }
        .cards-carousel .owl-item .item {
            width: 100%;
            display: flex;
            height: 100%;
        }
        .cards-carousel .owl-item .item article {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .cards-carousel .owl-item .item article ul {
            flex-grow: 1;
        }
        .cards-carousel .owl-dots {
            margin-top: 3rem;
            text-align: center;
        }
        /* On mobile, hide dots and make it look like a grid */
        @media (max-width: 1023px) {
            .cards-carousel .owl-dots {
                display: none;
            }
            .cards-carousel .owl-stage-outer {
                overflow: visible;
            }
            .cards-carousel .owl-stage {
                display: flex;
                flex-direction: column;
                transform: none !important;
            }
            .cards-carousel .owl-item {
                width: 100% !important;
                margin-bottom: 1.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all cards carousels
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.owlCarousel !== 'undefined') {
                jQuery('.cards-carousel').each(function() {
                    var $carousel = jQuery(this);
                    if (!$carousel.data('owlCarousel')) {
                        $carousel.owlCarousel({
                            loop: false,
                            margin: 16,
                            nav: false,
                            dots: true,
                            autoplay: false,
                            responsive: {
                                0: {
                                    items: 1,
                                    margin: 16
                                },
                                640: {
                                    items: 2,
                                    margin: 16
                                },
                                1024: {
                                    items: 4,
                                    margin: 16
                                }
                            },
                            smartSpeed: 600
                        });
                    }
                });
            }
            
            // Re-initialize carousel when tab is switched (Alpine.js watch)
            // Use MutationObserver to watch for tab changes
            var tabPanels = document.querySelectorAll('[id$="-production"]');
            tabPanels.forEach(function(panel) {
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                            var isVisible = panel.style.display !== 'none';
                            if (isVisible && typeof jQuery !== 'undefined' && typeof jQuery.fn.owlCarousel !== 'undefined') {
                                // Find carousel within this panel and reinitialize if needed
                                var $carousel = jQuery(panel).find('.cards-carousel');
                                if ($carousel.length && !$carousel.data('owlCarousel')) {
                                    setTimeout(function() {
                                        $carousel.owlCarousel({
                                            loop: false,
                                            margin: 16,
                                            nav: false,
                                            dots: true,
                                            autoplay: false,
                                            responsive: {
                                                0: {
                                                    items: 1,
                                                    margin: 16
                                                },
                                                640: {
                                                    items: 2,
                                                    margin: 16
                                                },
                                                1024: {
                                                    items: 4,
                                                    margin: 16
                                                }
                                            },
                                            smartSpeed: 600
                                        });
                                    }, 100);
                                }
                            }
                        }
                    });
                });
                
                observer.observe(panel, {
                    attributes: true,
                    attributeFilter: ['style']
                });
            });
        });
    </script>
<?php endif; ?>

<?php
$tabbed_services = get_field('tabbed_section_cards', $page_id);
if (!empty($tabbed_services) && is_array($tabbed_services)):
    ?>
    <section class="bg-white" aria-labelledby="tabbed-section-title" data-aos="fade-up" data-aos-delay="200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
            <div class="foundation-gradient p-6 sm:p-10 rounded">

                <h2 id="tabbed-section-title"
                    class="text-3xl md:text-4xl lg:text-5xl font-bold leading-[35px] lg:leading-[48px] mb-12 text-center lg:text-left"
                    data-aos="fade-up">
                    <?php echo esc_html(get_field('tabbed_section_heading', $page_id)); ?>
                </h2>

                <div class="w-full pb-10">
                    <div class="grid grid-cols-1 lg:grid-cols-7 gap-10 items-start">

                        <!-- Tab Buttons -->
                        <div class="space-y-4 lg:col-span-3" role="tablist" aria-label="Communication solutions"
                            data-aos="fade-right" data-aos-delay="200">
                            <?php
                            $services = get_field('tabbed_section_cards', $page_id);

                            if (!empty($services) && is_array($services)):
                                $first = true;
                                foreach ($services as $service):
                                    // Get post object if it's an ID
                                    $service_post = is_object($service) ? $service : get_post($service);
                                    if (!$service_post || !isset($service_post->ID)) {
                                        continue;
                                    }

                                    $service_id = $service_post->ID;
                                    $service_title = get_the_title($service_id);
                                    $service_slug = $service_post->post_name;

                                    // Get ACF fields from post
                                    $tagline = get_field('tagline', $service_id);
                                    $primary_description_raw = get_field('primary_description', $service_id);
                                    if (empty($primary_description_raw)) {
                                        $primary_description_raw = get_field('introtext', $service_id);
                                    }
                                    $primary_description = $primary_description_raw ? wp_kses_post($primary_description_raw) : '';
                                    $primary_description_json = $primary_description ? wp_json_encode($primary_description) : '';

                                    // Get hero_image from service post - this is what should display in the large panel
                                    $hero_image = get_field('hero_image', $service_id);
                                    $image_url = '';

                                    // Handle ACF image field - can be array, URL string, or ID
                                    if (is_array($hero_image) && isset($hero_image['url'])) {
                                        $image_url = $hero_image['url'];
                                    } elseif (is_string($hero_image) && !empty($hero_image)) {
                                        $image_url = $hero_image;
                                    } elseif (is_numeric($hero_image)) {
                                        $image_url = wp_get_attachment_image_url($hero_image, 'full');
                                    }

                                    // Fallback to featured_image if hero_image not available
                                    if (empty($image_url)) {
                                        $image = get_field('featured_image', $service_id);
                                        if (is_array($image) && isset($image['url'])) {
                                            $image_url = $image['url'];
                                        } elseif (is_string($image) && !empty($image)) {
                                            $image_url = $image;
                                        } elseif (is_numeric($image)) {
                                            $image_url = wp_get_attachment_image_url($image, 'full');
                                        } elseif (has_post_thumbnail($service_id)) {
                                            $image_url = get_the_post_thumbnail_url($service_id, 'thumbnail');
                                        }
                                    }

                                    // For the button icon, use iconography field with fallback
                                    $button_icon_url = get_field('iconography', $service_id);
                                    if (empty($button_icon_url)) {
                                        $button_icon_url = 'https://bisworld.com/wp-content/uploads/2026/01/question-mark-outline-svgrepo-com.svg';
                                    }

                                    // Get post permalink
                                    $service_link = get_permalink($service_id);
                                    ?>
                                    <button data-tab="<?php echo esc_attr($service_slug); ?>"
                                        data-title="<?php echo esc_attr($service_title); ?>"
                                        data-description="<?php echo esc_attr($tagline ? $tagline : ''); ?>"
                                        data-primary-description="<?php echo esc_attr($primary_description_json); ?>"
                                        data-image="<?php echo esc_url($image_url ? $image_url : 'https://pgsandbox.wpenginepowered.com/wp-content/uploads/image-mockup-png-min-scaled.png'); ?>"
                                        data-link="<?php echo esc_url($service_link); ?>"
                                        class="tab-button w-full flex items-center gap-3 py-3 px-4 text-left transition text-gray-800 border border-transparent rounded-lg"
                                        role="tab" type="button" aria-selected="<?php echo $first ? 'true' : 'false'; ?>"
                                        aria-controls="tab-panel-<?php echo esc_attr($service_slug); ?>">
                                        <img src="<?php echo esc_url($button_icon_url ? $button_icon_url : get_template_directory_uri() . '/assets/hc/icon.png'); ?>"
                                            alt="" class="w-5 h-5 flex-shrink-0 rounded-full object-cover" aria-hidden="true">
                                        <span class="flex-1 text-lg"><?php echo esc_html($service_title); ?></span>
                                        <span class="ml-auto arrow <?php echo $first ? '' : 'hidden'; ?>"
                                            aria-hidden="true">→</span>
                                    </button>
                                    <?php
                                    $first = false;
                                endforeach;
                                // CRITICAL: Reset post data after processing foreign posts to prevent context pollution
                                wp_reset_postdata();
                            endif;
                            ?>

                            <?php
                            $tabbed_link_field = get_field('tabbed_section_link', $page_id);
                            $tabbed_link_url = '#';
                            if ($tabbed_link_field) {
                                if (is_array($tabbed_link_field) && isset($tabbed_link_field['url'])) {
                                    $tabbed_link_url = $tabbed_link_field['url'];
                                } elseif (is_string($tabbed_link_field) && filter_var($tabbed_link_field, FILTER_VALIDATE_URL)) {
                                    $tabbed_link_url = $tabbed_link_field;
                                } elseif (is_numeric($tabbed_link_field) || is_object($tabbed_link_field)) {
                                    $tabbed_link_url = get_permalink($tabbed_link_field);
                                }
                            }
                            ?>
                            <a href="<?php echo esc_url($tabbed_link_url !== '#' ? $tabbed_link_url : '/services/'); ?>"
                                class="pt-12 inline-flex self-start items-center text-base font-medium group focus:outline-none focus:ring-2 focus:ring-[#D16555] focus:ring-offset-2 transition-colors duration-200">
                                <span class="border-b-2 border-[#D16555] pb-0.5">Explore full capabilities</span>
                                <span
                                    class="ml-1 text-lg transform transition-transform duration-300 group-hover:translate-x-1"
                                    aria-hidden="true">→</span>
                            </a>
                        </div>

                        <!-- Tab Panel -->
                        <div class="lg:col-span-4 relative mt-8 lg:mt-0 h-[300px] sm:h-[400px] lg:h-[450px]"
                            data-aos="fade-left" data-aos-delay="300">
                            <div id="tab-content" class="w-full h-full relative rounded-[4px] overflow-hidden">
                                <?php
                                // Get first service link for initial state
                                $first_service_link = '#';
                                $services_for_link = get_field('tabbed_section_cards', $page_id);
                                if (!empty($services_for_link) && is_array($services_for_link)) {
                                    $first_service_obj = is_object($services_for_link[0]) ? $services_for_link[0] : get_post($services_for_link[0]);
                                    if ($first_service_obj && isset($first_service_obj->ID)) {
                                        $first_service_link = get_permalink($first_service_obj->ID);
                                    }
                                }

                                // CRITICAL: Use explicit page_id to prevent context pollution from service post loops above
                                // The global $post has been contaminated by get_post() calls in the foreach loop above
                                $hero_image = get_field('hero_image', $page_id);
                                $hero_alt = get_field('main_heading', $page_id) ?: get_the_title($page_id);
                                $panel_image = '';

                                // Handle ACF image field - can be array, URL string, or ID
                                if (is_array($hero_image) && isset($hero_image['url'])) {
                                    $panel_image = $hero_image['url'];
                                } elseif (is_string($hero_image) && !empty($hero_image)) {
                                    $panel_image = $hero_image;
                                } elseif (is_numeric($hero_image)) {
                                    $panel_image = wp_get_attachment_image_url($hero_image, 'full');
                                }

                                // Fallback if no image found
                                if (empty($panel_image)) {
                                    $panel_image = 'https://pgsandbox.wpenginepowered.com/wp-content/uploads/image-mockup-png-min-scaled.png';
                                }
                                ?>
                                <a id="tab-image-link" href="<?php echo esc_url($first_service_link); ?>"
                                    class="flex flex-col h-full w-full rounded-2xl bg-white/70 backdrop-blur-sm border border-black/20 shadow-[0_1px_3px_rgba(0,0,0,0.04)] transition-all duration-500  hover:shadow-[0_8px_30px_rgba(237,52,55,0.08)] overflow-hidden group focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed3437]/40 focus-visible:ring-offset-2"
                                    aria-label="Learn more about <?php echo esc_attr($hero_alt); ?>">
                                    
                                    <!-- Featured Image -->
                                    <div class="relative flex-[0_0_60%] overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 m-3 rounded-xl">
                                        <img id="tab-image" src="<?php echo esc_url($panel_image); ?>"
                                            alt="<?php echo esc_attr($hero_alt); ?>"
                                            data-hero-image="<?php echo esc_url($panel_image); ?>"
                                            class="h-full w-full object-cover rounded-xl transition-transform duration-700 ease-out group-hover:scale-105" />
                                    </div>

                                    <!-- Content -->
                                    <div class="flex flex-1 flex-col justify-between px-6 pt-3 lg:px-8">
                                        <div class="flex-1">
                                            <?php
                                            // Get initial description from first service post
                                            $services_desc = get_field('tabbed_section_cards', $page_id);
                                            $initial_description = '';
                                            if (!empty($services_desc) && is_array($services_desc)) {
                                                $first_service = is_object($services_desc[0]) ? $services_desc[0] : get_post($services_desc[0]);
                                                if ($first_service && isset($first_service->ID)) {
                                                    $initial_description = get_field('introtext', $first_service->ID);
                                                    if (empty($initial_description)) {
                                                        $initial_description = get_field('primary_description', $first_service->ID);
                                                    }
                                                }
                                            }
                                            ?>
                                            <!-- Description -->
                                            <div id="tab-description-text" class="text-lg  leading-relaxed text-gray-800 tracking-tight transition-colors duration-500 group-hover:text-gray-950 line-clamp-3">
                                                <?php echo wp_kses_post($initial_description ? $initial_description : ''); ?>
                                            </div>
                                          
                                        </div>
                                       
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
    </section>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateTab(button) {
            if (!button) {
                console.error('updateTab: button is null or undefined');
                return;
            }

            // Update all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                const isActive = btn === button;
                const arrow = btn.querySelector('.arrow');

                if (isActive) {
                    btn.classList.add('shadow-lg', 'border-gray-300', 'bg-white', 'medium');
                    btn.classList.remove('book');
                    btn.setAttribute('aria-selected', 'true');
                    if (arrow) {
                        arrow.classList.remove('hidden');
                    }
                } else {
                    btn.classList.remove('shadow-lg', 'border-gray-300', 'bg-white', 'medium');
                    btn.classList.add('book');
                    btn.setAttribute('aria-selected', 'false');
                    if (arrow) {
                        arrow.classList.add('hidden');
                    }
                }
            });

            // Update content
            const tabTitle = document.getElementById('tab-title');
            const tabDescription = document.getElementById('tab-description');
            const tabDescriptionText = document.getElementById('tab-description-text');
            const tabImage = document.getElementById('tab-image');
            const tabImageLink = document.getElementById('tab-image-link');
            const tabContent = document.getElementById('tab-content');
            const tabLink = document.getElementById('tab-link');

            if (tabTitle && button.dataset.title) {
                tabTitle.textContent = button.dataset.title;
            }

            if (tabDescription && button.dataset.description) {
                tabDescription.textContent = button.dataset.description;
            }

            // Update primary description text
            if (tabDescriptionText && button.dataset.primaryDescription) {
                try {
                    const decodedDescription = JSON.parse(button.dataset.primaryDescription);
                    tabDescriptionText.innerHTML = decodedDescription;
                } catch (e) {
                    // Fallback if JSON parsing fails
                    tabDescriptionText.innerHTML = button.dataset.primaryDescription;
                }
                
                // Announce to screen readers
                const announcement = document.createElement('div');
                announcement.setAttribute('role', 'status');
                announcement.setAttribute('aria-live', 'polite');
                announcement.className = 'sr-only';
                announcement.textContent = 'Content updated for ' + button.dataset.title;
                document.body.appendChild(announcement);
                setTimeout(() => announcement.remove(), 1000);
            }

            // Update image with fade animation on tab switch
            if (tabImage) {
                const newImageUrl = button.dataset.image;
                const fallbackImage = tabImage.dataset.heroImage ||
                    'https://pgsandbox.wpenginepowered.com/wp-content/uploads/image-mockup-png-min-scaled.png';

                // Use the new image URL if available, otherwise use hero image fallback
                const imageToLoad = newImageUrl && newImageUrl.trim() !== '' ? newImageUrl : fallbackImage;

                // Check if we're switching to a different image
                if (tabImage.src !== imageToLoad && imageToLoad) {
                    // Fade out current image
                    tabImage.classList.add('opacity-0');

                    // Preload the new image to ensure smooth transition
                    const img = new Image();
                    let imageLoaded = false;

                    const updateImage = () => {
                        if (!imageLoaded) {
                            imageLoaded = true;
                            setTimeout(() => {
                                tabImage.src = imageToLoad;
                                // Update alt text if title is available
                                if (button.dataset.title) {
                                    tabImage.alt = button.dataset.title;
                                }
                                // Fade in
                                tabImage.classList.remove('opacity-0');
                            }, 150);
                        }
                    };

                    // Handle successful load
                    img.onload = updateImage;

                    // Handle load error - use fallback
                    img.onerror = function () {
                        if (!imageLoaded) {
                            imageLoaded = true;
                            setTimeout(() => {
                                tabImage.src = fallbackImage;
                                if (button.dataset.title) {
                                    tabImage.alt = button.dataset.title;
                                }
                                tabImage.classList.remove('opacity-0');
                            }, 150);
                        }
                    };

                    // Start loading the image
                    img.src = imageToLoad;

                    // If image is already cached, onload might not fire, so check complete property
                    if (img.complete) {
                        updateImage();
                    }
                } else if (button.dataset.title) {
                    // Even if image doesn't change, update alt text
                    tabImage.alt = button.dataset.title;
                }
            }

            // Update image link to point to the active service
            if (tabImageLink && button.dataset.link) {
                tabImageLink.href = button.dataset.link;
            }

            if (tabLink && button.dataset.link) {
                tabLink.href = button.dataset.link;
            }

            if (tabContent && button.dataset.tab) {
                tabContent.setAttribute('aria-labelledby', button.dataset.tab);
            }
        }

        // Attach click handlers
        const tabButtons = document.querySelectorAll('.tab-button');

        if (tabButtons.length === 0) {
            console.warn('No tab buttons found with selector .tab-button');
            return;
        }

        tabButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                updateTab(btn);
            });
        });

        // Attach keyboard handlers
        tabButtons.forEach((btn, index, buttons) => {
            btn.addEventListener('keydown', e => {
                let newIndex;
                if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
                    e.preventDefault();
                    newIndex = (index + 1) % buttons.length;
                } else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
                    e.preventDefault();
                    newIndex = (index - 1 + buttons.length) % buttons.length;
                } else if (e.key === 'Home') {
                    e.preventDefault();
                    newIndex = 0;
                } else if (e.key === 'End') {
                    e.preventDefault();
                    newIndex = buttons.length - 1;
                }
                if (newIndex !== undefined) {
                    buttons[newIndex].focus();
                    updateTab(buttons[newIndex]);
                }
            });
        });

        // Initialize first tab as active on page load
        if (tabButtons.length > 0) {
            updateTab(tabButtons[0]);
        }
    });
</script>

<?php if (have_rows('alternate_green_section_repeater', $page_id)): ?>
    <section class="bg-gradient-to-b from-gray-50 to-white py-20 lg:py-24" aria-labelledby="alternate-section-title"
        data-aos="fade-up" data-aos-delay="300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
            <div class=" rounded-3xl  overflow-hidden border border-gray-100">

                <!-- Centered Title -->
                <div class="text-center px-8 pt-12 pb-8 lg:pt-16 lg:pb-12" data-aos="fade-up">
                    <h2 id="alternate-section-title"
                        class="text-3xl lg:text-4xl xl:text-5xl font-bold text-gray-900 leading-tight mb-4">
                        <?php echo esc_html(get_field('alternate_green_section_title', $page_id)); ?>
                    </h2>
                </div>

                <!-- Columns: image left, content right -->
                <?php
                // Collect repeater data and images
                $repeater_items = [];
                $repeater_images = [];
                if (have_rows('alternate_green_section_repeater', $page_id)):
                    while (have_rows('alternate_green_section_repeater', $page_id)):
                        the_row();
                        $repeater_items[] = [
                            'title' => get_sub_field('title'),
                            'description' => get_sub_field('description'),
                            'image' => get_sub_field('image')
                        ];
                        $img = get_sub_field('image');
                        if ($img) {
                            $repeater_images[] = is_array($img) ? $img['url'] : $img;
                        }
                    endwhile;
                endif;

                // Get first image from repeater, fallback to featured image
                $section_image = '';
                if (!empty($repeater_images)) {
                    $section_image = $repeater_images[0];
                } elseif (has_post_thumbnail($page_id)) {
                    $section_image = get_the_post_thumbnail_url($page_id, 'full');
                }
                ?>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    <!-- Left column: image -->
                    <div class="relative lg:min-h-[500px] order-2 lg:order-1">
                        <?php if ($section_image): ?>
                            <img id="alternate-section-image" src="<?php echo esc_url($section_image); ?>"
                                alt="<?php echo esc_attr(get_field('alternate_green_section_title', $page_id) ?: get_the_title($page_id)); ?>"
                                class="w-full h-full object-cover transition-opacity duration-300"
                                data-images="<?php echo esc_attr(json_encode($repeater_images)); ?>">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent lg:bg-gradient-to-r lg:from-white lg:via-transparent lg:to-transparent">
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Right column: content -->
                    <div class="p-8 sm:p-12 lg:p-16 flex flex-col justify-center order-1 lg:order-2" data-aos="fade-left"
                        data-aos-delay="200">
                        <div id="items-container" class="space-y-6 mb-6">
                            <?php if (!empty($repeater_items)): ?>
                                <?php foreach ($repeater_items as $idx => $item):
                                    $is_active   = ( 0 === $idx );
                                    $trigger_id  = 'alt-trigger-' . $idx;
                                    $panel_id    = 'alt-panel-' . $idx;
                                    $number_text = str_pad( $idx + 1, 2, '0', STR_PAD_LEFT );
                                    $number_classes = $is_active
                                        ? 'bg-[#ed3437] text-white shadow-lg shadow-[#ed3437]/25'
                                        : 'bg-gray-100 text-gray-700';
                                    $title_classes = $is_active ? 'text-gray-900' : 'text-gray-700';
                                ?>
                                    <div class="alt-item group transition-all duration-300" data-index="<?php echo (int) $idx; ?>">
                                        <h3 class="m-0">
                                            <button
                                                type="button"
                                                id="<?php echo esc_attr( $trigger_id ); ?>"
                                                class="alt-trigger w-full flex items-start gap-4 text-left p-4 -mx-4 rounded-xl transition-all duration-300 hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed3437] focus-visible:ring-offset-2"
                                                aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
                                                aria-controls="<?php echo esc_attr( $panel_id ); ?>">
                                                <span class="flex flex-col items-center gap-2 flex-shrink-0" aria-hidden="true">
                                                    <span class="item-number-pill w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 <?php echo esc_attr( $number_classes ); ?>">
                                                        <span class="item-number text-lg font-bold"><?php echo esc_html( $number_text ); ?></span>
                                                    </span>
                                                    <span class="item-timer w-1 h-16 bg-gray-100 rounded-full overflow-hidden <?php echo $is_active ? '' : 'hidden'; ?>">
                                                        <span class="block w-full h-full bg-[#ed3437] vertical-timer-fill"></span>
                                                    </span>
                                                </span>
                                                <span class="flex-1 block">
                                                    <span class="item-title block text-xl font-semibold transition-colors duration-300 <?php echo esc_attr( $title_classes ); ?>">
                                                        <?php echo esc_html( $item['title'] ); ?>
                                                    </span>
                                                </span>
                                            </button>
                                        </h3>
                                        <?php if ( ! empty( $item['description'] ) ) : ?>
                                            <div
                                                id="<?php echo esc_attr( $panel_id ); ?>"
                                                class="item-description text-base leading-relaxed text-gray-700 mt-2 ml-16"
                                                role="region"
                                                aria-labelledby="<?php echo esc_attr( $trigger_id ); ?>"
                                                <?php echo $is_active ? '' : 'hidden'; ?>>
                                                <?php echo wp_kses_post( $item['description'] ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <?php if ( count( $repeater_items ) > 1 ) : ?>
                            <div class="mb-10">
                                <button type="button"
                                    id="alt-autoplay-toggle"
                                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed3437] focus-visible:ring-offset-2 rounded-md px-3 py-2 border border-gray-300 hover:bg-gray-50"
                                    aria-pressed="false"
                                    data-pause-label="<?php esc_attr_e( 'Pause auto-rotation', 'bis' ); ?>"
                                    data-play-label="<?php esc_attr_e( 'Resume auto-rotation', 'bis' ); ?>">
                                    <svg class="w-4 h-4 alt-autoplay-icon-pause" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" focusable="false">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                    </svg>
                                    <svg class="w-4 h-4 alt-autoplay-icon-play hidden" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" focusable="false">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                    </svg>
                                    <span class="alt-autoplay-label"><?php esc_html_e( 'Pause auto-rotation', 'bis' ); ?></span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <button
                            class="js-open-sandbox-modal inline-flex items-center gap-2 bg-[#ed3437] text-white font-semibold px-6 py-3 rounded-full hover:bg-[#d42d30] focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-offset-2 transition-all duration-300 group self-start shadow-lg shadow-[#ed3437]/25 hover:shadow-xl hover:shadow-[#ed3437]/30"
                            type="button" aria-haspopup="dialog" aria-expanded="false"
                            aria-label="Contact our <?php echo strtolower(get_the_title($page_id)); ?> expert">
                            <span>Contact our <?php echo strtolower(get_the_title($page_id)); ?> expert</span>
                            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <style>
        @keyframes verticalTimerFill {
            from { transform: scaleY(0); transform-origin: top; }
            to   { transform: scaleY(1); transform-origin: top; }
        }
        .vertical-timer-fill {
            transform-origin: top;
            transform: scaleY(0);
            display: block;
        }
        @media (prefers-reduced-motion: reduce) {
            .vertical-timer-fill {
                animation: none !important;
                transform: scaleY(1);
            }
            #alternate-section-image {
                transition: none !important;
            }
        }
    </style>
    <script>
        (function () {
            var container = document.getElementById('items-container');
            if (!container) { return; }

            var section          = container.closest('section');
            var items            = container.querySelectorAll('.alt-item');
            var totalItems       = items.length;
            if (!totalItems) { return; }

            var sectionImage     = document.getElementById('alternate-section-image');
            var pauseToggle      = document.getElementById('alt-autoplay-toggle');
            var motionQuery      = window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;
            var prefersReduced   = !!(motionQuery && motionQuery.matches);

            var images = [];
            if (sectionImage && sectionImage.dataset.images) {
                try { images = JSON.parse(sectionImage.dataset.images); } catch (e) { images = []; }
            }

            var DURATION       = 5000;
            var activeIndex    = 0;
            var autoPlayTimer  = null;
            var initialized    = false;
            var inView         = false;
            var userPaused     = false;
            var hasFocusInside = false;

            function setActiveVisuals(index) {
                Array.prototype.forEach.call(items, function (el, i) {
                    var isActive    = ( i === index );
                    var trigger     = el.querySelector('.alt-trigger');
                    var pill        = el.querySelector('.item-number-pill');
                    var title       = el.querySelector('.item-title');
                    var description = el.querySelector('.item-description');
                    var timer       = el.querySelector('.item-timer');
                    var timerFill   = timer ? timer.querySelector('.vertical-timer-fill') : null;

                    if (trigger) {
                        trigger.setAttribute('aria-expanded', isActive ? 'true' : 'false');
                    }
                    if (pill) {
                        pill.className = 'item-number-pill w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 ' +
                            (isActive
                                ? 'bg-[#ed3437] text-white shadow-lg shadow-[#ed3437]/25'
                                : 'bg-gray-100 text-gray-700');
                    }
                    if (title) {
                        title.className = 'item-title block text-xl font-semibold transition-colors duration-300 ' +
                            (isActive ? 'text-gray-900' : 'text-gray-700');
                    }
                    if (description) {
                        if (isActive) { description.removeAttribute('hidden'); }
                        else          { description.setAttribute('hidden', ''); }
                    }
                    if (timer) {
                        if (isActive) { timer.classList.remove('hidden'); }
                        else          { timer.classList.add('hidden'); }
                    }
                    if (timerFill) {
                        if (isActive && !prefersReduced && !userPaused && !hasFocusInside) {
                            timerFill.style.transform = 'scaleY(0)';
                            timerFill.style.transformOrigin = 'top';
                            void timerFill.offsetHeight;
                            timerFill.style.animation = 'verticalTimerFill ' + DURATION + 'ms linear forwards';
                        } else {
                            timerFill.style.animation = 'none';
                            timerFill.style.transform = isActive ? 'scaleY(1)' : 'scaleY(0)';
                        }
                    }
                });

                if (sectionImage && images.length && images[index]) {
                    var nextSrc = images[index];
                    if (sectionImage.src !== nextSrc) {
                        if (prefersReduced) {
                            sectionImage.src = nextSrc;
                        } else {
                            sectionImage.classList.add('opacity-0');
                            window.setTimeout(function () {
                                sectionImage.src = nextSrc;
                                sectionImage.classList.remove('opacity-0');
                            }, 150);
                        }
                    }
                }
            }

            function stopAutoPlay() {
                if (autoPlayTimer) {
                    window.clearTimeout(autoPlayTimer);
                    autoPlayTimer = null;
                }
            }

            function scheduleNext() {
                stopAutoPlay();
                if (prefersReduced || userPaused || hasFocusInside || !inView) { return; }
                autoPlayTimer = window.setTimeout(function () {
                    activeIndex = (activeIndex + 1) % totalItems;
                    setActiveVisuals(activeIndex);
                    scheduleNext();
                }, DURATION);
            }

            function setActive(index) {
                activeIndex = index;
                setActiveVisuals(activeIndex);
                scheduleNext();
            }

            function updatePauseToggleUI() {
                if (!pauseToggle) { return; }
                var iconPause = pauseToggle.querySelector('.alt-autoplay-icon-pause');
                var iconPlay  = pauseToggle.querySelector('.alt-autoplay-icon-play');
                var label     = pauseToggle.querySelector('.alt-autoplay-label');
                pauseToggle.setAttribute('aria-pressed', userPaused ? 'true' : 'false');
                if (userPaused) {
                    if (iconPause) { iconPause.classList.add('hidden'); }
                    if (iconPlay)  { iconPlay.classList.remove('hidden'); }
                    if (label && pauseToggle.dataset.playLabel)  { label.textContent = pauseToggle.dataset.playLabel; }
                } else {
                    if (iconPause) { iconPause.classList.remove('hidden'); }
                    if (iconPlay)  { iconPlay.classList.add('hidden'); }
                    if (label && pauseToggle.dataset.pauseLabel) { label.textContent = pauseToggle.dataset.pauseLabel; }
                }
            }

            function init() {
                if (initialized) { return; }
                initialized = true;

                Array.prototype.forEach.call(items, function (el) {
                    var trigger = el.querySelector('.alt-trigger');
                    if (!trigger) { return; }
                    trigger.addEventListener('click', function () {
                        setActive(parseInt(el.dataset.index, 10));
                    });
                    trigger.addEventListener('focus', function () {
                        hasFocusInside = true;
                        stopAutoPlay();
                        setActiveVisuals(activeIndex);
                    });
                    trigger.addEventListener('blur', function () {
                        // Defer so we can detect if focus moved to another trigger inside the section.
                        window.setTimeout(function () {
                            if (section && section.contains(document.activeElement) && document.activeElement !== document.body) {
                                hasFocusInside = section.querySelector('.alt-trigger:focus') !== null;
                            } else {
                                hasFocusInside = false;
                            }
                            if (!hasFocusInside) {
                                scheduleNext();
                                setActiveVisuals(activeIndex);
                            }
                        }, 0);
                    });
                });

                if (pauseToggle) {
                    pauseToggle.addEventListener('click', function () {
                        userPaused = !userPaused;
                        updatePauseToggleUI();
                        if (userPaused) {
                            stopAutoPlay();
                            setActiveVisuals(activeIndex);
                        } else {
                            scheduleNext();
                            setActiveVisuals(activeIndex);
                        }
                    });
                    updatePauseToggleUI();
                }

                if (motionQuery) {
                    var motionListener = function (e) {
                        prefersReduced = e.matches;
                        if (prefersReduced) {
                            stopAutoPlay();
                        } else if (!userPaused && !hasFocusInside && inView) {
                            scheduleNext();
                        }
                        setActiveVisuals(activeIndex);
                    };
                    if (motionQuery.addEventListener) {
                        motionQuery.addEventListener('change', motionListener);
                    } else if (motionQuery.addListener) {
                        motionQuery.addListener(motionListener);
                    }
                }

                setActiveVisuals(activeIndex);
            }

            function setupIntersectionObserver() {
                if (!section || !('IntersectionObserver' in window)) {
                    inView = true;
                    init();
                    scheduleNext();
                    return;
                }
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        inView = entry.isIntersecting;
                        if (inView) {
                            init();
                            scheduleNext();
                        } else {
                            stopAutoPlay();
                        }
                    });
                }, { threshold: 0.2, rootMargin: '0px' });
                observer.observe(section);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setupIntersectionObserver);
            } else {
                setupIntersectionObserver();
            }
        })();
    </script>
<?php endif; ?>



<?php
// Check if the page has content
$page_content = get_post_field('post_content', $page_id);
$has_content = !empty(trim($page_content));

if ($has_content):
    // Set the global post to ensure the_content() works correctly
    global $post;
    $post = get_post($page_id);
    setup_postdata($post);
?>
<!-- Content Section -->
<section class="py-20 lg:py-24 bg-white" aria-label="Main content">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<?php get_template_part( 'components/content/blog-content' ); ?>
	</div>
</section>
<?php
    wp_reset_postdata();
endif;
?>

<?php
// Get ACF Repeater field with title and description
$faqs = get_field('faqs', $page_id);

// Check if there are FAQs with valid questions before rendering the section
$has_valid_faqs = false;
if ($faqs && !empty($faqs) && is_array($faqs)) {
    foreach ($faqs as $faq) {
        if (!empty($faq['question'])) {
            $has_valid_faqs = true;
            break;
        }
    }
}

// Only render the section if there are valid FAQs
if ($has_valid_faqs):
?>
<section class="bg-white" aria-labelledby="faq-section-title">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">

        <?php 
        $current_post_id = get_the_ID();
        if (!in_array($current_post_id, [306, 311])): 
        ?>
        <div class="text-center px-8 pt-12 pb-8 lg:pt-16 lg:pb-12" data-aos="fade-up">
            <h2 id="faq-section-title"
                class="text-3xl lg:text-4xl xl:text-4xl font-bold text-gray-900 leading-tight mb-4">
                Frequently Asked Questions
            </h2>
        </div>
        <?php endif; ?>


        <!-- FAQ Accordion -->
        <?php
        $accordion_id = 'faq-accordion';
        ?>
        <div class="space-y-2 pt-8" id="<?php echo esc_attr($accordion_id); ?>">
            <?php foreach ($faqs as $index => $faq):
                $title = !empty($faq['question']) ? $faq['question'] : '';
                $description = !empty($faq['answer']) ? $faq['answer'] : '';

                if (empty($title)) {
                    continue;
                }

                // All items closed by default
                $is_first = false;
                $is_expanded = 'false';
                $expanded_class = '';
                $content_classes = 'accordion-content accordion-content-wrapper max-h-0 overflow-hidden opacity-0 transition-all duration-500 ease-out';
                $icon_transform = 'rotate(0deg)';
                ?>
                <div class="accordion-item group bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-300 overflow-hidden transition-all duration-500 ease-out hover:border-gray-400 hover:shadow-lg hover:shadow-black/5 hover:bg-white/90 <?php echo esc_attr($expanded_class); ?>"
                    data-index="<?php echo esc_attr($index); ?>">
                    <button
                        class="accordion-toggle w-full px-8 py-6 text-left flex items-center justify-between focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500/50 focus-visible:ring-offset-2 transition-colors duration-200 hover:bg-gray-50/50"
                        aria-expanded="<?php echo esc_attr($is_expanded); ?>"
                        aria-controls="faq-content-<?php echo esc_attr($index); ?>"
                        id="faq-button-<?php echo esc_attr($index); ?>">
                        <span
                            class="text-[20px] font-semibold text-gray-900 tracking-tight leading-snug pr-8"><?php echo esc_html($title); ?></span>
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100/80 flex items-center justify-center transition-all duration-300 group-hover:bg-gray-200/80" aria-hidden="true">
                            <svg class="w-4 h-4 text-gray-600 transform transition-transform duration-500 ease-out"
                                style="transform: <?php echo esc_attr($icon_transform); ?>;" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </button>
                    <div class="<?php echo esc_attr($content_classes); ?>"
                        id="faq-content-<?php echo esc_attr($index); ?>"
                        role="region"
                        aria-labelledby="faq-button-<?php echo esc_attr($index); ?>">
                        <div class="px-8 pb-6 pt-0">
                            <div class="text-base md:text-lg text-gray-600 leading-relaxed blog-text tracking-normal">
                                <?php echo wp_kses_post($description); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
get_template_part('components/sections/cta');
get_template_part('components/sections/logo-carousel');
get_footer();
?>