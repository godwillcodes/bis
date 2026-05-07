<?php
/**
 * Logo Carousel Component
 * 
 * Displays a carousel of logos using Owl Carousel
 * 
 * @package BIS
 */

$logos = get_field('logos', 'option');

if ( empty( $logos ) || ! is_array( $logos ) ) {
	return;
}

// Generate unique ID for this carousel instance
$carousel_id = 'logo-carousel-' . uniqid();
?>

<section class="logo-carousel-section py-5" aria-labelledby="logo-carousel-heading">
	<h2 id="logo-carousel-heading" class="sr-only"><?php esc_html_e( 'Partner logos', 'bis' ); ?></h2>
	<div class="max-w-7xl mx-auto px-6 lg:px-0">
		<div class="owl-carousel owl-theme logo-carousel" id="<?php echo esc_attr( $carousel_id ); ?>"
			role="region" aria-label="<?php esc_attr_e( 'Partner logos, slide carousel', 'bis' ); ?>">
			<?php foreach ( $logos as $logo ) :
				$logo_url = $logo['url'] ?? '';
				$link_url = $logo['link'] ?? $logo['url'] ?? '';
				$alt_text = $logo['alt'] ?? __( 'Partner Logo', 'bis' );
			?>
				<div class="item">
					<div class="logo-item-wrapper h-20 md:h-20 flex items-center justify-center p-6">
						<?php if ( $logo_url ) : ?>
							<?php if ( $link_url && $link_url !== '#' ) : ?>
								<a href="<?php echo esc_url( $link_url ); ?>"
								   class="block w-full h-full flex items-center justify-center focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed3437] focus-visible:ring-offset-2 rounded"
								   target="_blank"
								   rel="noopener noreferrer"
								   aria-label="<?php echo esc_attr( sprintf( __( 'Visit %s website (opens in new tab)', 'bis' ), $alt_text ) ); ?>">
									<img src="<?php echo esc_url( $logo_url ); ?>"
										 alt=""
										 class="max-w-full max-h-full w-auto h-auto object-contain transition-all duration-300 opacity-70 hover:opacity-100"
										 loading="lazy" />
								</a>
							<?php else : ?>
								<div class="w-full h-full flex items-center justify-center">
									<img src="<?php echo esc_url( $logo_url ); ?>"
										 alt="<?php echo esc_attr( $alt_text ); ?>"
										 class="max-w-full max-h-full w-auto h-auto object-contain transition-all duration-300 opacity-70 hover:opacity-100"
										 loading="lazy" />
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

