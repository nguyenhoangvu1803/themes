<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward">
  <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="18" height="18" style="margin-bottom: -2px;" viewBox="0 0 8 8">
    <path d="M3 0c-1.1 0-2 .9-2 2v1h-1v4h6v-4h-1v-1c0-1.1-.9-2-2-2zm0 1c.56 0 1 .44 1 1v1h-2v-1c0-.56.44-1 1-1z" transform="translate(1)"></path>
  </svg>
	<?php esc_html_e( ' Secure Checkout', 'woocommerce' ); ?>
</a>
