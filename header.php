<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BIS
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>document.documentElement.classList.remove('no-js');document.documentElement.classList.add('js');</script>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        /* WCAG 4.1.1 / Non-Interference — guarantee perceivability when JS is blocked or fails */
        .no-js [data-aos]{opacity:1 !important;transform:none !important;transition:none !important;}
        main:focus,main:focus-visible{outline:none;}
        /* WCAG 2.4.1 Bypass Blocks — sticky header would otherwise hide the skip-link
           target and other in-page anchors. Push the scroll offset down past the bar. */
        :root{scroll-padding-top:6rem;}
        #primary,:target{scroll-margin-top:6rem;}
        /* WCAG 2.3.3 Animation from Interactions / 2.2.2 Pause, Stop, Hide */
        @media (prefers-reduced-motion: reduce){
            html{scroll-behavior:auto;}
            *,*::before,*::after{animation-duration:.001ms !important;animation-iteration-count:1 !important;transition-duration:.001ms !important;scroll-behavior:auto !important;}
            [data-aos]{opacity:1 !important;transform:none !important;transition:none !important;}
        }
    </style>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'bis'); ?></a>

        <!-- Sticky Navigation -->
        <header id="masthead"
            class=" fixed px-4 sm:px-6 lg:px-10 top-0 md:top-0 lg:top-0 left-0 right-0 z-50 bg-red-600 shadow-lg">
            <div class="relative">


                <!-- Pattern Background -->
                <div class="absolute inset-0 opacity-10 z-0" aria-hidden="true"
                    style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/patterns-01-scaled.webp'); background-repeat: repeat; background-size: cover; background-position: center;">
                </div>

                <?php
                // Define base menu arguments (shared between desktop and mobile)
                $menu_args = array(
                    'menu' => 2,
                    'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                    'fallback_cb' => false,
                    'container' => false,
                );
                ?>
                
                <div class="max-w-7xl mx-auto relative z-10 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center flex-shrink-0 h-8 sm:h-10">
                            <?php
                            if (has_custom_logo()) {
                                add_filter('get_custom_logo', function ($html) {
                                    $html = str_replace(
                                        'class="custom-logo"',
                                        'class="custom-logo h-full w-auto max-w-[80px] lg:max-w-[100px] object-contain"',
                                        $html
                                    );
                                    if (preg_match('/<img\b[^>]*\salt="(?P<alt>[^"]*)"/i', $html, $m)) {
                                        if ($m['alt'] === '') {
                                            $alt_attr = ' alt="' . esc_attr(get_bloginfo('name')) . '"';
                                            $html = preg_replace('/<img\b([^>]*)\salt="[^"]*"/i', '<img$1' . $alt_attr, $html, 1);
                                        }
                                    } else {
                                        $alt_attr = ' alt="' . esc_attr(get_bloginfo('name')) . '"';
                                        $html = preg_replace('/<img\b/i', '<img' . $alt_attr, $html, 1);
                                    }
                                    return $html;
                                });
                                the_custom_logo();
                            } else {
                                echo '<a href="' . esc_url(home_url('/')) . '" class="text-white text-xl sm:text-2xl font-display font-bold flex items-center h-full" rel="home">' . esc_html(get_bloginfo('name')) . '</a>';
                            }
                            ?>
                        </div>

                        <!-- Desktop Navigation Menu with Dropdowns -->
                        <nav id="site-navigation" class="hidden lg:flex items-center space-x-1 xl:space-x-2"
                            aria-label="<?php esc_attr_e('Primary', 'bis'); ?>">
                            
                            <!-- About Dropdown -->
                            <div x-data="{ open: false, close() { this.open = false; this.$refs.btn && this.$refs.btn.focus(); } }"
                                 @click.outside="open = false"
                                 @focusout="if (!$event.relatedTarget || !$el.contains($event.relatedTarget)) open = false"
                                 @keydown.escape.prevent="close()"
                                 class="relative">
                                <button @click="open = !open"
                                        x-ref="btn"
                                        type="button"
                                        class="group flex items-center gap-1.5 text-white font-semibold text-base px-4 py-2 rounded-full hover:bg-white/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50"
                                        :aria-expanded="open.toString()"
                                        aria-controls="about-dropdown"
                                        aria-haspopup="true">
                                    <?php esc_html_e('About', 'bis'); ?>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300 opacity-70 group-hover:opacity-100" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                     id="about-dropdown"
                                     class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-80 bg-white rounded-[4px] shadow-xl shadow-black/10 border border-gray-200 z-[60]">
                                    
                                    <!-- Dropdown Items -->
                                    <ul class="py-2 list-none m-0 p-0">
                                        <?php
                                        $about_menu = wp_get_nav_menu_items(5);
                                        if ($about_menu) {
                                            foreach ($about_menu as $menu_item) {
                                                echo '<li class="m-0 p-0"><a href="' . esc_url($menu_item->url) . '" class="group/item flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-inset">
                                                    <span class="flex-shrink-0 w-0.5 h-4 bg-[#ed3437] origin-top scale-y-0 group-hover/item:scale-y-100 transition-transform duration-300 ease-out" aria-hidden="true"></span>
                                                    <span class="text-sm font-medium group-hover/item:text-gray-900 transition-colors">' . esc_html($menu_item->title) . '</span>
                                                </a></li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                    
                                    <!-- Dropdown Footer -->
                                    <div class="border-t border-gray-100 bg-gray-50/50 px-5 py-3">
                                        <a href="<?php echo esc_url(home_url('/about')); ?>" class="group/link flex items-center justify-between text-[#ed3437] hover:text-[#c42a2d] transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-inset rounded">
                                            <span class="text-sm font-semibold"><?php esc_html_e('Learn More About Us', 'bis'); ?></span>
                                            <svg class="w-4 h-4 transition-transform duration-300 group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Services Dropdown -->
                            <div x-data="{ open: false, close() { this.open = false; this.$refs.btn && this.$refs.btn.focus(); } }"
                                 @click.outside="open = false"
                                 @focusout="if (!$event.relatedTarget || !$el.contains($event.relatedTarget)) open = false"
                                 @keydown.escape.prevent="close()"
                                 class="relative">
                                <button @click="open = !open"
                                        x-ref="btn"
                                        type="button"
                                        class="group flex items-center gap-1.5 text-white font-semibold text-base px-4 py-2 rounded-full hover:bg-white/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50"
                                        :aria-expanded="open.toString()"
                                        aria-controls="services-dropdown"
                                        aria-haspopup="true">
                                    <?php esc_html_e('Services', 'bis'); ?>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300 opacity-70 group-hover:opacity-100" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                     id="services-dropdown"
                                     class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-80 bg-white rounded-[4px] shadow-xl shadow-black/10 border border-gray-200 z-[60]">
                                    
                                    <!-- Dropdown Items -->
                                    <ul class="py-2 max-h-[360px] overflow-y-auto list-none m-0 p-0">
                                        <?php
                                        $services = new WP_Query([
                                            'post_type'      => 'service',
                                            'posts_per_page' => -1,
                                            'post_status'    => 'publish',
                                            'orderby'        => 'title',
                                            'order'          => 'ASC',
                                        ]);
                                        if ($services->have_posts()) {
                                            while ($services->have_posts()) {
                                                $services->the_post();
                                                echo '<li class="m-0 p-0"><a href="' . esc_url(get_permalink()) . '" class="group/item flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-inset">
                                                    <span class="flex-shrink-0 w-0.5 h-4 bg-[#ed3437] origin-top scale-y-0 group-hover/item:scale-y-100 transition-transform duration-300 ease-out" aria-hidden="true"></span>
                                                    <span class="text-sm font-medium group-hover/item:text-gray-900 transition-colors">' . esc_html(get_the_title()) . '</span>
                                                </a></li>';
                                            }
                                            wp_reset_postdata();
                                        }
                                        ?>
                                    </ul>
                                    
                                    <!-- Dropdown Footer -->
                                    <div class="border-t border-gray-100 bg-gray-50/50 px-5 py-3">
                                        <a href="<?php echo esc_url(home_url('/services')); ?>" class="group/link flex items-center justify-between text-[#ed3437] hover:text-[#c42a2d] transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-inset rounded">
                                            <span class="text-sm font-semibold"><?php esc_html_e('Explore All Services', 'bis'); ?></span>
                                            <svg class="w-4 h-4 transition-transform duration-300 group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Industries Dropdown -->
                            <div x-data="{ open: false, close() { this.open = false; this.$refs.btn && this.$refs.btn.focus(); } }"
                                 @click.outside="open = false"
                                 @focusout="if (!$event.relatedTarget || !$el.contains($event.relatedTarget)) open = false"
                                 @keydown.escape.prevent="close()"
                                 class="relative">
                                <button @click="open = !open"
                                        x-ref="btn"
                                        type="button"
                                        class="group flex items-center gap-1.5 text-white font-semibold text-base px-4 py-2 rounded-full hover:bg-white/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50"
                                        :aria-expanded="open.toString()"
                                        aria-controls="industries-dropdown"
                                        aria-haspopup="true">
                                    <?php esc_html_e('Industries', 'bis'); ?>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300 opacity-70 group-hover:opacity-100" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                     id="industries-dropdown"
                                     class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-80 bg-white rounded-[4px] shadow-xl shadow-black/10 border border-gray-200 z-[60]">
                                    
                                    <!-- Dropdown Items -->
                                    <ul class="py-2 max-h-[360px] overflow-y-auto list-none m-0 p-0">
                                        <?php
                                        $industries = new WP_Query([
                                            'post_type'      => 'industry',
                                            'posts_per_page' => -1,
                                            'post_status'    => 'publish',
                                            'orderby'        => 'title',
                                            'order'          => 'ASC',
                                        ]);
                                        if ($industries->have_posts()) {
                                            while ($industries->have_posts()) {
                                                $industries->the_post();
                                                echo '<li class="m-0 p-0"><a href="' . esc_url(get_permalink()) . '" class="group/item flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-inset">
                                                    <span class="flex-shrink-0 w-0.5 h-4 bg-[#ed3437] origin-top scale-y-0 group-hover/item:scale-y-100 transition-transform duration-300 ease-out" aria-hidden="true"></span>
                                                    <span class="text-sm font-medium group-hover/item:text-gray-900 transition-colors">' . esc_html(get_the_title()) . '</span>
                                                </a></li>';
                                            }
                                            wp_reset_postdata();
                                        }
                                        ?>
                                    </ul>
                                    
                                    <!-- Dropdown Footer -->
                                    <div class="border-t border-gray-100 bg-gray-50/50 px-5 py-3">
                                        <a href="<?php echo esc_url(home_url('/industries')); ?>" class="group/link flex items-center justify-between text-[#ed3437] hover:text-[#c42a2d] transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-inset rounded">
                                            <span class="text-sm font-semibold"><?php esc_html_e('Explore All Industries', 'bis'); ?></span>
                                            <svg class="w-4 h-4 transition-transform duration-300 group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Resources Dropdown -->
                            <div x-data="{ open: false, close() { this.open = false; this.$refs.btn && this.$refs.btn.focus(); } }"
                                 @click.outside="open = false"
                                 @focusout="if (!$event.relatedTarget || !$el.contains($event.relatedTarget)) open = false"
                                 @keydown.escape.prevent="close()"
                                 class="relative">
                                <button @click="open = !open"
                                        x-ref="btn"
                                        type="button"
                                        class="group flex items-center gap-1.5 text-white font-semibold text-base px-4 py-2 rounded-full hover:bg-white/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50"
                                        :aria-expanded="open.toString()"
                                        aria-controls="resources-dropdown"
                                        aria-haspopup="true">
                                    <?php esc_html_e('Resources', 'bis'); ?>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300 opacity-70 group-hover:opacity-100" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                     id="resources-dropdown"
                                     class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-80 bg-white rounded-[4px] shadow-xl shadow-black/10 border border-gray-200 z-[60]">
                                    
                                    <!-- Dropdown Items -->
                                    <ul class="py-2 list-none m-0 p-0">
                                        <?php
                                        $resource_menu = wp_get_nav_menu_items(4);
                                        if ($resource_menu) {
                                            foreach ($resource_menu as $menu_item) {
                                                echo '<li class="m-0 p-0"><a href="' . esc_url($menu_item->url) . '" class="group/item flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-inset">
                                                    <span class="flex-shrink-0 w-0.5 h-4 bg-[#ed3437] origin-top scale-y-0 group-hover/item:scale-y-100 transition-transform duration-300 ease-out" aria-hidden="true"></span>
                                                    <span class="text-sm font-medium group-hover/item:text-gray-900 transition-colors">' . esc_html($menu_item->title) . '</span>
                                                </a></li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                    
                                    <!-- Dropdown Footer -->
                                    <div class="border-t border-gray-100 bg-gray-50/50 px-5 py-3">
                                        <a href="<?php echo esc_url(home_url('/resources')); ?>" class="group/link flex items-center justify-between text-[#ed3437] hover:text-[#c42a2d] transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#ed3437] focus:ring-inset rounded">
                                            <span class="text-sm font-semibold"><?php esc_html_e('Explore All Resources', 'bis'); ?></span>
                                            <svg class="w-4 h-4 transition-transform duration-300 group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </nav>

                        <!-- Desktop Let's Connect Button -->
                        <a href="<?php echo esc_url(home_url('/contact')); ?>"
                            class="hidden lg:flex bg-transparent text-white border-2 border-white rounded-full px-4 xl:px-6 py-2 font-medium hover:bg-white hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-red-600 transition-colors items-center space-x-2">
                            <span><?php esc_html_e( "Let's Connect", 'bis' ); ?></span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z">
                                </path>
                                <path
                                    d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z">
                                </path>
                            </svg>
                        </a>

                        <!-- Mobile Menu Toggle with Alpine.js -->
                        <?php
                        // Translatable label map for the mobile submenu heading.
                        // Keys MUST match the values passed to openSubmenu() below; the
                        // labels MUST match the corresponding trigger button text so the
                        // dialog's accessible name agrees with what the user just pressed.
                        // NOTE: must be escaped for an HTML attribute (esc_attr) because
                        // the JSON contains double quotes which would otherwise terminate
                        // the surrounding x-data="..." attribute and break the markup.
                        $mobile_submenu_labels = wp_json_encode( array(
                            'about'      => __( 'Who We Are', 'bis' ),
                            'services'   => __( 'Services', 'bis' ),
                            'industries' => __( 'Industries', 'bis' ),
                            'resources'  => __( 'Resources', 'bis' ),
                        ) );
                        ?>
                        <div x-data="{
                            open: false,
                            submenu: null,
                            isTransitioning: false,
                            previousFocus: null,
                            submenuLabels: <?php echo esc_attr( $mobile_submenu_labels ); ?>,
                            toggleMenu() {
                                if (this.open) {
                                    this.closeMenu();
                                    return;
                                }
                                this.previousFocus = document.activeElement;
                                this.open = true;
                                document.body.style.overflow = 'hidden';
                                this.$nextTick(() => {
                                    const dialog = document.getElementById('mobile-menu');
                                    if (!dialog) return;
                                    const focusable = dialog.querySelector('button:not([disabled]), a[href]');
                                    if (focusable) focusable.focus();
                                });
                            },
                            openSubmenu(menu) {
                                if (this.isTransitioning) return;
                                this.isTransitioning = true;
                                this.submenu = menu;
                                setTimeout(() => {
                                    this.isTransitioning = false;
                                }, 300);
                            },
                            closeSubmenu() {
                                if (this.isTransitioning) return;
                                this.isTransitioning = true;
                                this.submenu = null;
                                setTimeout(() => {
                                    this.isTransitioning = false;
                                }, 200);
                            },
                            closeMenu() {
                                this.open = false;
                                this.submenu = null;
                                this.isTransitioning = false;
                                document.body.style.overflow = '';
                                if (this.previousFocus && typeof this.previousFocus.focus === 'function') {
                                    const restore = this.previousFocus;
                                    this.previousFocus = null;
                                    this.$nextTick(() => restore.focus());
                                }
                            },
                            trapFocus(e) {
                                if (!this.open || e.key !== 'Tab') return;
                                const dialog = document.getElementById('mobile-menu');
                                if (!dialog) return;
                                const nodes = dialog.querySelectorAll(
                                    'button:not([disabled]), a[href], [tabindex]:not([tabindex=&quot;-1&quot;])'
                                );
                                const visible = Array.from(nodes).filter(el => el.offsetParent !== null);
                                if (!visible.length) return;
                                const first = visible[0];
                                const last = visible[visible.length - 1];
                                if (e.shiftKey && document.activeElement === first) {
                                    e.preventDefault();
                                    last.focus();
                                } else if (!e.shiftKey && document.activeElement === last) {
                                    e.preventDefault();
                                    first.focus();
                                }
                            }
                        }"
                        @keydown.escape.window="if (open) closeMenu()"
                        @keydown.window="trapFocus($event)"
                        class="lg:hidden"
                        x-cloak>
                            
                            <button @click="toggleMenu()" 
                                    type="button"
                                    :aria-expanded="open"
                                    aria-label="<?php esc_attr_e('Toggle menu', 'bis'); ?>"
                                    aria-controls="mobile-menu" 
                                    class="text-white p-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-200">
                                <svg class="h-6 w-6 text-white transition-all duration-200"
                                     :class="{ 'opacity-60 rotate-90': open }"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     aria-hidden="true"
                                     focusable="false">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h12" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 18h8" />
                                </svg>
                            </button>

                            <!-- Overlay -->
                            <div x-show="open" 
                                 x-cloak 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0" 
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-300" 
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0" 
                                 class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"
                                 @click="closeMenu()" 
                                 aria-hidden="true"></div>

                            <!-- Mobile Menu Bottom Sheet -->
                            <div x-show="open"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-400"
                                 x-transition:enter-start="translate-y-full opacity-0"
                                 x-transition:enter-end="translate-y-0 opacity-100"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="translate-y-0 opacity-100"
                                 x-transition:leave-end="translate-y-full opacity-0"
                                 id="mobile-menu"
                                 class="fixed inset-x-4 bottom-4 z-50 rounded-2xl bg-white/20 backdrop-blur-2xl ring-1 ring-white/10 shadow-xl p-6 text-white max-h-[80vh] overflow-y-auto"
                                 style="background: rgba(237, 52, 55, 0.95); backdrop-filter: blur(20px);"
                                 role="dialog"
                                 aria-modal="true"
                                 :aria-labelledby="submenu ? 'mobile-submenu-heading' : null"
                                 :aria-label="submenu ? null : '<?php echo esc_js( __( 'Mobile menu', 'bis' ) ); ?>'">

                                <!-- Main Menu -->
                                <div x-show="submenu === null" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-4">
                                    <div class="flex justify-end mb-4">
                                        <button @click="closeMenu()"
                                                type="button"
                                                aria-label="<?php esc_attr_e( 'Close menu', 'bis' ); ?>"
                                                class="text-white/80 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50 rounded-full p-2 -mr-2 -mt-2 transition-all duration-200">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <nav class="space-y-3" aria-label="<?php esc_attr_e( 'Mobile navigation', 'bis' ); ?>">
                                        <button @click="openSubmenu('about')"
                                            type="button"
                                            aria-haspopup="true"
                                            :aria-expanded="(submenu === 'about').toString()"
                                            aria-label="<?php echo esc_attr( sprintf( __( 'Open %s submenu', 'bis' ), __( 'Who We Are', 'bis' ) ) ); ?>"
                                            class="w-full text-left text-base font-semibold text-white hover:text-white/80 transition-colors duration-200 flex items-center justify-between py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">
                                            <?php esc_html_e( 'Who We Are', 'bis' ); ?>
                                            <svg class="h-4 w-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <button @click="openSubmenu('services')"
                                            type="button"
                                            aria-haspopup="true"
                                            :aria-expanded="(submenu === 'services').toString()"
                                            aria-label="<?php echo esc_attr( sprintf( __( 'Open %s submenu', 'bis' ), __( 'Services', 'bis' ) ) ); ?>"
                                            class="w-full text-left text-base font-semibold text-white hover:text-white/80 transition-colors duration-200 flex items-center justify-between py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">
                                            <?php esc_html_e( 'Services', 'bis' ); ?>
                                            <svg class="h-4 w-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <button @click="openSubmenu('industries')"
                                            type="button"
                                            aria-haspopup="true"
                                            :aria-expanded="(submenu === 'industries').toString()"
                                            aria-label="<?php echo esc_attr( sprintf( __( 'Open %s submenu', 'bis' ), __( 'Industries', 'bis' ) ) ); ?>"
                                            class="w-full text-left text-base font-semibold text-white hover:text-white/80 transition-colors duration-200 flex items-center justify-between py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">
                                            <?php esc_html_e( 'Industries', 'bis' ); ?>
                                            <svg class="h-4 w-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <button @click="openSubmenu('resources')"
                                            type="button"
                                            aria-haspopup="true"
                                            :aria-expanded="(submenu === 'resources').toString()"
                                            aria-label="<?php echo esc_attr( sprintf( __( 'Open %s submenu', 'bis' ), __( 'Resources', 'bis' ) ) ); ?>"
                                            class="w-full text-left text-base font-semibold text-white hover:text-white/80 transition-colors duration-200 flex items-center justify-between py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">
                                            <?php esc_html_e( 'Resources', 'bis' ); ?>
                                            <svg class="h-4 w-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </nav>

                                    <div class="mt-6">
                                        <a href="<?php echo esc_url(home_url('/contact')); ?>"
                                            class="block w-full text-center bg-white text-[#ed3437] font-medium py-3 rounded-lg hover:bg-white/90 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white/50">
                                            <?php esc_html_e('Let\'s Connect', 'bis'); ?>
                                        </a>
                                    </div>
                                </div>

                                <!-- Submenus -->
                                <div x-show="submenu !== null" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-x-8"
                                     x-transition:enter-end="opacity-100 translate-x-0"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-x-0"
                                     x-transition:leave-end="opacity-0 translate-x-8">
                                    <div class="flex justify-between items-center mb-6">
                                        <button @click="closeSubmenu()"
                                                type="button"
                                                aria-label="<?php esc_attr_e( 'Go back to main menu', 'bis' ); ?>"
                                                class="text-white hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 rounded-md p-1">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <h2 id="mobile-submenu-heading" class="text-base font-semibold m-0"
                                            x-text="submenu ? (submenuLabels[submenu] || '') : ''"></h2>
                                        <button @click="closeMenu()"
                                                type="button"
                                                aria-label="<?php esc_attr_e( 'Close menu', 'bis' ); ?>"
                                                class="text-white hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 rounded-md p-1">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- About / Who We Are -->
                                    <div x-show="submenu === 'about'" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 translate-y-4"
                                         class="space-y-3">
                                        <?php
                                        $about_menu_mobile = wp_get_nav_menu_items(5);
                                        if ($about_menu_mobile) {
                                            foreach ($about_menu_mobile as $menu_item) {
                                                echo '<a href="' . esc_url($menu_item->url) . '" class="block text-white hover:text-white/80 transition-colors duration-200 py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">' . esc_html($menu_item->title) . '</a>';
                                            }
                                        }
                                        ?>
                                        <a href="<?php echo esc_url(home_url('/about')); ?>" 
                                            class="block text-base font-semibold text-white hover:text-white/80 my-6 transition-colors duration-200 py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">
                                            <?php esc_html_e('Learn More About Us', 'bis'); ?>
                                        </a>
                                    </div>

                                    <!-- Services -->
                                    <div x-show="submenu === 'services'" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 translate-y-4"
                                         class="space-y-3">
                                        <?php
                                        $services = new WP_Query([
                                            'post_type'      => 'service',
                                            'posts_per_page' => -1,
                                            'post_status'    => 'publish',
                                            'orderby'        => 'title',
                                            'order'          => 'ASC',
                                        ]);
                                        if ($services->have_posts()) {
                                            while ($services->have_posts()) {
                                                $services->the_post();
                                                echo '<a href="' . esc_url(get_permalink()) . '" class="block text-white hover:text-white/80 transition-colors duration-200 py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">' . esc_html(get_the_title()) . '</a>';
                                            }
                                            wp_reset_postdata();
                                        }
                                        ?>
                                        <a href="<?php echo esc_url(home_url('/services')); ?>" 
                                           class="block text-base font-semibold text-white hover:text-white/80 my-6 transition-colors duration-200 py-2 px-1 rounded-md hover:bg-white/10">
                                            <?php esc_html_e('Explore All Services', 'bis'); ?>
                                        </a>
                                    </div>

                                    <!-- Industries -->
                                    <div x-show="submenu === 'industries'" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 translate-y-4"
                                         class="space-y-3">
                                        <?php
                                        $industries = new WP_Query([
                                            'post_type'      => 'industry',
                                            'posts_per_page' => -1,
                                            'post_status'    => 'publish',
                                        ]);
                                        if ($industries->have_posts()) {
                                            while ($industries->have_posts()) {
                                                $industries->the_post();
                                                echo '<a href="' . esc_url(get_permalink()) . '" class="block text-white hover:text-white/80 transition-colors duration-200 py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">' . esc_html(get_the_title()) . '</a>';
                                            }
                                            wp_reset_postdata();
                                        }
                                        ?>
                                        <a href="<?php echo esc_url(home_url('/industries')); ?>" 
                                           class="block text-base font-semibold text-white hover:text-white/80 my-6 transition-colors duration-200 py-2 px-1 rounded-md hover:bg-white/10">
                                            <?php esc_html_e('Explore All Industries', 'bis'); ?>
                                        </a>
                                    </div>

                                    <!-- Resources -->
                                    <div x-show="submenu === 'resources'" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 translate-y-4"
                                         class="space-y-3">
                                        <?php
                                        $resource_menu_mobile = wp_get_nav_menu_items(4);
                                        if ($resource_menu_mobile) {
                                            foreach ($resource_menu_mobile as $menu_item) {
                                                echo '<a href="' . esc_url($menu_item->url) . '" class="block text-white hover:text-white/80 transition-colors duration-200 py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">' . esc_html($menu_item->title) . '</a>';
                                            }
                                        }
                                        ?>
                                        <a href="<?php echo esc_url(home_url('/resources/')); ?>" 
                                            class="block text-base font-semibold text-white hover:text-white/80 my-6 transition-colors duration-200 py-2 px-1 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">
                                            <?php esc_html_e('Explore All Resources', 'bis'); ?>
                                        </a>
                                    </div>

                                    <div class="mt-6">
                                        <a href="<?php echo esc_url(home_url('/contact')); ?>"
                                            class="block w-full text-center bg-white text-[#ed3437] font-medium py-3 rounded-lg hover:bg-white/90 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white/50">
                                            <?php esc_html_e('Let\'s Connect', 'bis'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main id="primary" class="site-main" tabindex="-1">