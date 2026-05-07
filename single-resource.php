<?php
get_header();
while (have_posts()):
    the_post();
    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    ?>

<!-- Hero Section with Featured Image -->
<section class="relative overflow-hidden">
    <?php if ($featured_image): ?>
    <div class="absolute inset-0 z-0">
        <img src="<?php echo esc_url($featured_image); ?>" alt=""
            class="w-full h-[60vh] object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/70 to-black/90"></div>
    </div>
    <?php else: ?>
    <div class="absolute inset-0 z-0 bg-gradient-to-br from-red-600 to-red-800"></div>
    <?php endif; ?>

    <div class="max-w-7xl mx-auto px-4 relative z-10 pt-40 pb-16">
        <div class="">


            <!-- Title -->
            <h1 class="text-4xl text-white font-bold mb-8 leading-tight">
                <?php the_title(); ?>
            </h1>
        </div>
    </div>
</section>

<?php get_template_part('components/layout/breadcrumb'); ?>

<!-- Content Section -->
<?php $content = get_the_content(); ?>
<?php if (!empty(trim($content))): ?>
<section class="pt-10 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Resource Content -->
        <article
            class="prose prose-xl blog-text font-inherit max-w-none blog-text prose-p:text-lg prose-p:lg:text-xl prose-headings:text-2xl prose-headings:lg:text-3xl prose-li:text-lg prose-li:lg:text-xl">
            <?php
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links mt-8 pt-8 border-t border-gray-200">' . esc_html__('Pages:', 'bis'),
                    'after' => '</div>',
                )
            );
            ?>
        </article>
    </div>
</section>
<?php endif; ?>

<!-- Accordion Section - independent of content -->
<section class="py-10 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <?php
        set_query_var('accordion_args', array(
            'title' => 'Resource Information',
            'description' => 'Key details about our resources and services',
            'id' => 'accordion-resource',
        ));
        get_template_part('components/content/accordion');
        ?>
    </div>
</section>

<!-- Post Navigation - independent of content -->
<?php
$prev_post = get_previous_post();
$next_post = get_next_post();
if ($prev_post || $next_post):
?>
<section class="py-10 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <nav class="pt-8 border-t border-gray-200" aria-label="<?php esc_attr_e( 'Resource navigation', 'bis' ); ?>">
            <h2 class="sr-only"><?php esc_html_e( 'Resource navigation', 'bis' ); ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if ($prev_post): ?>
                    <a href="<?php echo esc_url(get_permalink($prev_post)); ?>"
                        class="group block p-6 bg-gray-50 hover:bg-red-50/50 rounded-lg transition-colors border border-gray-200 hover:border-red-200">
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            <span>Previous Resource</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-red-600 transition-colors">
                            <?php echo esc_html(get_the_title($prev_post)); ?>
                        </h3>
                    </a>
                <?php endif; ?>

                <?php if ($next_post): ?>
                    <a href="<?php echo esc_url(get_permalink($next_post)); ?>"
                        class="group block p-6 bg-gray-50 hover:bg-red-50 rounded-lg transition-colors border border-gray-200 hover:border-red-300 text-right md:text-left">
                        <div class="flex items-center justify-end md:justify-start gap-2 text-sm text-gray-600 mb-2">
                            <span>Next Resource</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-red-600 transition-colors">
                            <?php echo esc_html(get_the_title($next_post)); ?>
                        </h3>
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</section>
<?php endif; ?>

<?php
endwhile;
?>

<?php
get_template_part('components/sections/cta');
get_template_part('components/sections/logo-carousel');
get_footer();
?>