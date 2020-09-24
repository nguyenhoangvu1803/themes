<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>

	<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <?php $pieces = rand(5, 15); ?>
  <div class="flag-body" style="font-size: 15px;color: #000;">
    <img src="<?php echo get_template_directory_uri() . '/assets/img/almost.svg';?>" alt="" /><span style="font-weight: 400;">Almost gone.</span> <span style="font-weight: 500;">There are only <?php  echo rand(2, 5); ?> left.</span>
  </div>
  <div style="font-size: 13px;color: #4F4F4F;">This <?php echo date('F'); ?>, we only do <?php echo $pieces; ?> pieces of this limited edition. <span style="font-weight: 500;color: #000;">Get it before it's gone!</span></div>
  <div>
  <img  alt="credit cards" src="https://flagwix.com/wp-content/uploads/2020/09/checkout-opt.png">
  <img src="https://flagwix.com/wp-content/uploads/2020/09/product.jpg">
  </div>
  <script>
		function getRandomInt(max) {
		return Math.floor(Math.random() * Math.floor(max));
	  }
		function createCookie(name, value, days) {
		var expires;

		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();
		} else {
			expires = "";
		}
		document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
	}

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

	function eraseCookie(name) {
		createCookie(name, "", -1);
	}
  var numavailable = readCookie('sk-<?php echo($product->id) ?>');
	var $ = jQuery;
  if(numavailable){
    $('#num-available-<?php  echo($product->id) ?>').html(numavailable);
  } else {
    numavailable= getRandomInt(10)+5;
    peopleavailable=numavailable+getRandomInt(10)+5;
    createCookie('sk-<?php  echo($product->id) ?>',numavailable,5);
    createCookie('skpeople-<?php  echo($product->id) ?>',peopleavailable,5);
    $('#num-available-<?php  echo($product->id) ?>').html(numavailable);
  }
  </script>