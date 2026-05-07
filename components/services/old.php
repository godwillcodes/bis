<?php
get_header();
get_template_part('components/layout/banner');

// Setup post data
if ( have_posts() ) :
    the_post();
endif;
?>


<?php 
get_template_part( 'components/layout/breadcrumb' ); 

// Check what content exists
$has_content = ! empty( trim( get_the_content() ) );
$has_faqs    = get_field( 'faqs' ) && ! empty( get_field( 'faqs' ) );

// Determine spacing based on what sections exist
$content_padding = $has_faqs ? 'pt-16 lg:pt-20 pb-8 lg:pb-12' : 'py-16 lg:py-20';
$faq_padding     = $has_content ? 'pt-8 lg:pt-12 pb-16 lg:pb-24' : 'py-16 lg:py-24';
?>

<?php if ( $has_content ) : ?>
<!-- Content Section -->
<section class="<?php echo esc_attr( $content_padding ); ?> bg-white">
	<div class="max-w-7xl mx-auto px-4">
		<?php get_template_part( 'components/content/blog-content' ); ?>
	</div>
</section>
<?php endif; ?>

<?php if ( $has_faqs ) : ?>
<!-- FAQ Section -->
<section class="<?php echo esc_attr( $faq_padding ); ?> bg-gradient-to-br from-gray-50/80 via-white to-gray-50/60">
	<div class="max-w-7xl mx-auto px-4">
		<?php
		set_query_var( 'accordion_args', array(
			'title'        => 'Frequently Asked Questions',
			'description'  => 'Everything you need to know about our services',
			'id'           => 'accordion',
		) );
		get_template_part( 'components/content/accordion' );
		?>
	</div>
</section>
<?php endif; ?>



<?php
get_template_part('components/sections/cta'); 
get_template_part('components/sections/logo-carousel');
get_footer();
?>