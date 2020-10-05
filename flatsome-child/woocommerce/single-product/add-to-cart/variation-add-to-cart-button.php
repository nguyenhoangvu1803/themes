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

	


	<?php if ( is_active_sidebar( 'after-add-to-card-custom-content' ) ) { ?>
	    <div class="sidebar-after-add-to-card-custom-content">
	        <?php //dynamic_sidebar('after-add-to-card-custom-content'); ?>
	        <?php 
				ob_start();
				dynamic_sidebar( 'after-add-to-card-custom-content' ); 
				$output = ob_get_contents();
				ob_end_clean();
				echo $output;
	        ?>
	    </div>
	<?php } ?>




  <?php $pieces = rand(5, 15); ?>
  <div class="flag-body" style="font-size: 15px;color: #000;">
    <svg width="39" height="20" viewBox="0 0 39 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px;">
	<path d="M16.3586 2.13796C16.7393 0.869005 17.9073 0 19.2321 0H34.9679C36.9775 0 38.4188 1.93721 37.8414 3.86204L33.6414 17.862C33.2607 19.131 32.0927 20 30.7679 20H15.0321C13.0225 20 11.5812 18.0628 12.1586 16.138L16.3586 2.13796Z" fill="#53A42F"/>
	<path d="M25.5 5L23 12H28.5" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
	<line x1="11.25" y1="3.75" x2="0.75" y2="3.75" stroke="#53A42F" stroke-width="1.5" stroke-linecap="round"/>
	<line x1="9.25" y1="9.75" x2="0.75" y2="9.75" stroke="#53A42F" stroke-width="1.5" stroke-linecap="round"/>
	<line x1="7.25" y1="15.75" x2="0.75" y2="15.75" stroke="#53A42F" stroke-width="1.5" stroke-linecap="round"/>
	</svg>
	Almost gone. <span style="font-weight: 500;">There are only <?php  echo rand(2, 5); ?> left.</span>
  </div>
  <div style="font-size: 13px;color: #4F4F4F;margin-bottom: 20px;">This <?php echo date('F'); ?>, we only do <?php echo $pieces; ?> pieces of this limited edition. <span style="font-weight: 500;color: #000;">Get it before it's gone!</span></div>
  <div class="text-center">
  	<img style="margin-bottom: 22px;" alt="credit cards" src="https://149.28.149.209/wp-content/uploads/2020/09/guaranteed-safe-checkout-single.png">
  	<img src="https://149.28.149.209/wp-content/uploads/2020/09/4-step.png" alt="">
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