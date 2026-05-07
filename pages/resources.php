<?php
/**
 * Template Name: Resources
 *
 * The template for displaying the resources page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part('components/layout/breadcrumb');
?>

<section class="py-20 bg-white" aria-labelledby="resources-list-heading">
    <h2 id="resources-list-heading" class="sr-only"><?php esc_html_e( 'Resources', 'bis' ); ?></h2>
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <?php
        $resources = get_posts([
            'post_type'      => 'resource',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]);

        if ($resources) :
            ?>
            <!-- Resources Grid -->
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 list-none p-0 m-0" role="list" data-aos="fade-up">
                <?php foreach ($resources as $post) :
                    setup_postdata($post);
                    $description = get_field('description');
                    set_query_var('description', $description);
                ?>
                    <li class="h-full">
                        <?php get_template_part('components/cards/resource-card'); ?>
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