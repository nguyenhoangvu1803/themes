<?php
/**
 * Additional Information tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/additional-information.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional information', 'woocommerce' ) );

?>

<?php if ( $heading ) : ?>
	<h2><?php echo esc_html( $heading ); ?></h2>
<?php endif; ?>

<?php // do_action( 'woocommerce_product_additional_information', $product ); ?>
<style type="text/css"> table.premium-shipping, table.premium-shipping td, table.premium-shipping th{border: 1px solid black}table.premium-shipping td{padding: 0 10px}</style><p>Thank you for visiting and shopping at <b style="font-weight: bold;">Flagwix.com</b>. Please see details below for the shipping information.</p><ul> <li><b style="font-weight: bold;">Processing Time:</b> All orders are processed within 5 - 7 business days.It takes 1 - 3 days to ship your order to our warehouse, put your name and address on it and ship out.</li><li><b style="font-weight: bold;">Shipping Time:</b> You will receive your order from 7 – 12 business days (depends on the destination) from the date that it is shipped out, not the date when the order is placed. <br/>If we are experiencing a high volume of orders, shipments may be delayed by a few days. Please allow additional days in transit for delivery. If there will be a significant delay in shipment of your order, we will contact you via email.</li><li><b style="font-weight: bold;">Shipping Cost:&nbsp;</b> <ul> <li>Order over $99 for our <b style="font-weight: bold;">FREE SHIPPING</b></li><li>The Standard shipping price is $6.99.</li></ul> </li><li><b style="font-weight: bold;">Tracking Number:</b> Once your order has left our warehouse, we will send you the tracking number with the confirmation email so that you can track the package online.</li><li><b style="font-weight: bold;">Return & Exchange:</b> If for some reasons you are not happy with your purchase, we will happily work with you to correct the problems. Items can be return/exchange and get Refund within 30 days of delivery date. (Please check our <b style="font-weight: bold;">Return & Exchange Policy</b>).</li><li><b style="font-weight: bold;">If you have any other queries, please feel free to email us.</b></li></ul>