<?php
/**
 * Template Name: Language Access Symposium
 * Description: Landing page for the 3rd Annual Language Access Symposium
 */
get_header();
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to   { opacity: 1; transform: scale(1); }
    }

    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    .animate-scale-in   { animation: scaleIn  0.5s ease-out forwards; }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .glass-card-dark {
        background: rgba(17, 24, 39, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .text-balance { text-wrap: balance; }

    /* Focus-visible styles for accessibility (kept local to harmonize with site-wide outline). */
    *:focus-visible {
        outline: 2px solid #ed3437;
        outline-offset: 4px;
    }

    .shadow-soft    { box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 1px 3px rgba(0,0,0,0.02); }
    .shadow-premium { box-shadow: 0 20px 40px -12px rgba(0,0,0,0.12), 0 8px 16px -4px rgba(0,0,0,0.06); }

    /* Honor user motion preference: WCAG 2.3.3 / 2.2.2. */
    @media (prefers-reduced-motion: reduce) {
        .animate-fade-in-up,
        .animate-scale-in,
        .animate-ping {
            animation: none !important;
        }
        html { scroll-behavior: auto; }
    }

    /* No-JS fallback: reveal the modal-controlled image only when JS hydrates it. */
    .speaker-modal[hidden] { display: none !important; }
</style>

<!-- Hero Section -->
<section class="relative bg-gray-900 overflow-hidden" aria-labelledby="event-hero-heading">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900" aria-hidden="true"></div>
    <div class="absolute inset-0 opacity-5" aria-hidden="true"
        style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/patterns-01-scaled.webp'); background-repeat: repeat; background-size: cover; background-position: center;">
    </div>

    <!-- Animated Gradient Orbs -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-radial from-red-600/20 to-transparent blur-3xl rounded-full" aria-hidden="true"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-radial from-red-600/10 to-transparent blur-3xl rounded-full" aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 pt-24 md:pt-32 lg:pt-40 pb-10">
        <?php
        $event_badge_text  = get_field('event_badge_text');
        $event_title       = get_field('event_title');
        $event_description = get_field('event_description');
        $event_h1_text     = $event_title ? esc_html($event_title) : esc_html(get_the_title());
        ?>

        <!-- Event Badge -->
        <?php if ($event_badge_text): ?>
            <div class="inline-flex items-center gap-3 glass-card-dark border border-white/10 rounded-full px-5 py-2.5 mb-8 shadow-premium"
                data-aos="fade-up">
                <span class="relative flex h-2.5 w-2.5" aria-hidden="true">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                </span>
                <span class="text-red-400 text-sm font-semibold tracking-wide uppercase">
                    <?php echo esc_html($event_badge_text); ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Heading -->
        <h1 id="event-hero-heading" class="text-4xl md:text-5xl font-bold text-white max-w-5xl mb-8 leading-[1.1] tracking-tight text-balance"
            data-aos="fade-up" data-aos-delay="100">
            <?php echo $event_h1_text; ?>
        </h1>

        <?php if ($event_description): ?>
            <p class="max-w-3xl text-lg md:text-xl text-gray-300 mb-12 leading-relaxed" data-aos="fade-up"
                data-aos-delay="150">
                <?php echo esc_html($event_description); ?>
            </p>
        <?php endif; ?>

        <!-- Event Details Card -->
        <?php
        $event_date_day = get_field('event_date_day');
        $event_date = get_field('event_date');
        $event_time = get_field('event_time');
        $event_timezone = get_field('event_timezone');
        $event_location_name = get_field('event_location_name');
        $event_location_city = get_field('event_location_city');
        $event_refreshments_title = get_field('event_refreshments_title');
        $event_refreshments_description = get_field('event_refreshments_description');

        $has_event_details = $event_date_day || $event_date || $event_time || $event_location_name || $event_refreshments_title;

        if ($has_event_details):
            ?>
            <div class="glass-card border border-white/20 rounded-3xl p-8 lg:p-10 mb-12 max-w-6xl shadow-premium"
                data-aos="fade-up" data-aos-delay="200">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                    <?php if ($event_date_day || $event_date): ?>
                        <div class="flex items-start gap-4" role="group" aria-label="Event date">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0 shadow-lg"
                                aria-hidden="true">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <div>
                                <?php if ($event_date_day): ?>
                                    <p class="text-gray-900 font-bold text-base"><?php echo esc_html($event_date_day); ?></p>
                                <?php endif; ?>
                                <?php if ($event_date): ?>
                                    <p class="text-gray-600 text-sm mt-1"><?php echo esc_html($event_date); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($event_time): ?>
                        <div class="flex items-start gap-4" role="group" aria-label="Event time">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0 shadow-lg"
                                aria-hidden="true">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-900 font-bold text-base"><?php echo esc_html($event_time); ?></p>
                                <?php if ($event_timezone): ?>
                                    <p class="text-gray-600 text-sm mt-1"><?php echo esc_html($event_timezone); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($event_location_name || $event_location_city): ?>
                        <div class="flex items-start gap-4" role="group" aria-label="Event location">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0 shadow-lg"
                                aria-hidden="true">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                            </div>
                            <div>
                                <?php if ($event_location_name): ?>
                                    <p class="text-gray-900 font-bold text-base"><?php echo esc_html($event_location_name); ?></p>
                                <?php endif; ?>
                                <?php if ($event_location_city): ?>
                                    <p class="text-gray-600 text-sm mt-1"><?php echo esc_html($event_location_city); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($event_refreshments_title || $event_refreshments_description): ?>
                        <div class="flex items-start gap-4" role="group" aria-label="Refreshments">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0 shadow-lg"
                                aria-hidden="true">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 01-6.23.693L5 15.3m14.8 0l.002 1.2a2.25 2.25 0 01-2.248 2.25H6.444a2.25 2.25 0 01-2.248-2.25l.002-1.2" />
                                </svg>
                            </div>
                            <div>
                                <?php if ($event_refreshments_title): ?>
                                    <p class="text-gray-900 font-bold text-base"><?php echo esc_html($event_refreshments_title); ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ($event_refreshments_description): ?>
                                    <p class="text-gray-600 text-sm mt-1"><?php echo esc_html($event_refreshments_description); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- CTA Buttons -->
        <?php
        $cta_button_text = get_field('cta_button_text');
        $cta_button_url = get_field('cta_button_url');
        $cta_subtext = get_field('cta_subtext');

        if ($cta_button_text || $cta_subtext):
            ?>
            <div class="flex flex-col sm:flex-row items-start gap-6" data-aos="fade-up" data-aos-delay="250">
                <?php if ($cta_button_text): ?>
                    <a href="<?php echo esc_url($cta_button_url ?: '#register'); ?>"
                        class="group inline-flex items-center justify-center gap-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold text-base px-10 py-5 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98]"
                        aria-label="<?php echo esc_attr($cta_button_text); ?>">
                        <span><?php echo esc_html($cta_button_text); ?></span>
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>
                <?php endif; ?>
                <?php if ($cta_subtext): ?>
                    <div class="inline-flex items-center gap-3 text-gray-300 text-sm px-5 py-5">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                        </svg>
                        <span><?php echo esc_html($cta_subtext); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php get_template_part('components/layout/breadcrumb'); ?>

<!-- Symposium Agenda Section -->
<?php
$agenda_section_label = get_field('agenda_section_label');
$agenda_section_title = get_field('agenda_section_title');
$agenda_sessions = get_field('agenda_sessions');

if ($agenda_section_label || $agenda_section_title || $agenda_sessions):
    ?>
    <section class="relative py-20 md:py-28 bg-white">
        <div class="max-w-6xl mx-auto px-6">

            <!-- Header (keep BIS branding) -->
            <?php if ($agenda_section_label || $agenda_section_title): ?>
                <header class="max-w-3xl mx-auto text-center mb-16">
                    <?php if ($agenda_section_label): ?>
                        <span class="inline-block mb-4 text-sm font-semibold uppercase tracking-wider text-red-600">
                            <?php echo esc_html($agenda_section_label); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($agenda_section_title): ?>
                        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900">
                            <?php echo esc_html($agenda_section_title); ?>
                        </h2>
                    <?php endif; ?>
                </header>
            <?php endif; ?>

            <!-- Agenda Cards (match Piedmont Global FORMAT, keep BIS colors/fonts) -->
            <?php if ($agenda_sessions && is_array($agenda_sessions) && count($agenda_sessions) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($agenda_sessions as $session):
                        $session_time = $session['session_time'] ?? '';
                        $session_title = $session['session_title'] ?? '';
                        $session_description = $session['session_description'] ?? '';
                        if (!$session_time && !$session_title && !$session_description)
                            continue;
                        ?>
                        <div class="group relative bg-white border-2 border-gray-200 hover:border-[#ed1c24] transition-colors duration-300">
                            <!-- Accent mark - minimal red bar -->
                            <div class="absolute top-0 left-0 w-12 h-0.5 bg-[#ed1c24]"></div>
                            
                            <div class="p-8 md:p-10">
                                <!-- Time -->
                                <?php if (!empty($session_time)): ?>
                                    <div class="mb-6">
                                        <span class="text-[#ed1c24] text-sm font-semibold uppercase tracking-widest">
                                            <?php echo esc_html($session_time); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <!-- Title -->
                                <?php if (!empty($session_title)): ?>
                                    <h3 class="text-2xl  font-bold text-gray-900 mb-4 leading-tight">
                                        <?php echo esc_html($session_title); ?>
                                    </h3>
                                <?php endif; ?>

                                <!-- Description -->
                                <?php if (!empty($session_description)): ?>
                                    <p class="text-gray-600 leading-relaxed text-base">
                                        <?php echo esc_html($session_description); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>
<?php endif; ?>

<!-- Speakers Section -->
<?php
$speakers = get_field('speakers');

if ($speakers && is_array($speakers) && count($speakers) > 0):
    $formatted_speakers = [];
    foreach ($speakers as $speaker) {
        $formatted_speakers[] = [
            'name' => $speaker['speaker_name'] ?? '',
            'title' => $speaker['speaker_title'] ?? '',
            'photo' => $speaker['speaker_image'] ?? '',
            'linkedin' => $speaker['speaker_linkedin'] ?? '',
            'bio' => $speaker['speaker_description'] ?? '',
        ];
    }
    ?>
    <section class="py-16 bg-white" aria-labelledby="speakers-heading">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Header -->
            <header class="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
                <h2 id="speakers-heading" class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900">
                    <?php esc_html_e( 'Featured Speakers', 'bis' ); ?>
                </h2>
                <p class="font-light text-gray-500 lg:mb-16 sm:text-xl">
                    <?php esc_html_e( "Meet the industry experts sharing their insights at this year's symposium", 'bis' ); ?>
                </p>
            </header>

            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8 lg:gap-16 list-none p-0 m-0" role="list">
                <?php foreach ($formatted_speakers as $index => $speaker):
                    if (empty($speaker['name'])) {
                        continue;
                    }
                    /* translators: %s: speaker full name */
                    $card_label = sprintf( __( 'View bio of %s', 'bis' ), $speaker['name'] );
                    ?>
                    <li>
                        <article class="speaker-card group relative h-full overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 focus-within:shadow-2xl focus-within:-translate-y-2"
                            aria-labelledby="speaker-name-<?php echo (int) $index; ?>">

                            <!-- Photo -->
                            <div class="relative aspect-[4/5] overflow-hidden">
                                <?php if ($speaker['photo']): ?>
                                    <img src="<?php echo esc_url($speaker['photo']); ?>"
                                        alt=""
                                        class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center" aria-hidden="true">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                                            viewBox="0 0 24 24" focusable="false">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>

                                <!-- Gradient Overlay (decorative) -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition-opacity duration-500"
                                    aria-hidden="true"></div>
                            </div>

                            <!-- Info -->
                            <div class="p-6 relative">
                                <!-- Accent Line -->
                                <div class="absolute top-0 left-6 right-6 h-0.5 bg-gradient-to-r from-[#ed1c24] via-[#ed1c24] to-transparent transform origin-left scale-x-0 group-hover:scale-x-100 group-focus-within:scale-x-100 transition-transform duration-500"
                                    aria-hidden="true"></div>

                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 id="speaker-name-<?php echo (int) $index; ?>"
                                            class="text-xl font-bold text-gray-900 mb-1 group-hover:text-[#ed1c24] group-focus-within:text-[#ed1c24] transition-colors duration-300">
                                            <?php echo esc_html($speaker['name']); ?>
                                        </h3>
                                        <p class="text-gray-600 font-medium"><?php echo esc_html($speaker['title']); ?></p>
                                    </div>

                                    <!-- Arrow Icon -->
                                    <div class="w-10 h-10 rounded-full bg-gray-100 group-hover:bg-[#ed1c24] group-focus-within:bg-[#ed1c24] flex items-center justify-center transition-all duration-300 flex-shrink-0"
                                        aria-hidden="true">
                                        <svg class="w-5 h-5 text-gray-500 group-hover:text-white group-focus-within:text-white transition-colors duration-300 transform group-hover:translate-x-0.5 group-focus-within:translate-x-0.5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24" focusable="false">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Stretched-link button: covers the whole card so the entire area is one keyboard target. -->
                            <button type="button"
                                class="speaker-card-trigger absolute inset-0 w-full h-full bg-transparent border-0 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed3437] focus-visible:ring-offset-2 rounded-2xl"
                                data-speaker-index="<?php echo (int) $index; ?>"
                                aria-haspopup="dialog"
                                aria-controls="speakerModal"
                                aria-label="<?php echo esc_attr( $card_label ); ?>">
                                <span class="sr-only"><?php echo esc_html( $card_label ); ?></span>
                            </button>
                        </article>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- Speaker Modal -->
    <div id="speakerModal"
        class="speaker-modal fixed inset-0 z-50 opacity-0 transition-opacity duration-300"
        style="transition: opacity 0.3s ease;"
        role="dialog"
        aria-modal="true"
        aria-labelledby="speakerModalName"
        aria-describedby="speakerModalBio"
        hidden>
        <!-- Backdrop (decorative — keyboard close path is the close button + Esc). -->
        <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/60 to-black/70 backdrop-blur-md"
            data-modal-backdrop aria-hidden="true"></div>

        <!-- Modal Content -->
        <div class="relative flex items-center justify-center min-h-screen p-6 md:p-12"
            style="padding-top: 5vh; padding-bottom: 5vh;">
            <div id="speakerModalContent"
                class="relative bg-white rounded-3xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300">

                <!-- Close Button -->
                <button type="button"
                    data-modal-close
                    class="absolute top-6 right-6 z-20 w-12 h-12 flex items-center justify-center rounded-full bg-white/90 hover:bg-white shadow-lg hover:shadow-xl border border-gray-100 transition-all duration-200 group focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed3437]"
                    aria-label="<?php esc_attr_e( 'Close speaker bio', 'bis' ); ?>">
                    <svg class="w-5 h-5 text-gray-700 group-hover:text-gray-900 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Body - Two Column Layout -->
                <div class="flex flex-col md:flex-row">
                    <!-- Left: Photo Section -->
                    <div class="md:w-2/5 relative">
                        <div class="aspect-square md:aspect-auto md:h-full">
                            <img id="speakerModalPhoto" src="" alt="" class="w-full h-full object-cover" hidden>
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent md:bg-gradient-to-r"
                                aria-hidden="true"></div>
                        </div>
                    </div>

                    <!-- Right: Content Section -->
                    <div class="md:w-3/5 p-8 md:p-10 lg:p-12 flex flex-col justify-center">
                        <!-- Header -->
                        <div class="mb-6">
                            <h2 id="speakerModalName"
                                class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 tracking-tight" tabindex="-1"></h2>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-1 bg-[#ed1c24] rounded-full" aria-hidden="true"></div>
                                <p id="speakerModalTitle" class="text-lg text-gray-600 font-medium"></p>
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="mb-8">
                            <div id="speakerModalBio"
                                class="text-gray-700 leading-relaxed text-lg prose prose-lg max-w-none"></div>
                        </div>

                        <!-- LinkedIn CTA -->
                        <div id="speakerModalLinkedInWrapper" class="pt-6 border-t border-gray-100" hidden>
                            <a id="speakerModalLinkedIn" href="" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-3 px-8 py-4 bg-[#0077B5] text-white rounded-xl hover:bg-[#005885] transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2"
                                aria-label="<?php esc_attr_e( 'Connect on LinkedIn (opens in new tab)', 'bis' ); ?>">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                                <span><?php esc_html_e( 'Connect on LinkedIn', 'bis' ); ?></span>
                                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    (function () {
        var speakers             = <?php echo wp_json_encode( $formatted_speakers ); ?>;
        var modal                = document.getElementById('speakerModal');
        var modalContent         = document.getElementById('speakerModalContent');
        var modalPhoto           = document.getElementById('speakerModalPhoto');
        var modalName            = document.getElementById('speakerModalName');
        var modalTitle           = document.getElementById('speakerModalTitle');
        var modalBio             = document.getElementById('speakerModalBio');
        var modalLinkedInWrapper = document.getElementById('speakerModalLinkedInWrapper');
        var modalLinkedIn        = document.getElementById('speakerModalLinkedIn');
        var triggers             = document.querySelectorAll('.speaker-card-trigger');
        var previousFocus        = null;
        var keydownHandler       = null;

        // Selectors for elements that should receive keyboard focus inside the modal.
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

        function openSpeakerModal(index) {
            var speaker = speakers[index];
            if (!speaker) { return; }

            previousFocus = document.activeElement;

            if (speaker.photo) {
                modalPhoto.src    = speaker.photo;
                modalPhoto.alt    = '';
                modalPhoto.hidden = false;
            } else {
                modalPhoto.removeAttribute('src');
                modalPhoto.alt    = '';
                modalPhoto.hidden = true;
            }
            modalName.textContent  = speaker.name || '';
            modalTitle.textContent = speaker.title || '';
            modalBio.innerHTML     = speaker.bio || '';

            if (speaker.linkedin && String(speaker.linkedin).trim() !== '') {
                modalLinkedIn.href           = speaker.linkedin;
                modalLinkedInWrapper.hidden  = false;
            } else {
                modalLinkedIn.removeAttribute('href');
                modalLinkedInWrapper.hidden  = true;
            }

            modal.hidden = false;
            document.body.style.overflow = 'hidden';

            requestAnimationFrame(function () {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
                // Land focus on the dialog title so AT announces context.
                modalName.focus();
            });

            keydownHandler = function (e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                    closeSpeakerModal();
                } else if (e.key === 'Tab') {
                    trapFocus(e);
                }
            };
            document.addEventListener('keydown', keydownHandler);
        }

        function closeSpeakerModal() {
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
                var idx = parseInt(btn.getAttribute('data-speaker-index'), 10);
                if (!isNaN(idx)) { openSpeakerModal(idx); }
            });
        });

        modal.addEventListener('click', function (e) {
            if (e.target.matches('[data-modal-close]') || e.target.closest('[data-modal-close]')) {
                closeSpeakerModal();
            } else if (e.target.matches('[data-modal-backdrop]')) {
                closeSpeakerModal();
            }
        });
    })();
    </script>
