<section class="relative overflow-hidden flex items-center" aria-label="Page hero">
    <!-- Background -->
    <div class="absolute inset-0 z-0" aria-hidden="true">
        <?php if ($hero_image = get_field('hero_image')) : ?>
            <img
                src="<?php echo esc_url($hero_image); ?>"
                alt=""
                class="w-full h-full object-cover"
                loading="eager"
                fetchpriority="high"
            >
        <?php endif; ?>

        <!-- Mobile / Tablet overlay -->
        <div class="absolute inset-0 bg-black/70 lg:hidden"></div>

        <!-- Desktop gradient -->
        <div class="absolute inset-0 hidden lg:block bg-gradient-to-r from-black via-black/70 to-transparent"></div>
    </div>

    <!-- Content wrapper (flush to max-w edge) -->
    <div class="relative z-20 w-full">
        <div class="max-w-7xl mx-auto py-24">
            <!-- Inner padding only where needed -->
            <div class="px-4 sm:px-6 lg:px-0 pt-8 max-w-4xl">
                
                <?php if ($welcome_text = get_field('welcome_text')) : ?>
                    <div class="mb-6 sm:mb-8" data-aos="fade-up" data-aos-delay="100">
                        <span class="inline-block text-white/80 text-xs sm:text-sm tracking-[0.2em] font-medium uppercase" role="doc-subtitle">
                            <?php echo esc_html($welcome_text); ?>
                        </span>
                        <div class="w-12 sm:w-16 h-px bg-white/40 mt-3 sm:mt-4" aria-hidden="true"></div>
                    </div>
                <?php endif; ?>

                <?php
                $main_heading = get_field('main_heading');
                $heading_text = $main_heading ? wp_kses_post($main_heading) : esc_html(get_the_title());
                ?>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl text-white font-bold mb-6 sm:mb-8 lg:mb-10 tracking-tight leading-[1.1]" data-aos="fade-up" data-aos-delay="200">
                    <?php echo $heading_text; ?>
                </h1>

                <?php if ($description = get_field('description')) : ?>
                    <div class="text-white/90 text-base sm:text-lg lg:text-xl mb-8 sm:mb-10 leading-relaxed max-w-2xl" data-aos="fade-up" data-aos-delay="300">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>

                <?php
                $has_primary   = get_field('first_button_title') && get_field('first_button_link');
                $has_secondary = get_field('second_button_title') && get_field('second_button_link');
                if ($has_primary || $has_secondary) :
                ?>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4" data-aos="fade-up" data-aos-delay="400">
                        <?php if ($has_primary) : ?>
                            <a
                                href="<?php echo esc_url(get_field('first_button_link')); ?>"
                                class="group inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-semibold text-sm sm:text-base px-6 sm:px-8 py-3 sm:py-3.5 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-black/50"
                            >
                                <?php echo esc_html(get_field('first_button_title')); ?>
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12H3m18 0-3.75-3.75M21 12l-3.75 3.75"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if ($has_secondary) : ?>
                            <a
                                href="<?php echo esc_url(get_field('second_button_link')); ?>"
                                class="group inline-flex items-center justify-center border-2 border-white text-white hover:bg-white hover:text-gray-900 font-semibold text-sm sm:text-base px-6 sm:px-8 py-3 sm:py-3.5 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-black/50"
                            >
                                <?php echo esc_html(get_field('second_button_title')); ?>
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12H3m18 0-3.75-3.75M21 12l-3.75 3.75"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Trusted By Logos -->
                <?php 
                $header_logos = get_field('header_logos'); 
                if ($header_logos && is_array($header_logos) && count($header_logos) > 0): 
                ?>
                <div class="mt-12 sm:mt-16" data-aos="fade-up" data-aos-delay="500">
                    <p class="text-white/70 text-xs sm:text-sm font-medium uppercase tracking-wider mb-6">
                        Trusted Partners
                    </p>
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-6 sm:gap-8 max-w-2xl">
                        <?php
                        $logo_index = 0;
                        foreach ($header_logos as $logo):
                            $logo_url = esc_url($logo['url']);
                            $logo_alt = esc_attr($logo['alt'] ?: 'Trusted partner logo');
                            $delay = 550 + ($logo_index * 50);
                            ?>
                            <div class="flex items-center justify-center" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                                <img 
                                    src="<?php echo $logo_url; ?>" 
                                    alt="<?php echo $logo_alt; ?>" 
                                    width="120" 
                                    height="60"
                                    loading="lazy" 
                                    decoding="async"
                                    class="h-12 sm:h-14 w-auto object-contain transition-all duration-300 ease-in-out grayscale opacity-80 hover:grayscale-0 hover:opacity-100" />
                            </div>
                            <?php
                            $logo_index++;
                        endforeach; 
                        ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
