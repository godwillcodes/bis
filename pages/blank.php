<?php
/**
 * Template Name: Blank
 *
 * The template for displaying the blank page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part( 'components/layout/breadcrumb' ); 

// Setup post data
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        ?>
        <section class="py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 lg:px-0 blog-text">
                <div class="">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
        <?php
    endwhile;
endif;

?>

<?php 
get_template_part('components/sections/cta'); 
get_template_part('components/sections/logo-carousel');
get_footer();