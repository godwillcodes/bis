<?php
/**
 * Template Name: Careers
 *
 * The template for displaying the careers page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part('components/layout/breadcrumb');
?>

<!-- Careers Application Section -->
<section class="py-10 bg-white" aria-labelledby="careers-application-heading">
    <div class="max-w-7xl mx-auto px-4 lg:px-0">
        <div class="border-2 border-gray-800">
            <div class="bg-gray-900 px-6 lg:px-12 py-12 lg:py-16 relative overflow-hidden">
                <!-- Pattern Background -->
                <div class="absolute inset-0 opacity-5 z-0" aria-hidden="true"
                    style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/patterns-01-scaled.webp'); background-repeat: repeat; background-size: auto; background-position: center;">
                </div>

                <div class="relative z-10">
                    <h2 id="careers-application-heading" class="text-white text-center text-2xl font-bold mb-4">
                        <?php esc_html_e( "BIS' ongoing, nationwide recruitment for America's certified and qualified freelance interpreters is open for application.", 'bis' ); ?>
                    </h2>
                    <script src="https://js.hsforms.net/forms/embed/22423917.js" defer></script>
                    <div class="hs-form-frame"
                        data-region="na1"
                        data-form-id="a5020bd1-1d62-4203-8ac6-42f890798a68"
                        data-portal-id="22423917"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_template_part('components/sections/logo-carousel');
get_footer();