<?php
add_action( 'woocommerce_after_checkout_form', 'uoymedia_add_jscript_checkout');

function uoymedia_add_jscript_checkout() {
?>
<!-- Twitter single-event website tag code -->
<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">twttr.conversion.trackPid('o3w3e', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=o3w3e&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
<img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=o3w3e&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
</noscript>
<!-- End Twitter single-event website tag code -->
<?php
}

add_action( 'woocommerce_thankyou', 'uoymedia_conversion_tracking_thank_you_page' );

function uoymedia_conversion_tracking_thank_you_page() {
?>
<!-- Twitter single-event website tag code -->
<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">twttr.conversion.trackPid('o437d', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=o437d&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
<img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=o437d&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
</noscript>
<!-- End Twitter single-event website tag code -->
<?php
}

add_filter( 'manage_edit-shop_order_columns', 'add_payment_shop_order_column',11);
function add_payment_shop_order_column($columns) {
    $reordered_columns = array();    foreach( $columns as $key => $column){
        $reordered_columns[$key] = $column;
        if( $key ==  'order_number' ){
            $reordered_columns['payment_method'] = __( 'Payment','Woocommerce');
        }
    }
    return $reordered_columns;
}// The data of the new custom column in admin order list
add_action( 'manage_shop_order_posts_custom_column' , 'orders_list_column_payment_title', 10, 2 );
function orders_list_column_payment_title( $column, $post_id ){
    if( 'payment_method' === $column ){
        $payment_title = get_post_meta( $post_id, '_payment_method_title', true );
        if( ! empty($payment_title) )
            echo $payment_title;
    }
}

//add_filter( 'woocommerce_cart_shipping_method_full_label', 'bbloomer_remove_shipping_label', 9999, 2 );
   
function bbloomer_remove_shipping_label( $label, $method ) {
    $new_label = preg_replace( '/^.+:/', '', $label );
    return $new_label;
}
/**
 * Hide shipping rates when free shipping is available, but keep "Local pickup" 
 * Updated to support WooCommerce 2.6 Shipping Zones
 */

function hide_shipping_when_free_is_available( $rates, $package ) {
	$new_rates = array();
	foreach ( $rates as $rate_id => $rate ) {
		// Only modify rates if free_shipping is present.
		if ( 'free_shipping' === $rate->method_id ) {
			$new_rates[ $rate_id ] = $rate;
			break;
		}
	}

	if ( ! empty( $new_rates ) ) {
		//Save local pickup if it's present.
		foreach ( $rates as $rate_id => $rate ) {
			if ('Express shipping' === $rate->label ) {
				$new_rates[ $rate_id ] = $rate;
				break;
			}
		}
		return $new_rates;
	}

	return $rates;
}

// add_filter( 'woocommerce_package_rates', 'hide_shipping_when_free_is_available', 10, 2 );

// Disable WooCommerce Ajax Cart Fragments Everywhere
add_action( 'wp_enqueue_scripts', 'uoymedia_disable_woocommerce_cart_fragments', 11 ); 
function uoymedia_disable_woocommerce_cart_fragments() { 
  wp_dequeue_script( 'wc-cart-fragments' ); 
}

// disable_scripts_styles
function uoymedia_disable_scripts_styles() {
	// easy digital downloads
	if (!is_page('happy')) {
		// Judge.me
		wp_dequeue_script('judgeme_cdn');
		wp_dequeue_style('judgeme_cdn');
		remove_filter('script_loader_tag', array('JGM_Initilizer', 'async_load_judgeme_cdn_js'));
	}
}
add_action('wp_enqueue_scripts', 'uoymedia_disable_scripts_styles', 100);
// Order related by sale
add_filter( 'woocommerce_output_related_products_args', 'uoy_related_products_args', 20 );
function uoy_related_products_args( $args ) {
	$args['orderby'] = 'sales'; 
	return $args;
}
// Add custom Theme Functions here
add_filter( 'woocommerce_checkout_fields' , 'woo_remove_billing_checkout_fields', 1111 );
/**
 * Remove unwanted checkout fields
 *
 * @return $fields array
*/
function woo_remove_billing_checkout_fields( $fields ) {
  
  if( woo_cart_virtual_downloadable_product_only() == true ) {
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
    unset($fields['billing']['billing_email']);
    unset($fields['order']['order_comments']);
  }
  
  return $fields;
}
/**
 * Check if the cart contains virtual/downloadable product only
 *
 * @return bool
*/
function woo_cart_virtual_downloadable_product_only() {
  
  global $woocommerce;
  // By default, virtual/downloadable product only
  $virtual_downloadable_products_only = true;
  // Get all products in cart
  $products = $woocommerce->cart->get_cart();
  // Loop through cart products
  foreach( $products as $product ) {
	  // Get product ID
	  $product_id = $product['product_id'];
	  // is variation downloadable
	  $is_downloadable = $product['data']->downloadable;
	  // is variation virtual
	  $is_virtual = $product['data']->virtual ;
	  // Update $virtual_downloadable_products_only if product is not virtual or downloadable and exit loop
	  if( $is_virtual == 'no' && $is_downloadable == 'no' ){
		  $virtual_downloadable_products_only = false;
		  break;
	  }
  }
  return $virtual_downloadable_products_only;
}

