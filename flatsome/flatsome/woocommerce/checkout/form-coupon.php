<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="message-container container medium-text-center">
<a href="https://flagwix.com/delivery-processing-delays-due-to-covid-19/">Delays in Shipping and COVID-19 Statement</a>
</div>
<div class="woocommerce-form-coupon-toggle">
	<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' ); ?>
</div>

<form class="checkout_coupon woocommerce-form-coupon has-border is-dashed" method="post" style="display:none">

	<p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'woocommerce' ); ?></p>
	<div class="coupon">
		<div class="flex-row medium-flex-wrap">
			<div class="flex-col flex-grow">
				<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
			</div>
			<div class="flex-col">
				<button type="submit" class="button expand" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
			</div>
		</div>
	</div>
</form>

<div style="width:100%;display:table">
	<div style="display:table-cell;vertical-align:middle">
		<img src="//s3.amazonaws.com/uoymedia/flame_24.png">
	</div>
	<div style="font-weight:bold;padding-left:5px;font-size:14px">The item you ordered is in high demand. No worries, we have reserved your order.</div>
</div>
<div id="ct836" style="display:block;background:#fff5d2;padding:10px 20px;border:1px solid #fac444;font-size:14px;color:#2c2c2c;font-weight:bold;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; margin:5px 0px 20px 0px">
	Your order is reserved for <span id="time">09:43</span> minutes!
</div>
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
