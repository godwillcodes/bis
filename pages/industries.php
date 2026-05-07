<?php
/**
 * Template Name: Industries
 *
 * The template for displaying the industries page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part( 'components/layout/breadcrumb' ); 
?>

<section class="mt-20 lg:mt-20 bg-white" aria-labelledby="industries-list-heading">
    <h2 id="industries-list-heading" class="sr-only"><?php esc_html_e( 'Industries we serve', 'bis' ); ?></h2>
    <div class="max-w-7xl mx-auto px-6 lg:px-0">
        <?php
        $industries = get_posts([
            'post_type'      => 'industry',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]);

        if ( $industries ) :
        ?>
            <ul role="list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10 list-none p-0 m-0">
                <?php foreach ( $industries as $post ) :
                    setup_postdata( $post );
                    $description = get_field( 'introtext' );
                    set_query_var( 'description', $description );
                    ?>
                    <li>
                        <?php get_template_part( 'components/cards/industry-card' ); ?>
                    </li>
                <?php
                endforeach;
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