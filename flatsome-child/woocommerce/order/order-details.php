<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited

echo "<pre>";
print_r($order['total']);
print_r($order);
echo "</pre>";

function filter_woocommerce_get_order_item_totals( $array, $order, $b ) {
	$ar = [];
	$ar['cart_subtotal']['value'] = wc_price($order->get_subtotal());
	$ar['cart_subtotal']['label'] = 'Sub Total';

	$ar['shipping']['value'] = '<div class="myaccount__total--shipping">'.$order->get_shipping_to_display().'</div>';
	$ar['shipping']['label'] = 'Shipping';

	$ar['tax']['label']  = 'Tax';
	$ar['tax']['value']  = wc_price($order->get_tax_totals());

	$ar['payment_method']['label']  = 'Payment Method';
	$ar['payment_method']['value']  = $array['payment_method']['value'];

	$ar['refund']['label']  = 'Refund';
	$ar['refund']['value']  = wc_price($order->get_total_refunded());

	$ar['order_total']['label']  = 'Total';
	$ar['order_total']['value']  = $array['order_total']['value'];
	// echo '<pre>';
	// 		print_r($order);
	// 		echo '</pre>';
		return $ar;
};

// add the filter
add_filter( 'woocommerce_get_order_item_totals', 'filter_woocommerce_get_order_item_totals', 10, 3 );
if ( ! $order ) {
	return;
}
?>
<div class="myaccount__order-detail">
	<div class="myaccount__order__id">
		<label class="myaccount__order--label"><?php esc_html_e('ORDER ID', 'woocommerce') ?></label>
		<h4 class="myaccount__order--value"><?php echo $order->get_order_number() ?></h4>
	</div>
	<div class="myaccount__order__date">
		<label class="myaccount__order--label"><?php esc_html_e('DATE PLACED', 'woocommerce') ?></label>
		<h4 class="myaccount__order--value"><?php echo wc_format_datetime( $order->get_date_created(), 'M d, Y' ) ?></h4>
	</div>
	<div class="myaccount__order__tracking">
		<label class="myaccount__order--label"><?php esc_html_e('STATUS', 'woocommerce') ?></label>
		<h4 class="myaccount__order--value myaccount__order__status status-<?php echo sanitize_title(strtolower($order->status)) ?>"><?php echo wc_get_order_status_name( $order->get_status() ) ?></h4>
	</div>
</div>
<?php
$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section>
	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

  <div class="myaccountorder">
    <div class="myaccountorder__block">
      <div class="myaccountorder__block__list myaccount__page__list">
				<div class="myaccount__page__list--title">
					<h3 class="myaccount__page--subtitle"><?php esc_html_e( 'Order details', 'woocommerce' ); ?></h3>
				</div>
        <table class="myaccount__page__list--table woocommerce-table woocommerce-table--order-details shop_table order_details">

      		<thead>
      			<tr>
      				<th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
      				<th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
      			</tr>
      		</thead>

      		<tbody>
      			<?php
      			do_action( 'woocommerce_order_details_before_order_table_items', $order );

      			foreach ( $order_items as $item_id => $item ) {
      				$product = $item->get_product();

      				wc_get_template(
      					'order/order-details-item.php',
      					array(
      						'order'              => $order,
      						'item_id'            => $item_id,
      						'item'               => $item,
      						'show_purchase_note' => $show_purchase_note,
      						'purchase_note'      => $product ? $product->get_purchase_note() : '',
      						'product'            => $product,
      					)
      				);
      			}

      			do_action( 'woocommerce_order_details_after_order_table_items', $order );
      			?>
      		</tbody>

      		<tfoot>
      			<?php

      			foreach ( $order->get_order_item_totals() as $key => $total ) {
      				?>
      					<tr>
      						<th scope="row" class="order_total <?php echo $key ?>"><?php echo esc_html( $total['label'] ); ?></th>
      						<td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
      					</tr>
      					<?php
      			}
      			?>

      			<?php if ( $order->get_customer_note() ) : ?>
      				<tr>
      					<th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
      					<td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
      				</tr>
      			<?php endif; ?>
      		</tfoot>
      	</table>
      </div>
    </div>
		<div class="myaccount__order--again">
			<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
		</div>
  </div>


	<?php
	if ( $show_customer_details ) {
		wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
	}
	?>

</section>

<?php