<?php endif; ?>

<!-- Two Column Section: Parking & Registration -->
<?php
$parking_section_title = get_field('parking_section_title');
$parking_section_description = get_field('parking_section_description');
$host_organization = get_field('host_organization');
?>
<section class="relative py-20 bg-white">
    <div class="relative max-w-7xl mx-auto px-6">

        <!-- Section Header -->
        <?php if ($parking_section_title || $parking_section_description || $host_organization): ?>
            <div class="text-center mb-16 md:mb-20" data-aos="fade-up">
                <?php if ($host_organization): ?>
                    <div class="inline-flex items-center gap-3 glass-card-dark border border-white/10 rounded-full px-5 py-2.5 mb-6 shadow-premium"
                        data-aos="fade-up" data-aos-delay="100">
                        <span class="relative flex h-2.5 w-2.5">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                        </span>
                        <span class="text-red-400 text-sm font-semibold"><?php echo esc_html($host_organization); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($parking_section_title): ?>
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900" data-aos="fade-up"
                        data-aos-delay="150"><?php echo esc_html($parking_section_title); ?></h2>
                <?php endif; ?>

                <?php if ($parking_section_description): ?>
                    <p class="text-gray-700 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed" data-aos="fade-up"
                        data-aos-delay="200"><?php echo esc_html($parking_section_description); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Unified Two-Column Layout - No Gap on Desktop -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 h-fit">

            <!-- Left Column: Parking & Directions -->
            <?php
            $parking_card_title = get_field('parking_card_title');
            $parking_venue_name = get_field('parking_venue_name');
            $parking_address_line1 = get_field('parking_address_line1');
            $parking_address_line2 = get_field('parking_address_line2');
            $parking_instructions_heading = get_field('parking_instructions_heading');
            $parking_instructions = get_field('parking_instructions');
            $parking_pro_tip = get_field('parking_pro_tip');
            $has_parking_content = $parking_card_title || $parking_venue_name || $parking_address_line1 || $parking_instructions || $parking_pro_tip;
            ?>
            <?php if ($has_parking_content): ?>
                <div class="h-full " data-aos="fade-up" data-aos-delay="100">
                    <article
                        class="glass-card-dark shadow-premium h-full flex flex-col overflow-hidden border-r-0 lg:border-r border border-white/10 lg:border-r-white/20">
                        <!-- Card Header -->
                        <?php if ($parking_card_title || $parking_venue_name): ?>
                            <header
                                class="px-8 md:px-10 py-6 md:py-8 border-b border-white/10 bg-gradient-to-r from-gray-900/50 to-gray-800/50 flex-shrink-0">
                                <div class="flex items-center gap-5">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center flex-shrink-0 shadow-lg"
                                        aria-hidden="true">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <?php if ($parking_card_title): ?>
                                            <h3 class="text-2xl font-bold text-white"><?php echo esc_html($parking_card_title); ?>
                                            </h3>
                                        <?php endif; ?>
                                        <?php if ($parking_venue_name): ?>
                                            <p class="text-gray-400 text-sm mt-1"><?php echo esc_html($parking_venue_name); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </header>
                        <?php endif; ?>

                        <!-- Card Content - Flex Grow to Fill Height -->
                        <div class="p-8 md:p-10 flex-1 flex flex-col justify-between">
                            <!-- Address -->
                            <?php if ($parking_address_line1 || $parking_address_line2): ?>
                                <address
                                    class="not-italic flex items-start gap-4 p-5 bg-white/5 backdrop-blur-sm rounded-2xl mb-10 border border-white/10">
                                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <div>
                                        <?php if ($parking_address_line1): ?>
                                            <p class="font-semibold text-white text-base">
                                                <?php echo esc_html($parking_address_line1); ?></p>
                                        <?php endif; ?>
                                        <?php if ($parking_address_line2): ?>
                                            <p class="text-gray-400 text-sm mt-1"><?php echo esc_html($parking_address_line2); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </address>
                            <?php endif; ?>

                            <!-- Instructions -->
                            <?php if ($parking_instructions && is_array($parking_instructions) && count($parking_instructions) > 0): ?>
                                <?php if ($parking_instructions_heading): ?>
                                    <h4 class="font-bold text-red-500 mb-6 text-sm uppercase tracking-wider">
                                        <?php echo esc_html($parking_instructions_heading); ?></h4>
                                <?php endif; ?>
                                <ol class="space-y-6 flex-1" role="list">
                                    <?php foreach ($parking_instructions as $index => $instruction):
                                        $step_title = $instruction['step_title'] ?? '';
                                        $step_description = $instruction['step_description'] ?? '';

                                        if ($step_title || $step_description):
                                            ?>
                                            <li class="flex gap-5">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center text-white font-bold text-base flex-shrink-0 shadow-lg"
                                                    aria-hidden="true">
                                                    <?php echo ($index + 1); ?>
                                                </div>
                                                <div class="flex-1">
                                                    <?php if ($step_title): ?>
                                                        <p class="font-semibold text-white mb-2 text-base">
                                                            <?php echo esc_html($step_title); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($step_description): ?>
                                                        <p class="text-gray-400 text-sm leading-relaxed">
                                                            <?php echo esc_html($step_description); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ol>
                            <?php endif; ?>

                            <!-- Pro Tip - Always at Bottom -->
                            <?php if ($parking_pro_tip): ?>
                                <aside
                                    class="mt-10 flex items-start gap-4 p-5 bg-red-500/10 rounded-2xl border border-red-500/20 backdrop-blur-sm self-start"
                                    aria-label="<?php esc_attr_e( 'Parking pro tip', 'bis' ); ?>">
                                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    <p class="text-sm text-gray-300 leading-relaxed">
                                        <span class="font-semibold text-red-400">Pro tip:</span>
                                        <?php echo esc_html($parking_pro_tip); ?>
                                    </p>
                                </aside>
                            <?php endif; ?>
                        </div>
                    </article>
                </div>
            <?php endif; ?>

            <!-- Right Column: Registration Form -->
            <?php
            $registration_title = get_field('registration_title');
            $registration_description = get_field('registration_description');
            $registration_topic_email = get_field('registration_topic_email');
            $hubspot_embed_code = get_field('hubspot_embed_code');
            $has_registration_content = $registration_title || $registration_description || $registration_topic_email || $hubspot_embed_code;
            ?>
            <?php if ($has_registration_content): ?>
                <div class="h-full " data-aos="fade-up" data-aos-delay="200" id="register">
                    <article
                        class="glass-card shadow-premium h-full flex flex-col overflow-hidden  border-l-0 lg:border-l border border-gray-200 lg:border-l-white/20">
                        <!-- Header -->
                        <?php if ($registration_title || $registration_description): ?>
                            <header class="p-8 md:p-10 flex-shrink-0">
                                <?php if ($registration_title): ?>
                                    <h3 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900">
                                        <?php echo esc_html($registration_title); ?></h3>
                                <?php endif; ?>
                                <?php if ($registration_description): ?>
                                    <p class="text-gray-600 text-base leading-relaxed">
                                        <?php echo esc_html($registration_description); ?></p>
                                <?php endif; ?>
                            </header>
                        <?php endif; ?>

                        <!-- Main Content - Flex Grow -->
                        <div class="p-8 md:p-10 flex-1 flex flex-col justify-between">
                            <!-- Discussion Topics CTA -->
                            <?php if ($registration_topic_email): ?>
                                <aside
                                    class="flex items-start gap-4 p-5 bg-blue-50 rounded-2xl border border-blue-100 mb-8 hover:bg-blue-100 transition-colors duration-300 self-start"
                                    aria-label="<?php esc_attr_e( 'Submit discussion topics', 'bis' ); ?>">
                                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-blue-900 leading-relaxed">
                                            <span class="font-semibold">Have a topic?</span> Submit discussion topics to
                                            <a href="mailto:<?php echo esc_attr($registration_topic_email); ?>"
                                                class="font-medium text-blue-700 underline hover:text-blue-800 hover:no-underline transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded"><?php echo esc_html($registration_topic_email); ?></a>
                                        </p>
                                    </div>
                                </aside>
                            <?php endif; ?>

                            <!-- HubSpot Form Container -->
                            <?php if ($hubspot_embed_code): ?>
                                <div class="flex-1 bg-gray-50 rounded-2xl p-8 border border-gray-100 mb-8 overflow-hidden">
                                    <?php
                                    // Output the HubSpot embed code safely
                                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    echo $hubspot_embed_code;
                                    ?>
                                </div>
                            <?php endif; ?>

                            <!-- Trust Indicator - Always at Bottom -->
                            <footer
                                class="flex items-center justify-center gap-2 text-xs text-gray-600 pt-4 border-t border-gray-100 self-stretch flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    aria-hidden="true" focusable="false">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <span><?php esc_html_e( 'Your information is secure and encrypted', 'bis' ); ?></span>
                            </footer>
                        </div>
                    </article>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>



<?php
get_template_part('components/sections/logo-carousel');
get_footer();
?>