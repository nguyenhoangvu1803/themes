<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wrapper_classes = array();
$row_classes     = array();
$main_classes    = array();
$sidebar_classes = array();

$layout = get_theme_mod( 'checkout_layout' );

if ( ! $layout ) {
	$sidebar_classes[] = 'has-border';
}

if ( $layout == 'simple' ) {
	$sidebar_classes[] = 'is-well';
}

$wrapper_classes = implode( ' ', $wrapper_classes );
$row_classes     = implode( ' ', $row_classes );
$main_classes    = implode( ' ', $main_classes );
$sidebar_classes = implode( ' ', $sidebar_classes );


if ( ! fl_woocommerce_version_check( '3.5.0' ) ) {
	wc_print_notices();
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

// Social login.
if ( flatsome_option( 'facebook_login_checkout' ) && get_option( 'woocommerce_enable_myaccount_registration' ) == 'yes' && ! is_user_logged_in() ) {
	wc_get_template( 'checkout/social-login.php' );
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout <?php echo esc_attr( $wrapper_classes ); ?>" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="row pt-0 <?php echo esc_attr( $row_classes ); ?>">
		<div class="large-7 col  <?php echo esc_attr( $main_classes ); ?>">

			<h2>Checkout</h2>

			<div style="width:100%;display:table;margin-bottom:15px;">
				<div style="font-weight:600;color:#000;">
					<svg width="26" height="16" viewBox="0 0 26 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px;">
					<path d="M21.125 15.9375C19.7437 15.9375 18.6875 14.8813 18.6875 13.5C18.6875 12.1187 19.7437 11.0625 21.125 11.0625C22.5063 11.0625 23.5625 12.1187 23.5625 13.5C23.5625 14.8813 22.5063 15.9375 21.125 15.9375Z" fill="#EB3939"/>
					<path d="M8.125 15.9375C6.74375 15.9375 5.6875 14.8813 5.6875 13.5C5.6875 12.1187 6.74375 11.0625 8.125 11.0625C9.50625 11.0625 10.5625 12.1187 10.5625 13.5C10.5625 14.8813 9.50625 15.9375 8.125 15.9375Z" fill="#EB3939"/>
					<path d="M25.8375 8.1375L22.5875 4.075C22.425 3.83125 22.1812 3.75 21.9375 3.75H17.875V1.3125C17.875 0.825 17.55 0.5 17.0625 0.5H4.0625C3.575 0.5 3.25 0.825 3.25 1.3125V2.125H4.0625C4.55 2.125 4.875 2.45 4.875 2.9375C4.875 3.425 4.55 3.75 4.0625 3.75H3.25H2.4375C1.95 3.75 1.625 4.075 1.625 4.5625C1.625 5.05 1.95 5.375 2.4375 5.375H3.25H4.875C5.3625 5.375 5.6875 5.7 5.6875 6.1875C5.6875 6.675 5.3625 7 4.875 7H3.25H0.8125C0.325 7 0 7.325 0 7.8125C0 8.3 0.325 8.625 0.8125 8.625H3.25V13.5C3.25 13.9875 3.575 14.3125 4.0625 14.3125H4.14375C4.0625 14.0688 4.0625 13.7437 4.0625 13.5C4.0625 11.225 5.85 9.4375 8.125 9.4375C10.4 9.4375 12.1875 11.225 12.1875 13.5C12.1875 13.7437 12.1875 14.0688 12.1062 14.3125H17.0625H17.1438C17.0625 14.0688 17.0625 13.7437 17.0625 13.5C17.0625 11.225 18.85 9.4375 21.125 9.4375C23.4 9.4375 25.1875 11.225 25.1875 13.5C25.1875 13.7437 25.1875 14.0688 25.1062 14.3125H25.1875C25.675 14.3125 26 13.9875 26 13.5V8.625C26 8.4625 25.9187 8.3 25.8375 8.1375Z" fill="#EB3939"/>
					</svg>
					The item you ordered is in high demand. <span style="font-weight: 400;">No worries, we have reserved your order.</span>
				</div>
			</div>

			<div id="ct836" style="display:block;background:#FFF7E1;padding:13px 20px;font-size:14px;color:#000;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px; margin:5px 0px 20px 0px">
				Your order is reserved for <span id="time" style="background:#FFE4BC;border: 1px solid #F0C27C;border-radius:3px;font-weight:500;padding:4px 8px;" >09:43</span> minutes!
			</div>

			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div id="customer_details">
					<div class="clear">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>

					<div class="clear">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>

		</div>

		<div class="large-1 col"></div>

		<div class="large-4 col">
			<?php flatsome_sticky_column_open( 'checkout_sticky_sidebar' ); ?>

					<div class="col-inner <?php echo esc_attr( $sidebar_classes ); ?>">
						<div class="checkout-sidebar sm-touch-scroll">
							<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>

							<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

							<div id="order_review" class="woocommerce-checkout-review-order">
								<?php do_action( 'woocommerce_checkout_order_review' ); ?>
							</div>

							<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
						</div>
					</div>

			<?php flatsome_sticky_column_close( 'checkout_sticky_sidebar' ); ?>
		</div>

	</div>
</form>

<script>
	function crC(e, t, n) {
		if (n) {
			var r = new Date;
			r.setTime(r.getTime() + 60 * n * 1e3);
			var o = "; expires=" + r.toUTCString()
		} else o = "";
		document.cookie = e + "=" + t + o + "; path=/"
	}

function rdC(e) {
	for (var t = e + "=", n = document.cookie.split(";"), r = 0; r < n.length; r++) {
		for (var o = n[r];
			" " == o.charAt(0);) o = o.substring(1, o.length);
		if (0 == o.indexOf(t)) return o.substring(t.length, o.length)
	}
	return null
}

function eSC(e) {
	crC(e, "", -1)
}

function stTM(e, t, n) {
	var r, o, i;

	function a() {
		r = t - ((Date.now() - e) / 1e3 | 0), i = r % 60 | 0, o = (o = r / 60 | 0) < 10 ? "0" + o : o, i = i < 10 ? "0" + i : i, n.textContent = o + ":" + i, r <= 0 && (clearInterval(c), document.getElementById("ct836").innerHTML = "Order reservation ended.", e = Date.now() + 1e3)
	}
	a();
	var c = setInterval(a, 1e3)
}
var e = 600,
	t = Date.now(),
	s = rdC("pRtC");
s ? t < s ? e = (s - t) / 1e3 : (eSC("pRtC"), crC("pRtC", Date.now() + 1e3 * e, e + 1)) : crC("pRtC", Date.now() + 1e3 * e, e + 1), display = document.querySelector("#time"), stTM(t, e, display); 

jQuery("#billing_phone").attr("placeholder", "Phone");
</script>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
