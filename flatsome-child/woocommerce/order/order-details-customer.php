<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;
function filter_woocommerce_order_formatted_billing_address( $array, $order ) {
    // make filter magic happen here...
    $array['first_name'] = $array['first_name'] ? '<b>'.$array['first_name'].'</b>': '';
    $array['last_name'] = $array['last_name'] ? '<b>'.$array['last_name'].'</b>' : '';
    return $array;
};

// add the filter
add_filter( 'woocommerce_order_formatted_billing_address', 'filter_woocommerce_order_formatted_billing_address', 10, 3 );
function filter_woocommerce_order_formatted_shipping_address( $array, $order ) {
    // make filter magic happen here...
    $array['first_name'] = $array['first_name'] ? '<b>'.$array['first_name'].'</b>': '';
    $array['last_name'] = $array['last_name'] ? '<b>'.$array['last_name'].'</b>' : '';
    return $array;
};

// add the filter
add_filter( 'woocommerce_order_formatted_shipping_address', 'filter_woocommerce_order_formatted_shipping_address', 10, 3 );
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<div class="myaccount__page__list myaccountorder__address">
  <div class="myaccount__page__list--title">
    <h3 class="myaccount__page--subtitle pt-0"><?php esc_html_e( 'Delivery Address', 'woocommerce' ); ?></h3>
  </div>
<div class="myaccount__page__list--column">

<section class="myaccount__page__list">

	<h2 class="myaccount__page--small-title"><?php esc_html_e( 'Billing Address', 'woocommerce' ); ?></h2>

	<address>
		<?php echo html_entity_decode(wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) ) )); ?>

		<?php if ( $order->get_billing_phone() ) : ?>
			<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
		<?php endif; ?>

		<?php if ( $order->get_billing_email() ) : ?>
			<p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
		<?php endif; ?>
	</address>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
</section>
<?php if ( $show_shipping ) : //$show_shipping?>
  <section class="myaccount__page__list">


  <div class="myaccount__page__list">
    <h2 class="myaccount__page--small-title"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>
    <address>
      <?php echo html_entity_decode(wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) )); ?>
    </address>
  </div><!-- /.col-2 -->
</section>


<?php endif; ?>

</div>
