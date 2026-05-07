<?php
get_header();
get_template_part('components/layout/banner');
get_template_part( 'components/layout/breadcrumb' ); ?>

<!-- Section 1: Image Left, Content Right -->
<section class="relative bg-white w-full py-20 lg:py-28">
    
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Left: Featured Image -->
            <div class="relative group">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-gray-900/10">
                    <?php 
                    $primary_image = get_field('primary_image');
                    $fallback_image = 'https://bisworld.com/wp-content/uploads/2026/01/DMV-event-scaled.jpg';
                    if ($primary_image): 
                    ?>
                        <img src="<?php echo esc_url($primary_image); ?>" 
                             alt="<?php echo esc_attr(get_the_title()); ?>" 
                             class="w-full aspect-[4/3] object-cover transition-transform duration-700 group-hover:scale-105">
                    <?php elseif (get_the_post_thumbnail_url(get_the_ID(), 'large')): ?>
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" 
                             alt="<?php echo esc_attr(get_the_title()); ?>" 
                             class="w-full aspect-[4/3] object-cover transition-transform duration-700 group-hover:scale-105">
                    <?php else: ?>
                        <img src="<?php echo esc_url($fallback_image); ?>" 
                             alt="<?php echo esc_attr(get_the_title()); ?>" 
                             class="w-full aspect-[4/3] object-cover transition-transform duration-700 group-hover:scale-105">
                    <?php endif; ?>
                    
                    <!-- Overlay gradient -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#ed1c24]/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                
            </div>
            
            <!-- Right: Content -->
            <div class="lg:pl-8">
                <!-- Eyebrow Badge -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center gap-3 px-4 py-2 bg-[#ed1c24]/10 rounded-full border border-[#ed1c24]/20">
                        <div class="w-2 h-2 bg-[#ed1c24] rounded-full animate-pulse"></div>
                        <span class="text-[#ed1c24] text-xs font-bold uppercase tracking-[0.2em]">
                            <?php echo wp_kses_post(get_field('section_title')); ?>
                        </span>
                    </div>
                </div>
                
                <!-- Title -->
                <?php if (get_field('hero_title')): ?>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
                        <?php echo esc_html(get_field('hero_title')); ?>
                    </h2>
                <?php endif; ?>
                
                <!-- Primary Description -->
                <div class="text-gray-600 text-lg leading-relaxed prose prose-lg prose-gray prose-p:text-gray-600 prose-strong:text-gray-900 prose-a:text-[#ed1c24] prose-a:no-underline hover:prose-a:underline max-w-none mb-8">
                    <?php echo wp_kses_post(get_field('primary_description')); ?>
                </div>
                
                <!-- CTA Button -->
                <?php 
                $hero_cta = get_field('hero_cta_group');
                if ($hero_cta && !empty($hero_cta['hero_button_text']) && !empty($hero_cta['hero_button_link'])): 
                ?>
                    <a href="<?php echo esc_url($hero_cta['hero_button_link']); ?>" 
                       class="inline-flex items-center gap-2 px-8 py-4 bg-[#ed1c24] text-white font-semibold rounded-full hover:bg-[#d91920] transition-all duration-300 shadow-lg shadow-[#ed1c24]/30 hover:shadow-xl hover:shadow-[#ed1c24]/40 hover:-translate-y-0.5">
                        <?php echo esc_html($hero_cta['hero_button_text']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Content Left, Image Right -->
<section class="relative bg-gradient-to-b from-gray-50 to-white w-full py-20 lg:py-28">
    
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Left: Content -->
            <div class="order-2 lg:order-1 lg:pr-2">
                <!-- Eyebrow Badge -->
                <?php if (get_field('secondary_eyebrow')): ?>
                    <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center gap-3 px-4 py-2 bg-[#ed1c24]/10 rounded-full border border-[#ed1c24]/20">
                        <div class="w-2 h-2 bg-[#ed1c24] rounded-full animate-pulse"></div>
                        <span class="text-[#ed1c24] text-xs font-bold uppercase tracking-[0.2em]">
                            <?php echo wp_kses_post(get_field('secondary_eyebrow')); ?>
                        </span>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Title -->
                <?php if (get_field('secondary_title')): ?>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
                        <?php echo esc_html(get_field('secondary_title')); ?>
                    </h2>
                <?php endif; ?>
                
                <!-- Supporting Description -->
                <div class="text-gray-600 text-lg leading-relaxed prose prose-lg prose-gray prose-p:text-gray-600 prose-strong:text-gray-900 prose-a:text-[#ed1c24] prose-a:no-underline hover:prose-a:underline max-w-none mb-8">
                    <?php echo wp_kses_post(get_field('supporting_description')); ?>
                </div>
                
                <!-- Secondary CTA Button -->
                <?php 
                $hero_cta = get_field('hero_cta_group');
                if ($hero_cta && !empty($hero_cta['hero_secondary_button_text']) && !empty($hero_cta['hero_secondary_button_link'])): 
                ?>
                    <a href="<?php echo esc_url($hero_cta['hero_secondary_button_link']); ?>" 
                       class="inline-flex items-center gap-2 px-8 py-4 bg-[#ed1c24] text-white font-semibold rounded-full hover:bg-[#d91920] transition-all duration-300 shadow-lg shadow-[#ed1c24]/30 hover:shadow-xl hover:shadow-[#ed1c24]/40 hover:-translate-y-0.5">
                        <?php echo esc_html($hero_cta['hero_secondary_button_text']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Right: Featured Image -->
            <div class="relative group order-1 lg:order-2">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-gray-900/10">
                    <?php 
                    $secondary_image = get_field('secondary_image');
                    $featured_image = get_field('featured_image');
                    $fallback_image = 'https://bisworld.com/wp-content/uploads/2026/01/DMV-event-scaled.jpg';
                    if ($secondary_image): 
                    ?>
                        <img src="<?php echo esc_url($secondary_image); ?>" 
                             alt="<?php echo esc_attr(get_the_title()); ?>" 
                             class="w-full aspect-[4/3] object-cover transition-transform duration-700 group-hover:scale-105">
                    <?php elseif ($featured_image): ?>
                        <img src="<?php echo esc_url($featured_image); ?>" 
                             alt="<?php echo esc_attr(get_the_title()); ?>" 
                             class="w-full aspect-[4/3] object-cover transition-transform duration-700 group-hover:scale-105">
                    <?php elseif (get_the_post_thumbnail_url(get_the_ID(), 'large')): ?>
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" 
                             alt="<?php echo esc_attr(get_the_title()); ?>" 
                             class="w-full aspect-[4/3] object-cover transition-transform duration-700 group-hover:scale-105">
                    <?php else: ?>
                        <img src="<?php echo esc_url($fallback_image); ?>" 
                             alt="<?php echo esc_attr(get_the_title()); ?>" 
                             class="w-full aspect-[4/3] object-cover transition-transform duration-700 group-hover:scale-105">
                    <?php endif; ?>
                    
                    <!-- Overlay gradient -->
                    <div class="absolute inset-0 bg-gradient-to-tl from-[#ed1c24]/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                
            </div>
        </div>
    </div>
</section>


<!-- Sub-Solutions Section -->
<section class="relative py-24 lg:py-32 bg-white overflow-hidden">
    <!-- Subtle background pattern -->
    <div class="absolute inset-0 opacity-[0.02]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 lg:mb-20">
            <div class="flex items-center justify-center gap-4 mb-6">
                <div class="flex items-center gap-3 px-4 py-2 bg-[#ed1c24]/10 rounded-full border border-[#ed1c24]/20">
                    <div class="w-2 h-2 bg-[#ed1c24] rounded-full animate-pulse"></div>
                    <span class="text-[#ed1c24] text-xs font-bold uppercase tracking-[0.2em]">
                        <?php echo wp_kses_post(get_field('eyebrow_text')); ?>
                    </span>
                </div>
            </div>

            <h2 class="text-4xl lg:text-5xl font-bold leading-tight max-w-4xl mx-auto text-gray-900 mb-6">
                <?php echo esc_html(get_field('sub_solutions_section_title')); ?>
            </h2>

            <div class="text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto">
                <?php echo wp_kses_post(get_field('sub_solutions_section_description')); ?>
            </div>
        </div>

        <!-- Solutions Carousel -->
        <div class="services-carousel owl-carousel owl-theme">
            <?php
            global $post;

            $children = get_posts([
                'post_type' => 'solutions',
                'post_parent' => $post->ID,
                'numberposts' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC',
            ]);

            if ($children):
                foreach ($children as $index => $child): ?>
                    <div class="px-2 py-4">
                        <a href="<?php echo get_permalink($child->ID); ?>" class="group block h-full">
                            <div class="relative bg-gray-900 rounded-2xl overflow-hidden h-full flex flex-col transition-all duration-500 hover:shadow-2xl hover:shadow-[#ed1c24]/20 hover:-translate-y-2 border border-transparent hover:border-[#ed1c24]/30 min-h-[320px]">
                                <!-- Accent top border -->
                                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#ed1c24] via-[#ed1c24] to-transparent transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                                
                                <!-- Animated corner accents -->
                                <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-tl-2xl"></div>
                                <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-br-2xl"></div>
                                
                                <!-- Card number -->
                                <div class="absolute top-6 right-6 w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                                    <span class="text-white/60 text-sm font-bold"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                                </div>
                                
                                <div class="p-8 lg:p-10 flex flex-col h-full">
                                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-4 pr-12 group-hover:text-[#ed1c24] transition-colors duration-300">
                                        <?php echo esc_html(get_the_title($child->ID)); ?>
                                    </h3>

                                    <div class="text-gray-400 text-base leading-relaxed flex-grow mb-8">
                                        <?php echo wp_kses_post(get_field('tagline', $child->ID)); ?>
                                    </div>

                                    <div class="flex items-center gap-2 text-white group-hover:text-[#ed1c24] transition-colors duration-300">
                                        <span class="text-sm font-semibold uppercase tracking-wide">Explore</span>
                                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach;

            elseif (have_rows('non_pages_solutions')):
                $index = 0;
                while (have_rows('non_pages_solutions')):
                    the_row();
                    $title = get_sub_field('title');
                    $description = get_sub_field('description'); ?>
                    <div class="px-2 py-4">
                        <div class="group relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl overflow-hidden h-full flex flex-col border border-gray-200 hover:border-[#ed1c24]/40 transition-all duration-500 hover:shadow-xl hover:shadow-[#ed1c24]/10 hover:-translate-y-1 min-h-[320px]">
                            <!-- Animated corner accents -->
                            <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-tl-2xl"></div>
                            <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-br-2xl"></div>
                            
                            <!-- Bottom accent line -->
                            <div class="absolute bottom-0 left-8 right-8 h-0.5 bg-gradient-to-r from-[#ed1c24] to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                            
                            <!-- Card number -->
                            <div class="absolute top-6 right-6 w-10 h-10 rounded-full bg-[#ed1c24]/10 flex items-center justify-center group-hover:bg-[#ed1c24]/20 transition-colors duration-300">
                                <span class="text-[#ed1c24] text-sm font-bold"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                            </div>
                            
                            <div class="p-8 lg:p-10 flex flex-col h-full">
                                <h3 class="text-xl font-bold text-gray-900 mb-4 pr-12">
                                    <?php echo esc_html($title); ?>
                                </h3>
                                <div class="text-gray-600 text-base leading-relaxed flex-grow">
                                    <?php echo wp_kses_post($description); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $index++; endwhile;

            else: ?>
                <div class="text-center py-12">
                    <p class="text-gray-500">No solutions available at this time.</p>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
</section>


<!-- Why Choose Us Section -->
<section class="relative py-24 lg:py-32 bg-gray-900 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5" aria-hidden="true"
        style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/patterns-01-scaled.webp'); background-repeat: repeat; background-size: cover;">
    </div>
    
    <!-- Decorative gradient orbs -->
    <div class="absolute top-1/4 -right-32 w-96 h-96 bg-[#ed1c24]/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#ed1c24]/5 rounded-full blur-3xl"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 mb-16 lg:mb-20">
            <div class="max-w-3xl">
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center gap-3 px-4 py-2 bg-[#ed1c24]/10 rounded-full border border-[#ed1c24]/20">
                        <div class="w-2 h-2 bg-[#ed1c24] rounded-full animate-pulse"></div>
                        <span class="text-[#ed1c24] text-xs font-bold uppercase tracking-[0.2em]">
                            <?php echo esc_html(get_field('why_piedmont_global_eyebrow')); ?>
                        </span>
                    </div>
                </div>

                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                    <?php echo esc_html(get_field('why_piedmont_global_section_title')); ?>
                </h2>

                <div class="text-lg text-gray-400 leading-relaxed prose prose-invert prose-p:text-gray-400 prose-strong:text-gray-300 prose-a:text-[#ed1c24] prose-a:no-underline hover:prose-a:underline max-w-none">
                    <?php echo wp_kses_post(get_field('why_piedmont_global_description')); ?>
                </div>
            </div>
            
            <?php 
            $why_cta = get_field('why_cta_group');
            if ($why_cta && !empty($why_cta['why_button_text']) && !empty($why_cta['why_button_link'])): 
            ?>
                <div class="flex-shrink-0">
                    <a href="<?php echo esc_url($why_cta['why_button_link']); ?>" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-[#ed1c24] text-white font-semibold rounded-full hover:bg-[#d91920] transition-all duration-300 shadow-lg shadow-[#ed1c24]/30 hover:shadow-xl hover:shadow-[#ed1c24]/40 hover:-translate-y-0.5">
                        <?php echo esc_html($why_cta['why_button_text']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Cards Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
            <?php
            $why_piedmont_cards = get_field('why_piedmont_global_cards');
            if ($why_piedmont_cards && is_array($why_piedmont_cards)) {
                foreach ($why_piedmont_cards as $index => $card):
                    ?>
                    <div class="group relative bg-white/5 backdrop-blur-sm rounded-2xl p-12 border border-white/10 hover:border-[#ed1c24]/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-[#ed1c24]/10">
                      

                        <div class="pt-6">
                            <h3 class="font-bold text-xl text-white mb-4 group-hover:text-[#ed1c24] transition-colors duration-300">
                                <?php echo esc_html($card['card_title']); ?>
                            </h3>

                            <div class="text-gray-400 text-base leading-relaxed group-hover:text-gray-300 transition-colors duration-300">
                                <?php echo wp_kses_post($card['card_description']); ?>
                            </div>
                        </div>
                        
                        <!-- Hover accent line -->
                        <div class="absolute bottom-0 left-8 right-8 h-0.5 bg-gradient-to-r from-[#ed1c24] to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    </div>
                <?php endforeach;
            } ?>
        </div>
    </div>
</section>

<!-- Industries Section -->
<section class="relative py-24 lg:py-32 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 mb-16">
            <div class="max-w-3xl">
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center gap-3 px-4 py-2 bg-[#ed1c24]/10 rounded-full border border-[#ed1c24]/20">
                        <div class="w-2 h-2 bg-[#ed1c24] rounded-full animate-pulse"></div>
                        <span class="text-[#ed1c24] text-xs font-bold uppercase tracking-[0.2em]"><?php echo esc_html(get_field('industries_eyebrow')); ?></span>
                    </div>
                </div>

                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    <?php echo esc_html(get_field('industries_title')); ?>
                </h2>
                
                <?php if (get_field('industries_description')): ?>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        <?php echo esc_html(get_field('industries_description')); ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <?php 
            $industries_cta = get_field('industries_cta_group');
            if ($industries_cta && !empty($industries_cta['industries_button_text']) && !empty($industries_cta['industries_button_link'])): 
            ?>
                <div class="flex-shrink-0">
                    <a href="<?php echo esc_url($industries_cta['industries_button_link']); ?>" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-[#ed1c24] text-white font-semibold rounded-full hover:bg-[#d91920] transition-all duration-300 shadow-lg shadow-[#ed1c24]/30 hover:shadow-xl hover:shadow-[#ed1c24]/40 hover:-translate-y-0.5">
                        <?php echo esc_html($industries_cta['industries_button_text']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Industries Grid -->
        <div class="grid gap-4 sm:grid-cols-2 lg:gap-6">
            <?php
            $industries_section = get_field('industries_section');
            if ($industries_section && is_array($industries_section)) {
                foreach ($industries_section as $industry):
                    ?>
                    <a href="<?php echo esc_url(get_permalink($industry->ID)); ?>"
                        class="group relative block bg-white rounded-xl p-6 lg:p-8 border border-gray-200 hover:border-[#ed1c24]/40 transition-all duration-500 hover:shadow-xl hover:shadow-[#ed1c24]/10 hover:-translate-y-1 overflow-hidden">
                        
                        <!-- Animated corner accents -->
                        <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-tl-xl"></div>
                        <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-br-xl"></div>
                        
                        <!-- Accent line top -->
                        <div class="absolute top-0 left-6 right-6 h-0.5 bg-gradient-to-r from-[#ed1c24] to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left rounded-full"></div>
                        
                        <!-- Accent line bottom -->
                        <div class="absolute bottom-0 left-6 right-6 h-0.5 bg-gradient-to-l from-[#ed1c24] to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-right rounded-full"></div>
                        
                        <div class="flex items-center justify-between gap-6">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg sm:text-xl text-gray-900 group-hover:text-[#ed1c24] transition-colors duration-300 mb-2">
                                    <?php echo esc_html(get_the_title($industry)); ?>
                                </h3>
                                <?php 
                                $description = get_field('description', $industry->ID);
                                if ($description): 
                                    $truncated = strlen($description) > 200 ? substr($description, 0, 200) . '...' : $description;
                                ?>
                                    <p class="text-gray-500 text-base leading-relaxed line-clamp-2">
                                        <?php echo wp_kses_post($truncated); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Arrow icon -->
                            <div class="w-12 h-12 rounded-full bg-gray-100 group-hover:bg-[#ed1c24] flex items-center justify-center transition-all duration-300 flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors duration-300 transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                <?php endforeach;
            } ?>
        </div>

        <!-- Non-paged Industries -->
        <?php
        $cards = get_field('non_paged_industries_cards');
        if ($cards && is_array($cards) && count($cards) > 0): ?>
            <div class="grid gap-4 sm:grid-cols-2 lg:gap-6 mt-6">
                <?php foreach ($cards as $card): ?>
                    <div class="group relative bg-gray-50 rounded-xl p-6 lg:p-8 border border-gray-200 hover:border-[#ed1c24]/30 transition-all duration-500 hover:shadow-lg overflow-hidden">
                        <!-- Animated corner accents -->
                        <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-tl-xl"></div>
                        <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-br-xl"></div>
                        
                        <!-- Bottom accent line -->
                        <div class="absolute bottom-0 left-6 right-6 h-0.5 bg-gradient-to-r from-[#ed1c24] via-[#ed1c24]/50 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                        <div class="flex-1">
                            <h3 class="font-bold text-lg sm:text-xl text-gray-900 mb-2">
                                <?php echo esc_html($card['title']); ?>
                            </h3>
                            <?php if (!empty($card['description'])): ?>
                                <p class="text-gray-500 text-base leading-relaxed">
                                    <?php echo wp_kses_post($card['description']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>


<!-- Outcomes Section -->
<?php if (have_rows('outcomes')): ?>
<section class="relative pb-16 bg-white overflow-hidden">
    <!-- Subtle decorative elements -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-[#ed1c24]/3 to-transparent"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-gray-100 rounded-full blur-[120px]"></div>
    
    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 lg:mb-16">
            <div class="flex items-center justify-center gap-4 mb-6">
                <div class="flex items-center gap-3 px-4 py-2 bg-[#ed1c24]/10 rounded-full border border-[#ed1c24]/20">
                    <div class="w-2 h-2 bg-[#ed1c24] rounded-full animate-pulse"></div>
                    <span class="text-[#ed1c24] text-xs font-bold uppercase tracking-[0.2em]"><?php echo esc_html(get_field('outcomes_eyebrow')); ?></span>
                </div>
            </div>
            
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                <?php echo esc_html(get_field('outcomes_title')); ?>
            </h2>
            
            <?php if (get_field('outcomes_description')): ?>
                <p class="text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto">
                    <?php echo esc_html(get_field('outcomes_description')); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Bento Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 auto-rows-[220px]">
            <?php
            $bento_styles = [
                ['bg' => 'bg-[#ed1c24]', 'text' => 'text-white', 'span' => ''],
                ['bg' => 'bg-gray-900', 'text' => 'text-white', 'span' => 'sm:col-span-2'],
                ['bg' => 'bg-gray-100', 'text' => 'text-gray-900', 'span' => 'lg:row-span-2'],
                ['bg' => 'image', 'text' => '', 'span' => 'lg:row-span-2'],
                ['bg' => 'bg-gray-50 border border-gray-200', 'text' => 'text-gray-900', 'span' => ''],
                ['bg' => 'bg-[#ed1c24]/10', 'text' => 'text-gray-900', 'span' => ''],
            ];

            $i = 0;
            while (have_rows('outcomes')):
                the_row();
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $style = $bento_styles[$i % count($bento_styles)];
                ?>

                <?php if ($style['bg'] === 'image'): ?>
                    <div class="relative overflow-hidden rounded-2xl group <?php echo esc_attr($style['span']); ?>">
                        <img src="<?php echo esc_url(get_field('featured_image')); ?>"
                            alt="<?php echo esc_attr(get_the_title()); ?>"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    </div>
                <?php else: ?>
                    <div class="group relative <?php echo esc_attr($style['bg']); ?> <?php echo esc_attr($style['text']); ?> rounded-2xl p-6 lg:p-8 flex flex-col justify-between transition-all duration-500 hover:shadow-xl hover:-translate-y-1 overflow-hidden <?php echo esc_attr($style['span']); ?>">
                        <!-- Animated corner accents -->
                        <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-current opacity-0 group-hover:opacity-40 transition-all duration-500 rounded-tl-2xl"></div>
                        <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-current opacity-0 group-hover:opacity-40 transition-all duration-500 rounded-br-2xl"></div>
                        
                        <!-- Bottom accent line -->
                        <div class="absolute bottom-0 left-6 right-6 h-0.5 bg-current opacity-0 group-hover:opacity-30 transform scale-x-0 group-hover:scale-x-100 transition-all duration-500 origin-left"></div>
                        <h3 class="font-bold text-xl lg:text-2xl leading-tight"><?php echo wp_kses_post($title); ?></h3>
                        <div class="text-lg font-light opacity-80 mt-4"><?php echo wp_kses_post($description); ?></div>
                    </div>
                <?php endif; ?>

            <?php $i++; endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
$competitor_image = get_field('competitor_image');
if ($competitor_image):
?>
<!-- Competitor Landscape Section -->
<section x-data="{ open: false }" class="relative py-24 lg:py-32 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <?php if (get_field('competitor_eyebrow')): ?>
                <div class="flex items-center justify-center gap-4 mb-6">
                    <div class="flex items-center gap-3 px-4 py-2 bg-[#ed1c24]/10 rounded-full border border-[#ed1c24]/20">
                        <div class="w-2 h-2 bg-[#ed1c24] rounded-full animate-pulse"></div>
                        <span class="text-[#ed1c24] text-xs font-bold uppercase tracking-[0.2em]"><?php echo esc_html(get_field('competitor_eyebrow')); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (get_field('competitor_title')): ?>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_field('competitor_title')); ?>
                </h2>
            <?php endif; ?>
            
            <?php if (get_field('competitor_description')): ?>
                <p class="text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto">
                    <?php echo esc_html(get_field('competitor_description')); ?>
                </p>
            <?php endif; ?>
            
            <?php 
            $competitor_cta = get_field('competitor_cta_group');
            if ($competitor_cta && !empty($competitor_cta['competitor_button_text']) && !empty($competitor_cta['competitor_button_link'])): 
            ?>
                <div class="mt-6">
                    <a href="<?php echo esc_url($competitor_cta['competitor_button_link']); ?>" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-[#ed1c24] text-white font-semibold rounded-full hover:bg-[#d91920] transition-all duration-300 shadow-lg shadow-[#ed1c24]/30 hover:shadow-xl hover:shadow-[#ed1c24]/40 hover:-translate-y-0.5">
                        <?php echo esc_html($competitor_cta['competitor_button_text']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Infographic Card -->
        <div class="group relative cursor-zoom-in overflow-hidden rounded-2xl border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1"
            @click="open = true">
            <img src="<?php echo esc_url($competitor_image['url']); ?>" alt="<?php echo esc_attr($competitor_image['alt'] ?: 'Competitor Landscape Infographic'); ?>"
                class="w-full h-auto object-contain transition-transform duration-500 group-hover:scale-[1.02]" />

            <!-- Hover Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                <div class="flex items-center gap-3 px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full border border-white/30">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                    </svg>
                    <span class="text-white text-sm font-semibold tracking-wide">Click to Expand</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen Modal -->
    <div x-show="open" x-transition.opacity x-cloak
        class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-6"
        @keydown.escape.window="open = false">
        
        <!-- Close Button -->
        <button @click="open = false" 
            class="absolute top-6 right-6 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-colors duration-200"
            aria-label="Close image">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <img src="<?php echo esc_url($competitor_image['url']); ?>" alt="<?php echo esc_attr($competitor_image['alt'] ?: 'Competitor Landscape Infographic'); ?>"
            class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" @click.stop />
    </div>
</section>
<?php endif; ?>

<?php
$related_resources = get_field('related_resources');
if ($related_resources && is_array($related_resources) && count($related_resources) > 0):
?>
<!-- Related Resources Section -->
<section class="relative pb-16  bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-16">
            <div class="max-w-3xl">
                <?php if (get_field('resources_eyebrow')): ?>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center gap-3 px-4 py-2 bg-[#ed1c24]/10 rounded-full border border-[#ed1c24]/20">
                            <div class="w-2 h-2 bg-[#ed1c24] rounded-full animate-pulse"></div>
                            <span class="text-[#ed1c24] text-xs font-bold uppercase tracking-[0.2em]"><?php echo esc_html(get_field('resources_eyebrow')); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (get_field('resources_title')): ?>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        <?php echo esc_html(get_field('resources_title')); ?>
                    </h2>
                <?php endif; ?>
                
                <?php if (get_field('resources_description')): ?>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        <?php echo esc_html(get_field('resources_description')); ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <?php 
            $resources_cta = get_field('resources_cta_group');
            if ($resources_cta && !empty($resources_cta['resources_button_text']) && !empty($resources_cta['resources_button_link'])): 
            ?>
                <div class="flex-shrink-0">
                    <a href="<?php echo esc_url($resources_cta['resources_button_link']); ?>" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-[#ed1c24] text-white font-semibold rounded-full hover:bg-[#d91920] transition-all duration-300 shadow-lg shadow-[#ed1c24]/30 hover:shadow-xl hover:shadow-[#ed1c24]/40 hover:-translate-y-0.5">
                        <?php echo esc_html($resources_cta['resources_button_text']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Resources Carousel -->
        <div class="resources-carousel owl-carousel owl-theme">
            <?php 
            global $post;
            $original_post = $post;
            foreach ($related_resources as $resource): 
                $post = $resource;
                setup_postdata($post);
                $description = get_field('description', $resource->ID);
                set_query_var('description', $description);
            ?>
                <div class="item">
                    <?php get_template_part('components/cards/resource-card'); ?>
                </div>
            <?php 
            endforeach;
            $post = $original_post;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (have_rows('faqs')): ?>
<!-- FAQ Section -->
<section class="relative py-24 lg:py-32 bg-gradient-to-b from-gray-50 to-white overflow-hidden">
    <div class="max-w-5xl mx-auto px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <?php if (get_field('faq_eyebrow')): ?>
                <div class="flex items-center justify-center gap-4 mb-6">
                    <div class="flex items-center gap-3 px-4 py-2 bg-[#ed1c24]/10 rounded-full border border-[#ed1c24]/20">
                        <div class="w-2 h-2 bg-[#ed1c24] rounded-full animate-pulse"></div>
                        <span class="text-[#ed1c24] text-xs font-bold uppercase tracking-[0.2em]"><?php echo esc_html(get_field('faq_eyebrow')); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (get_field('faq_title')): ?>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    <?php echo esc_html(get_field('faq_title')); ?>
                </h2>
            <?php endif; ?>
            
            <?php if (get_field('faq_description')): ?>
                <p class="text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto">
                    <?php echo esc_html(get_field('faq_description')); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4" x-data="{ openFaq: null }">
            <?php 
            $faq_index = 0;
            while (have_rows('faqs')): the_row();
                $question = get_sub_field('question');
                $answer = get_sub_field('answer');
            ?>
                <div class="group bg-white rounded-xl border border-gray-200 hover:border-[#ed1c24]/30 transition-all duration-300 overflow-hidden"
                     :class="{ 'border-[#ed1c24]/50 shadow-lg shadow-[#ed1c24]/5': openFaq === <?php echo $faq_index; ?> }">
                    <button @click="openFaq = openFaq === <?php echo $faq_index; ?> ? null : <?php echo $faq_index; ?>"
                            class="w-full flex items-center justify-between p-6 text-left focus:outline-none focus:ring-2 focus:ring-[#ed1c24]/20 focus:ring-inset rounded-xl">
                        <span class="font-semibold text-gray-900 pr-4 group-hover:text-[#ed1c24] transition-colors duration-300"
                              :class="{ 'text-[#ed1c24]': openFaq === <?php echo $faq_index; ?> }">
                            <?php echo esc_html($question); ?>
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100 group-hover:bg-[#ed1c24]/10 flex items-center justify-center transition-all duration-300"
                             :class="{ 'bg-[#ed1c24] rotate-180': openFaq === <?php echo $faq_index; ?> }">
                            <svg class="w-4 h-4 text-gray-600 transition-colors duration-300" 
                                 :class="{ 'text-white': openFaq === <?php echo $faq_index; ?> }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openFaq === <?php echo $faq_index; ?>"
                         x-collapse
                         x-cloak>
                        <div class="px-6 pb-6 prose prose-gray prose-p:text-gray-600 prose-a:text-[#ed1c24] prose-a:no-underline hover:prose-a:underline max-w-none">
                            <?php echo wp_kses_post($answer); ?>
                        </div>
                    </div>
                </div>
            <?php $faq_index++; endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
get_template_part('components/sections/cta'); 
get_template_part('components/sections/logo-carousel');
get_footer();
?>