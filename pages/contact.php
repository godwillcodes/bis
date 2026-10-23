<?php
/**
 * Template Name: Contact
 *
 * The template for displaying the contact page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part( 'components/layout/breadcrumb' ); 
?>

<!-- Contact Section -->
<section class="py-10 bg-white" aria-labelledby="contact-heading">
    <h2 id="contact-heading" class="sr-only"><?php esc_html_e( 'Contact us', 'bis' ); ?></h2>
    <div class="max-w-7xl mx-auto px-4 lg:px-0">
        <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-0 lg:gap-0 border border-2 border-gray-800">

            <!-- Left: Contact Form -->
            <div class="bg-white px-6 lg:px-12 py-12 lg:py-16" role="region" aria-labelledby="contact-form-heading">
                <h3 id="contact-form-heading" class="text-3xl font-bold text-gray-900 mb-8 tracking-tight">
                    <?php esc_html_e( "Let's Talk Access — Reach Out Today", 'bis' ); ?>
                </h3>

                <?php /* HubSpot sets cookies, so the form loads through js/consent.js after Accept. */ ?>
                <div data-bis-hubspot-form data-portal-id="22423917" data-form-id="6a41bbc9-085d-4e4d-b246-efda87962584" data-region="na1">
                    <div class="bisc-form-target" data-bisc-form-target></div>
                    <div class="bisc-panel text-gray-700">
                        <div class="bisc-msg-consent">
                            <p class="m-0"><?php esc_html_e( 'The contact form is provided by HubSpot, which sets cookies, so it loads only if you accept them.', 'bis' ); ?></p>
                            <div class="bisc-panel-actions">
                                <button type="button" class="bisc-panel-btn" data-bis-cookie-settings><?php esc_html_e( 'Review cookie choices', 'bis' ); ?></button>
                            </div>
                        </div>
                        <p class="bisc-msg-loading m-0" role="status"><?php esc_html_e( 'Loading the form.', 'bis' ); ?></p>
                        <p class="bisc-msg-error m-0" role="status"><?php esc_html_e( 'The form could not load.', 'bis' ); ?></p>
                        <p class="m-0">
                            <?php esc_html_e( 'You can also email us at', 'bis' ); ?>
                            <a href="mailto:info@bisworld.com">info@bisworld.com</a>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Information & Map -->
            <div class="bg-gray-900 px-6 lg:px-12 py-12 lg:py-16 relative overflow-hidden" role="region" aria-labelledby="contact-info-heading">
                <h3 id="contact-info-heading" class="sr-only"><?php esc_html_e( 'Contact information and location', 'bis' ); ?></h3>

                <!-- Pattern Background -->
                <div class="absolute inset-0 opacity-5 z-0" aria-hidden="true"
                    style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/patterns-01-scaled.webp'); background-repeat: repeat; background-size: auto; background-position: center;">
                </div>

                <div class="relative z-10">
                    <!-- Social Media Icons -->
                    <ul class="flex items-center gap-4 mb-10 list-none p-0 m-0" role="list" aria-label="<?php esc_attr_e( 'Connect with us on social media', 'bis' ); ?>">
                        <li>
                            <a href="https://www.facebook.com/BirnbaumInterpreting" target="_blank"
                                rel="noopener noreferrer" class="text-white hover:text-red-600 transition-colors inline-flex"
                                aria-label="<?php esc_attr_e( 'Visit us on Facebook (opens in new tab)', 'bis' ); ?>">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://x.com/BIS__World" target="_blank" rel="noopener noreferrer"
                                class="text-white hover:text-red-600 transition-colors inline-flex"
                                aria-label="<?php esc_attr_e( 'Visit us on X (Twitter) (opens in new tab)', 'bis' ); ?>">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/company/2666458/" target="_blank" rel="noopener noreferrer"
                                class="text-white hover:text-red-600 transition-colors inline-flex"
                                aria-label="<?php esc_attr_e( 'Visit us on LinkedIn (opens in new tab)', 'bis' ); ?>">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <path fill-rule="evenodd"
                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/@BirnbaumInterpretingServices" target="_blank"
                                rel="noopener noreferrer" class="text-white hover:text-red-600 transition-colors inline-flex"
                                aria-label="<?php esc_attr_e( 'Visit us on YouTube (opens in new tab)', 'bis' ); ?>">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <path d="M24.325 8.309s-2.655-.334-8.357-.334c-5.517 0-8.294.334-8.294.334A2.675 2.675 0 0 0 5 10.984v10.034a2.675 2.675 0 0 0 2.674 2.676s2.582.332 8.294.332c5.709 0 8.357-.332 8.357-.332A2.673 2.673 0 0 0 27 21.018V10.982a2.673 2.673 0 0 0-2.675-2.673zM13.061 19.975V12.03L20.195 16l-7.134 3.975z"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>

                    <!-- Contact Information -->
                    <dl class="space-y-6 text-white mb-10">
                        <div>
                            <dt class="font-semibold mb-2"><?php esc_html_e( 'Address', 'bis' ); ?></dt>
                            <dd class="text-gray-300 m-0">
                                <?php
                                /* translators: 1: street address, 2: city / state / zip */
                                printf(
                                    '%1$s<br>%2$s',
                                    esc_html__( '2 Bethesda Metro Center', 'bis' ),
                                    esc_html__( 'Bethesda, MD 20814', 'bis' )
                                );
                                ?>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-semibold mb-2"><?php esc_html_e( 'Nationwide Toll Free', 'bis' ); ?></dt>
                            <dd class="text-gray-300 m-0">
                                <a href="tel:+18004716441" class="text-gray-300 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white rounded-sm">800.471.6441</a>
                            </dd>
                            <dd class="text-sm text-gray-400 mt-1 m-0"><?php esc_html_e( 'Follow the instructions to reach our coordination team', 'bis' ); ?></dd>
                        </div>
                        <div>
                            <dt class="font-semibold mb-2"><?php esc_html_e( 'Telephone', 'bis' ); ?></dt>
                            <dd class="text-gray-300 m-0">
                                <a href="tel:+13015878885" class="text-gray-300 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white rounded-sm">+(1) 301-587-8885</a>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-semibold mb-2"><?php esc_html_e( 'Fax', 'bis' ); ?></dt>
                            <dd class="text-gray-300 m-0">+(1) 301-565-0366</dd>
                        </div>
                        <div>
                            <dt class="font-semibold mb-2"><?php esc_html_e( 'Operating Hours', 'bis' ); ?></dt>
                            <dd class="text-gray-300 m-0"><?php esc_html_e( 'Monday – Friday, 7:30 AM – 5:30 PM ET', 'bis' ); ?></dd>
                        </div>
                    </dl>

                    <!-- Google Map -->
                    <div class="w-full h-64 lg:h-80 rounded-lg overflow-hidden border border-gray-700" data-bis-embed>

                        <iframe class="bisc-embed-frame" data-bisc-embed-frame
                            data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3102.965074371742!2d-77.09527868465448!3d38.984179979562!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b7c97c8d2f5b5d%3A0x5b5b5b5b5b5b5b5b!2s2%20Bethesda%20Metro%20Center%2C%20Bethesda%2C%20MD%2020814!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="<?php esc_attr_e( 'BIS office location map — 2 Bethesda Metro Center', 'bis' ); ?>">
                        </iframe>

                        <?php /* Google Maps sets cookies, so the frame gets its src from js/consent.js after Accept. */ ?>

                        <div class="bisc-panel text-gray-300 p-6">

                            <div class="bisc-msg-consent">

                                <p class="m-0"><?php esc_html_e( 'The map is provided by Google, which sets cookies, so it loads only if you accept them.', 'bis' ); ?></p>

                                <div class="bisc-panel-actions">

                                    <button type="button" class="bisc-panel-btn" data-bis-cookie-settings><?php esc_html_e( 'Review cookie choices', 'bis' ); ?></button>

                                    <a class="bisc-panel-btn bisc-panel-btn-quiet" href="https://www.google.com/maps/search/?api=1&amp;query=2+Bethesda+Metro+Center+Bethesda+MD+20814" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Open in Google Maps', 'bis' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in a new tab)', 'bis' ); ?></span></a>

                                </div>

                            </div>

                            <p class="bisc-msg-error m-0" role="status"><?php esc_html_e( 'The map could not load.', 'bis' ); ?></p>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php 
get_template_part('components/sections/logo-carousel');
get_footer();