<?php
/**
 * Quick View
 *
 * @package Flatsome
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

do_action( 'wc_quick_view_before_single_product' );
?>
<div class="product-quick-view-container">
	<div class="product-quick-head pb-half pt-half">
		<h3 class="left mb-0">Item Details</h3>
		<?php 
			echo apply_filters('flatsome_lightbox_close_button', '<button title="Close" type="button" class="mfp-close right"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>');
		?>
	</div>
	<div class="row row-collapse mb-0 product inner-padding" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="product-gallery large-6 col">
			<div class="slider slider-show-nav product-gallery-slider main-images mb-0">
				<?php if ( has_post_thumbnail() ) :

					$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
					$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
					$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' ), array(
						'title' => $image_title,
					) );

					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="slide first">%s</div>', $image ), $post->ID ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

					// Additional images.
					$attachment_ids = $product->get_gallery_image_ids();
					if ( $attachment_ids ) {
						$loop    = 0;
						$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

						foreach ( $attachment_ids as $attachment_id ) {
							$image_title = esc_attr( get_the_title( $attachment_id ) );
							$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' ), array(
								'title' => $image_title,
								'alt'   => $image_title,
							) );
							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="slide">%s</div>', $image ), $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
						}
					};
				else :
					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src( 'woocommerce_single' ), esc_html__( 'Awaiting product image', 'woocommerce' ) ), $post->ID ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
				endif;
				?>
			</div>

			<ul class="slider-nav">
			  	<?php 
					$attachment_ids = $product->get_gallery_image_ids();

					if ( has_post_thumbnail() ) :
						?>
						<li class="nav-cell active">
							<?php
								$image_id  = get_post_thumbnail_id( $post->ID );
								$image     = wp_get_attachment_image_src( $image_id, apply_filters( 'woocommerce_gallery_thumbnail_size', 'woocommerce_gallery_thumbnail' ) );
								$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
								$image     = '<img src="' . $image[0] . '" alt="' . $image_alt . '" width="' . $gallery_thumbnail['width'] . '" height="' . $gallery_thumbnail['height'] . '" class="attachment-woocommerce_thumbnail" />';

								echo $image;
							?>
						</li>
						<?php
					endif;

					foreach ( $attachment_ids as $attachment_id ) {
						$classes     = array( '' );
						$image_class = esc_attr( implode( ' ', $classes ) );
						$image       = wp_get_attachment_image_src( $attachment_id, apply_filters( 'woocommerce_gallery_thumbnail_size', 'woocommerce_gallery_thumbnail' ) );
						$image_alt   = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
						$image       = '<img src="' . $image[0] . '" alt="' . $image_alt . '" width="' . $gallery_thumbnail['width'] . '" height="' . $gallery_thumbnail['height'] . '"  class="attachment-woocommerce_thumbnail" />';

						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li class="nav-cell">%s</li>', $image ), $attachment_id, $post->ID, $image_class );
					}
				?>
			</ul>

			<?php do_action( 'woocommerce_before_single_product_lightbox_summary' ); ?>
		</div>

		<div class="product-info product-summary summary large-6 col entry-summary">
			<div class="product-lightbox-inner">
				<a class="plain" href="<?php the_permalink(); ?>"><h1><?php the_title(); ?></h1></a>
				<div class="product-star" style="margin-top:-7px;margin-bottom:5px">
				  <span class="star">
				    <span class="fa fa-star checked"></span>
				    <span class="fa fa-star checked"></span>
				    <span class="fa fa-star checked"></span>
				    <span class="fa fa-star checked"></span>
				    <span class="fa fa-star checked"></span>
				  </span>
				  <a data-click="0" href="#" class="load-review reviews middle-of-product-reviews">
				    <?php echo do_shortcode('[jgm-review-rating]'); ?> Stars | <?php echo do_shortcode('[jgm-review-count]'); ?> reviews
				  </a>
				</div>
				<?php do_action( 'woocommerce_single_product_lightbox_summary' ); ?>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'wc_quick_view_after_single_product' ); ?>
