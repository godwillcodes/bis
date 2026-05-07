<?php
/**
 * Template Name: Blog
 *
 * The template for displaying the blog page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part('components/layout/breadcrumb');
?>

<section class="py-20 bg-gradient-to-br from-gray-50/80 via-white to-gray-50/60" aria-labelledby="blog-list-heading">
    <h2 id="blog-list-heading" class="sr-only"><?php esc_html_e( 'Blog posts', 'bis' ); ?></h2>
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <?php
        $blog_posts = get_posts([
            'post_type'      => 'post',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        if ($blog_posts) :
            ?>
            <!-- Post Grid -->
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 list-none p-0 m-0" role="list" data-aos="fade-up">
                <?php foreach ($blog_posts as $post) :
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
get_footer();