<section class="py-12" aria-labelledby="cta-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <div class="relative bg-gray-900 text-white rounded-3xl overflow-hidden">

            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-5" aria-hidden="true"
                style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/patterns-01-scaled.webp'); background-repeat: repeat; background-size: cover;">
            </div>

            <div class="relative z-10 px-8 lg:px-16 py-16 lg:py-20 text-center">
                <h2 id="cta-heading" class="text-3xl font-bold max-w-xl mx-auto mb-4 tracking-tight">
                    <?php esc_html_e( 'Ready to create a more inclusive, accessible space?', 'bis' ); ?>
                </h2>
                <p class="text-base lg:text-lg font-light text-gray-200 max-w-2xl mx-auto leading-relaxed">
                    <?php esc_html_e( "We're here to help. Contact BIS to support your Deaf access needs, ensure compliance, and build community.", 'bis' ); ?>
                </p>

                <div class="max-w-4xl mx-auto">
                    <script src="https://js.hsforms.net/forms/embed/v2.js" defer></script>
                    <div id="cta-hubspot-form"
                        role="form"
                        aria-label="<?php esc_attr_e( 'Contact form', 'bis' ); ?>"></div>

                    <script>
                    window.addEventListener('DOMContentLoaded', function () {
                        if (typeof hbspt === 'undefined' || !hbspt.forms) { return; }
                        hbspt.forms.create({
                            region:   "na1",
                            portalId: "22423917",
                            formId:   "fcd51d31-6a18-499b-b052-67cc3d49a661",
                            target:   "#cta-hubspot-form",
                            cssClass: "custom-hs-form"
                        });
                    });
                    </script>

                    <p class="text-sm text-gray-200">
                        <?php
                        printf(
                            /* translators: %s: link to privacy policy */
                            esc_html__( "By submitting this form, you agree to receive marketing emails from BIS. You also agree to BIS's %s.", 'bis' ),
                            '<a href="' . esc_url( home_url( '/privacy-policy' ) ) . '" class="text-white underline hover:no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-white rounded-sm">' . esc_html__( 'Privacy Policy', 'bis' ) . '</a>'
                        );
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