function uoymedia_wc_discount_total() {
  global $woocommerce;
  $discount_total = 0;
  $regular_total = 0;
  foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values) {
    $_product = $values['data'];
    $regular_price = $_product->get_regular_price();
    $regular_total += $regular_price;
    if ( $_product->is_on_sale() ) {
      $sale_price = $_product->get_sale_price();
      $discount = ($regular_price - $sale_price) * $values['quantity'];
      $discount_total += $discount;
    }
  }
          
  if ( $discount_total > 0 ) {
  echo '<tr class="cart-total-custom order-regular">
  <th>'. __( 'Regular Price', 'woocommerce' ) .'</th>
  <td data-title=" '. __( 'Regular Price', 'woocommerce' ) .' "><del>'
  . wc_price( $regular_total ) .'</del></td>
  </tr>';
  echo '<tr class="cart-total-custom order-save">
  <th>'. __( 'You Saved', 'woocommerce' ) .'</th>
  <td data-title=" '. __( 'You Saved', 'woocommerce' ) .' ">'
  . wc_price( $discount_total + $woocommerce->cart->discount_cart ) .'</td>
  </tr>';
  }
}

// Hook our values to the Basket and Checkout pages
add_action( 'woocommerce_cart_totals_after_order_total', 'uoymedia_wc_discount_total', 99);
add_action( 'woocommerce_review_order_after_order_total', 'uoymedia_wc_discount_total', 99);
// add_filter('woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text');
 
function woo_custom_cart_button_text() {
  return __('Buy It Now', 'woocommerce');
}
// Display the selected variation discounted price with the discounted percentage for variable products
add_filter( 'woocommerce_format_sale_price', 'woocommerce_custom_sales_price', 10, 3 );
function woocommerce_custom_sales_price( $price, $regular_price, $sale_price ) {
  global $product;

  // Just for variable products on single product pages
  if( $product instanceof WC_Product && $product->is_type('variable') && is_product() ) {
    // $currency_symbol = get_woocommerce_currency_symbol();
    // $saved = $regular_price - $sale_price;
    $percentage = ( $regular_price - $sale_price ) / $regular_price * 100;
    return '
        <ins>' . wc_price( $sale_price ) . '</ins>
        <del>' . wc_price( $regular_price ) . '</del>
        <span class="product_saving_amount"> You saved ' . round($percentage) . '% this time</span>
    ';
  }

  return $price;
}
// Add custom Theme Functions here
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'filter_dropdown_option_html', 12, 2 );
function filter_dropdown_option_html( $html, $args ) {
    $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' );
    $show_option_none_html = '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

    $html = str_replace($show_option_none_html, '', $html);

    return $html;
}

add_action( 'woocommerce_before_add_to_cart_quantity', 'uoy_echo_qty_front_add_cart' );
 
function uoy_echo_qty_front_add_cart() {
 echo '<div class="qty">Quantity: </div>'; 
}

add_filter('woocommerce_show_variation_price',      function() { return TRUE;});


// function 'get_post_id_by_meta_key_and_value' found at https://gist.github.com/feedmeastraycat/3065969
function get_post_id_by_meta_key_and_value( $key, $value ) {
	global $wpdb;
	$meta = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->postmeta." WHERE meta_key=%s AND meta_value=%s", $key, $value ) );
	if (is_array( $meta ) && !empty( $meta ) && isset( $meta[0]) ) {
		$meta = $meta[0];
	}		
	if ( is_object( $meta ) ) {
		return $meta->post_id;
	}
	else {
		return false;
	}
}
// add_filter( 'woocommerce_shortcode_order_tracking_order_id', 'search_by_custom_order_number', 99);
function search_by_custom_order_number( $order_id ) {
    $order_id = preg_replace('/\D/', '', $order_id);
	$order_id = get_post_id_by_meta_key_and_value( '_alg_wc_custom_order_number', $order_id );
	return $order_id;
}

/** 
 * Change the Description tab link text for single products
 */
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
  $tabs['additional_information']['title'] = __( 'Shipping information' );  // Rename the additional information tab
  return $tabs;
}

function fix_prl_url() {  
  if ( function_exists( 'woocommerce_prl_add_link_track_param' ) ) {    
    add_filter( 'post_type_link', 'woocommerce_prl_add_link_track_param' ); 
  }
}
add_action( 'init', 'fix_prl_url' );

add_filter( 'woocommerce_prl_locations', 'sw_wc_prl_add_custom_homepage_location' );
function sw_wc_prl_add_custom_homepage_location( $locations ) { 
  class WC_PRL_Location_Homepage extends WC_PRL_Location {  
    /*
     *
     * Constructor.    
     */   
    public function __construct() {   
      $this->id       = 'homepage';     
      $this->title    = __( 'Homepage', 'woocommerce-product-recommendations' );   
      $this->defaults = array(  
          'engine_type' => array( 'cart' ),       
          'priority'    => 10,        
          'args_number' => 0      
      );
      parent::__construct();    
    } 
    /*
     *
     * Check if the current location page is active.     
     *
     * @return boolean
     */
    public function is_active() {     
      return is_front_page();   
    }   
    /*
     *
     * Setup all supported hooks based on the location id.
     *
     * @return void
     */
    protected function setup_hooks() {   

        $this->hooks = array( 

          'loop_end' => array(

              'id' => 'on_home_page', // Unique location ID.
              'label'    => __( 'Page On Front', 'woocommerce-product-recommendations' ), // Label to show in UI.
              'priority' => 10    

          )

        );    
    } 
  } 

  array_unshift( $locations, 'WC_PRL_Location_Homepage');  
  return $locations;

}

add_filter( 'woocommerce_prl_recommendations_container_classes', 'sw_prl_add_container_class', 10, 2 );
function sw_prl_add_container_class( $classes, $deployment ) {
  if ( 'woocommerce_after_single_product' === $deployment->get_hook() || 'loop_end' === $deployment->get_hook() ) {
    $classes[] = 'container';
  }
  return $classes;
}
