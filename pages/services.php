<?php
/**
 * Template Name: Services
 *
 * The template for displaying the services page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part( 'components/layout/breadcrumb' ); 
?>

<section class="py-20" aria-labelledby="services-list-heading">
    <h2 id="services-list-heading" class="sr-only"><?php esc_html_e( 'Our services', 'bis' ); ?></h2>
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <?php
        $services = get_posts([
            'post_type'      => 'service',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]);

        if ($services) :
            ?>
            <!-- Services Grid -->
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 items-stretch list-none p-0 m-0" role="list" data-aos="fade-up">
                <?php foreach ($services as $post) :
                    setup_postdata($post);
                    $description = get_field('introtext');
                    set_query_var( 'description', $description );
                ?>
                    <li class="h-full">
                        <?php get_template_part( 'components/cards/service-card' ); ?>
                    </li>
                <?php endforeach;
                wp_reset_postdata();
                ?>
            </ul>
        <?php endif; ?>
    </div>
</section>

<?php 
get_template_part('components/sections/cta'); 
get_template_part('components/sections/logo-carousel');
get_footer();