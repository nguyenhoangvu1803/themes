<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

$row_classes     = array();
$main_classes    = array();
$sidebar_classes = array();

$auto_refresh  = get_theme_mod( 'cart_auto_refresh' );
$row_classes[] = 'row-large';
// $row_classes[] = 'row-divided';

if ( $auto_refresh ) {
	$main_classes[] = 'cart-auto-refresh';
}


$row_classes     = implode( ' ', $row_classes );
$main_classes    = implode( ' ', $main_classes );
$sidebar_classes = implode( ' ', $sidebar_classes );


do_action( 'woocommerce_before_cart' ); ?>
<div class="woocommerce row <?php echo $row_classes; ?>">
<div class="col large-8 pb-0 <?php echo $main_classes; ?>">

<?php wc_print_notices(); ?>

<h2>My Cart</h2>

<script>
	function readCookie(name) {
		var nameEQ = encodeURIComponent(name) + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) === ' ')
						c = c.substring(1, c.length);
				if (c.indexOf(nameEQ) === 0)
						return decodeURIComponent(c.substring(nameEQ.length, c.length));
		}
		return null;
	}
</script>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
<div class="cart-wrapper sm-touch-scroll">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-name" colspan="2"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>
			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo $thumbnail; // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
						}
						?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}

						// Mobile price.
						?>
							<div class="show-for-small mobile-product-price">
								<span class="mobile-product-price__qty"><?php echo $cart_item['quantity']; ?> x </span>
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
							</div>
							<p>
								<span id="num-available-<?php echo $_product->id; ?>"></span>
								<script>
									var numavailable = readCookie('sk-<?php echo $_product->id; ?>');
									var peopleavailabe =readCookie('skpeople-<?php echo $_product->id; ?>');
									if(numavailable){
										if(peopleavailabe){
											jQuery('#num-available-<?php echo $_product->id; ?>').html('<p class="cart-title" style="color: #DC5454;font-size:13px;">Only <span id="num-available">'+numavailable+'</span> available and it\'s in '+peopleavailabe+' people\'s cart.</p>');
										}else{
											jQuery('#num-available-<?php echo $_product->id; ?>').html('<p class="cart-title" style="color: #DC5454;font-size:13px;">There\'re only <span id="num-available">'+numavailable+'</span> of these available.</p>');
										}
									}
								</script>
							</p>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						} else {
							$product_quantity = woocommerce_quantity_input(
								array(
									'input_name'   => "cart[{$cart_item_key}][qty]",
									'input_value'  => $cart_item['quantity'],
									'max_value'    => $_product->get_max_purchase_quantity(),
									'min_value'    => '0',
									'product_name' => $_product->get_name(),
								),
								$_product,
								false
							);
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-remove">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
						</td>
						
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions clear">

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<button type="submit" class="button primary mt-0 pull-left small" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

					<?php fl_woocommerce_version_check( '3.4.0' ) ? wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ) : wp_nonce_field( 'woocommerce-cart' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</div>
</form>

<?php if(!get_theme_mod('cart_hide_they_about')) { ?>
<div class="stamped-reviews-container">

	<div class="stamped-reviews-title-wrapper"><a href="<?php echo get_permalink( get_page_by_path( 'happy' ) );?>" alt="Happy Customers">What they say about the products?</a></div>

	<div class="stamped-reviews-wrapper">
	    
	    <div class="stamped-ratings-wrapper stamped-review-card">
	        <div class="stamped-reviews-image">
	            <a class="fancybox" rel="group noopener noreferrer" href="https://flagwix.com/wp-content/uploads/2020/08/1596893201__20200617_093810_HDR__original-scaled.jpg" target="_blank" onclick="return false;" tabindex="-1"><img src="https://flagwix.com/wp-content/uploads/2020/08/1596893201__20200617_093810_HDR__original-scaled.jpg" style="max-height: 100%; max-width: 100%; width: auto; height: auto; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" scale="0"></a>
	        </div>
	        <!-- <div class="stamped-reviews-date" data-date="9">12/05/2018</div> -->
	        <div class="stamped-reviews-rating stamped-style-color-star"><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><span>5 Stars</span></div>
	        <div class="stamped-reviews-title"><a href="#" class="stamped-review-title stamped-style-color-link" tabindex="-1"><span>Hand of god</span>!</a></div>
	        <div class="stamped-reviews-message stamped-style-color-text"><span>Love this flag!! Means so much with no words to say</span></div>
	        <div class="stamped-reviews-author stamped-style-color-text">Stephanie Smith. <span class="stamped-verified-label stamped-style-color-verified" data-verified-type="2"></span></div>
	        <div class="stamped-reviews-location" style="display: none;">United States</div>
	    </div>

	    <div class="stamped-ratings-wrapper stamped-review-card">
	        <div class="stamped-reviews-image">
	            <a class="fancybox" rel="group noopener noreferrer" href="https://flagwix.com/wp-content/uploads/2020/08/image1.jpeg" target="_blank" onclick="return false;" tabindex="-1"><img src="https://flagwix.com/wp-content/uploads/2020/08/image1.jpeg" style="max-height: 100%; max-width: 100%; width: auto; height: auto; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" scale="0"></a>
	        </div>
	        <div class="stamped-reviews-rating stamped-style-color-star"><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><span>5 Stars</span></div>
	        <div class="stamped-reviews-title"><a href="#" class="stamped-review-title stamped-style-color-link" tabindex="-1"><span>Love it’s vibe!!</span></a></div>
	        <div class="stamped-reviews-message stamped-style-color-text"><span>Colorful, vibrant flag! Very well made!! We have a solar light on it and a glazing ball that matches perfectly in front of it! We love it!!</span></div>
	        <div class="stamped-reviews-author stamped-style-color-text">Cyndi Pridemore. <span class="stamped-verified-label stamped-style-color-verified" data-verified-type="2"></span></div>
	        <div class="stamped-reviews-location" style="display: none;">United States</div>
	    </div>

	    <div class="stamped-ratings-wrapper stamped-review-card">
	        <div class="stamped-reviews-image">
	            <a class="fancybox" rel="group noopener noreferrer" href="https://flagwix.com/wp-content/uploads/2020/08/image0-rotated.jpeg" target="_blank" onclick="return false;" tabindex="-1"><img src="https://flagwix.com/wp-content/uploads/2020/08/image0-rotated.jpeg" style="max-height: 100%; max-width: 100%; width: auto; height: auto; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" scale="0"></a>
	        </div>
	        <div class="stamped-reviews-rating stamped-style-color-star"><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><span>5 Stars</span></div>
	        <div class="stamped-reviews-title"><a href="#" class="stamped-review-title stamped-style-color-link" tabindex="-1"><span>Thank you, it’s beautiful!!!</span></a></div>
	        <div class="stamped-reviews-message stamped-style-color-text"><span>We love our flag, it’s in our inspirational garden!</span></div>
	        <div class="stamped-reviews-author stamped-style-color-text">Janet Castens. <span class="stamped-verified-label stamped-style-color-verified" data-verified-type="2"></span></div>
	        <div class="stamped-reviews-location" style="display: none;">United States</div>
	    </div>

	    <div class="stamped-ratings-wrapper stamped-review-card">
	        <div class="stamped-reviews-image">
	            <a class="fancybox" rel="group noopener noreferrer" href="https://flagwix.com/wp-content/uploads/2020/08/image2.jpeg" target="_blank" onclick="return false;" tabindex="-1"><img src="https://flagwix.com/wp-content/uploads/2020/08/image2.jpeg" style="max-height: 100%; max-width: 100%; width: auto; height: auto; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" scale="0"></a>
	        </div>
	        <div class="stamped-reviews-rating stamped-style-color-star"><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><span>5 Stars</span></div>
	        <div class="stamped-reviews-title"><a href="#" class="stamped-review-title stamped-style-color-link" tabindex="-1"><span>Absolutely Beautiful!</span>!</a></div>
	        <div class="stamped-reviews-message stamped-style-color-text"><span>I received it . Thank you . It’s beautiful</span></div>
	        <div class="stamped-reviews-author stamped-style-color-text">Elena Servin. <span class="stamped-verified-label stamped-style-color-verified" data-verified-type="2"></span></div>
	        <div class="stamped-reviews-location" style="display: none;">United States</div>
	    </div>

	    <div class="stamped-ratings-wrapper stamped-review-card">
	        <div class="stamped-reviews-image">
	            <a class="fancybox" rel="group noopener noreferrer" href="https://flagwix.com/wp-content/uploads/2020/08/Image-scaled.jpeg" target="_blank" onclick="return false;" tabindex="-1"><img src="https://flagwix.com/wp-content/uploads/2020/08/Image-scaled.jpeg" style="max-height: 100%; max-width: 100%; width: auto; height: auto; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" scale="0"></a>
	        </div>
	        <div class="stamped-reviews-rating stamped-style-color-star"><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><span>5 Stars</span></div>
	        <div class="stamped-reviews-title"><a href="#" class="stamped-review-title stamped-style-color-link" tabindex="-1"><span>It is exactly as it looks!</span>!</a></div>
	        <div class="stamped-reviews-message stamped-style-color-text"><span>We got the correct flag. Thank u so much.</span></div>
	        <div class="stamped-reviews-author stamped-style-color-text">Mark Lewis. <span class="stamped-verified-label stamped-style-color-verified" data-verified-type="2"></span></div>
	        <div class="stamped-reviews-location" style="display: none;">United States</div>
	    </div>

	</div>
</div>
<?php } ?>

</div>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="large-4 col pb-0">

	<?php flatsome_sticky_column_open( 'cart_sticky_sidebar' ); ?>

	<div class="cart-collaterals">

		<h4>Cart Total</h4>

		<div class="cart-sidebar col-inner <?php echo $sidebar_classes; ?>">
			<?php if ( wc_coupons_enabled() ) { ?>
			<form class="checkout_coupon mb-0" method="post">
				<div class="coupon">
	        		<h3 class="widget-title togglecoupon"><?php esc_html_e( 'Have a Coupon Code?', 'woocommerce' ); ?></h3>
	        		<div class="cart-coupon-wrapper" style="display: none;">
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="is-form expand" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				</div>
				<script type="text/javascript">
					(function($) {
						$( document ).ready(function() {
							$('.togglecoupon').click(function(){
								$('.cart-coupon-wrapper').toggle();
							});
						});
					})(jQuery);
				</script>
			</form>
			<?php } ?>
			<?php
				/**
				 * Cart collaterals hook.
				 *
				 * @hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 */
				do_action( 'woocommerce_cart_collaterals' );
			?>
		</div>

	</div>

	<?php do_action( 'flatsome_cart_sidebar' ); ?>

	<?php flatsome_sticky_column_close( 'cart_sticky_sidebar' ); ?>
</div>
</div>

<style>@font-face{font-family:stamped-font;src:url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.eot?rkevfi);src:url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.eot?rkevfi#iefix) format('embedded-opentype'),url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.ttf?rkevfi) format('truetype'),url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.woff?rkevfi) format('woff'),url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.svg?rkevfi#stamped-font) format('svg');font-weight:400;font-style:normal}.stamped-summary-ratings{width:300px!important;margin-bottom:20px!important;color:#999;font-size:12px;line-height:normal;margin-right:20px;margin-bottom:15px}.summary-rating{margin-bottom:2px}.summary-rating-title{font-size:0!important;width:95px!important;display:inline-block;cursor:pointer}.summary-rating-bar{height:15px!important;vertical-align:middle;width:48%!important;display:inline-block;background:#f0f0f0;border:none;text-align:center;cursor:pointer}.summary-rating-bar>div{font-size:0!important;height:15px;line-height:0;padding:0}.summary-rating-bar-content{background:#ffd200;line-height:normal;display:flex;padding:1px 0 2px;word-wrap:initial;word-break:initial}.summary-rating-count{color:#333!important;width:15%;display:inline-block;text-align:left;padding-left:10px;color:#ccc;font-size:14px;position:absolute}.summary-rating:nth-child(1) .summary-rating-title:before,.summary-rating:nth-child(2) .summary-rating-title:before,.summary-rating:nth-child(3) .summary-rating-title:before,.summary-rating:nth-child(4) .summary-rating-title:before,.summary-rating:nth-child(5) .summary-rating-title:before{font-family:stamped-font!important;font-size:17px;width:200px!important;letter-spacing:-1px;color:#999}.summary-rating:nth-child(1) .summary-rating-title:before{content:'\f005\f005\f005\f005\f005'}.summary-rating:nth-child(2) .summary-rating-title:before{content:'\f005\f005\f005\f005\f006'}.summary-rating:nth-child(3) .summary-rating-title:before{content:'\f005\f005\f005\f006\f006'}.summary-rating:nth-child(4) .summary-rating-title:before{content:'\f005\f005\f006\f006\f006'}.summary-rating:nth-child(5) .summary-rating-title:before{content:'\f005\f006\f006\f006\f006'}.summary-rating-count:before{content:'('}.summary-rating-count:after{content:')'}.summary-rating-title{font-size:0!important;width:95px!important}.stamped-review{border-top:1px solid #eee;margin-bottom:30px;padding-top:25px}.stamped-review-header{font-size:14px;width:100%;line-height:18px}.stamped-review-avatar{float:left;position:relative;float:left;padding:0;margin-right:10px;color:#bbb}.stamped-review[data-verified=buyer] .stamped-review-avatar:before{content:'\e904';font-family:stamped-font;font-size:21px!important;position:absolute;right:-5px;bottom:0;color:#1cc286}.stamped-review-avatar-content{display:table-cell;vertical-align:middle;height:56px;width:55px;font-weight:700;font-size:18px;text-align:center;text-transform:inherit;font-style:initial;margin-right:10px}.stamped-review-header .created,.stamped-review-header-byline .created{float:right!important;color:#999;font-size:12px;font-weight:400}.stamped-review .author{margin-right:7px}.verified-badge{display:block;font-size:12px;white-space:nowrap}.verified-badge .icon{display:none;background:0 0;float:none;width:auto;height:auto;margin-right:-2px}.stamped-review-header .verified-badge[data-type=buyer]:after{content:' Verified Buyer'}.stamped-review-header .review-location{color:#999;font-size:12px;font-weight:400}.stamped-review-header-starratings{font-size:20px;display:inline-block;margin-left:-2px}.fa-star:before,.stamped-fa-star:before{content:'\f005';color:#ffd200;font-family:stamped-font!important;font-size:18px;margin-right:-1px;font-style:normal}.fa-star-o:before,.stamped-fa-star-o:before{content:'\f006';color:#ffd200;font-family:stamped-font!important;font-size:18px;margin-right:-1px;font-style:normal}.review_content_wrapper{padding:5%;padding-top:3px;display:none}.review_content_wrapper.active{display:block}.review_arrow{float:right;padding:10px 0;font-size:180%;font-weight:700}.product-detail{border-top:1px solid #eee;margin-bottom:30px;padding-top:25px}</style>
	<style>
 .stamped-reviews-image {
        height: 145px;
        width: 100px;
        float: left;
        margin-right: 20px;
        display: inline-block;
        vertical-align: top;
        text-align: center;
        position: relative;
        padding-left: 0 !important;
        z-index: 100;
    }

    .stamped-reviews-message-image-block img {
        height: 80px;
        margin: 10px 0px;
        border-radius: 3px;
    }

     .stamped-reviews-image img {
        margin-left: 0 !important;
        margin-right: 10px !important;
  
        padding: 3px;
        border-radius: 5px;
        text-align: center;
    }

	.stamped-products-reviews-title {
        font-style: italic;
    }

    .stamped-reviews-date {
        float: right;
        font-size: 12px;
        color: #999;
    }

     .stamped-pagination {
        font-size: 15px;
        text-align: center;
    }

    span.stamped-pagination-page {
        padding: 3px;
    }

     .stamped-pagination a {
        cursor: pointer;
        padding: 0px;
    }

     #stamped-pagination-next {
        float: none;
        position: inherit;
        margin-left: 5px;
    }

	#stamped-pagination-next a:before {
		content: '>';
	}

     #stamped-pagination-prev {
        float: none;
        position: inherit;
        margin-right: 5px;
    }

	#stamped-pagination-prev a:before {
	    content: '<';
	}

	.stamped-reviews-title-wrapper {
		font-size: 18px;
		font-weight: 600;
		color: #000;
	}

	.stamped-ratings-wrapper {
		outline: none;
	}

    .stamped-ratings-wrapper > div:not(.stamped-reviews-first) {
        position: relative;
        padding-left: 120px;
    }

     .stamped-reviews-date {
        padding-left: 0 !important;
    }

    .stamped-products-reviews-reply {
        background: none;
        padding: 15px;
        margin-top: 15px;
        border-top: 3px solid #eee;
    }

     .stamped-reviews-options ul {
        margin: 0px;
        padding: 0px;
    }
	.stamped-products-reviews-title {
		font-style: italic;
	}
	.stamped-reviews-author {
    	color: #828282;
    	font-weight: 500;
	}
	.stamped-verified-label:after {
        content: ' \e904  Verified Buyer';
        font-family: 'stamped-font', 'Open Sans';
        word-spacing: -5px;
        font-weight: normal;
    }
	.stamped-reviews-container {
		font-size:14px;
		padding: 20px 20px 20px 20px;
		border: 1px solid #e5e5e5;
		border-radius: 3px;
	}
	.stamped-reviews-title{
		font-weight:bold;
	}
	.stamped-reviews-wrapper {
		margin: 20px 0 0;
		overflow: hidden;
	}
	.stamped-review-card {
    		width: 100%;
    		float: left;
  	}
  	.stamped-reviews-message {
  		margin-bottom: 15px;
  	}
  	.stamped-reviews-rating span {
  		font-size: 12px;
  		color: #333;
  		vertical-align: text-bottom;
    	margin-left: 10px;
  	}
  	.stamped-review-title, .stamped-reviews-message {
  		color: #000;
  	}
  	.stamped-review-title {
  		font-weight: 600;
  		font-size: 15px;
  	}
</style>

<?php if(!get_theme_mod('cart_hide_they_about')) { ?>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript">
jQuery('.stamped-reviews-wrapper').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 3000,
     dots: false,
    prevArrow: false,
    nextArrow: false
});
</script>
<?php } ?>

<?php do_action( 'woocommerce_after_cart' ); ?>
