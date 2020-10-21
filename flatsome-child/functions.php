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

// Removes Order Notes Title - Additional Information & Notes Field
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );
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
  unset($fields['order']['order_comments']);

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
  if( $product instanceof WC_Product && $product->is_type('variable') && is_product() && is_numeric($regular_price) && is_numeric($sale_price) ) {
    // $currency_symbol = get_woocommerce_currency_symbol();
    // $saved = $regular_price - $sale_price;
    $percentage = ($regular_price - $sale_price ) / $regular_price * 100;
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
  // Rename the additional information tab
  $tabs['additional_information']['title'] = __( 'Shipping information' );
  $tabs['additional_information']['callback'] = 'woo_content_shipping_information';
  $reviews_count = get_option('judgeme_widget_all_reviews_count');
  // Adds reviews tab
  $tabs['reviews_tab'] = array(
      'title'     => __( 'Reviews <span>' . $reviews_count['all_reviews_count'] . '</span><div class="product-star"><span class="star"><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span></span></div>', 'woocommerce' ),
      'priority'  => 30,
      'callback'  => 'woo_new_product_tab_content'
  );
  $id = get_the_ID();
  if(has_term( 'Truck Tailgate Wrap', 'product_cat', $id )) {
      $tabs['woo_truck_tailgate_decal'] = array(
      'title'   => __( 'Application Instructions', 'woocommerce' ),
      'priority'  => 10,
      'callback'  => 'woo_truck_tailgate_decal_tab_content'
    );
  }
  return $tabs;
}
function woo_content_shipping_information() {
  if ( is_active_sidebar( 'shipping-information-content' ) ) {
    dynamic_sidebar( 'shipping-information-content' ); 
  }
}

function woo_new_product_tab_content() {
  // The new tab content
  ?>
    <div id="beforereview">
        <?php echo do_shortcode("[jgm-all-reviews]"); ?>
    </div>
  <?php
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

add_filter( 'woocommerce_thankyou_order_received_text', 'filter_woocommerce_thankyou_order_received_text', 10, 2 );
// define the woocommerce_thankyou_order_received_text callback
function filter_woocommerce_thankyou_order_received_text( $var, $order ) {
    return 'Order Summary';
};

/* CUSTOM CSS */
function uoy_custom_css() {
  ob_start();
?>
  <style id="uoy-custom-css" type="text/css">

      <?php
        $color_primary = get_theme_mod('color_primary', Flatsome_Default::COLOR_PRIMARY );
        if($color_primary && $color_primary !== Flatsome_Default::COLOR_PRIMARY){
      ?>
          /* COLOR */
          .color-primary, .fl-wrap.fl-is-active>label[for]:first-child, .fl-wrap.fl-has-focus>label[for]:first-child, form .woocommerce-form-row:hover label, a.lost_password, .lost_password a, .nav-right>li.cart-item>a, .product-info .posted_in a, ul.product-tabs li > a, ul.product-tabs .star
          {color: <?php echo $color_primary; ?>;}

          /* BACKGROUND-COLOR */
          .checkout_coupon input[type='submit'].is-form, .slider .flickity-prev-next-button:hover svg
          {background-color: <?php echo $color_primary; ?>;}

          /* BORDER COLOR */
          .flex-control-thumbs li img.flex-active, .slider-nav li.active img, .product-thumbnails.slider .is-selected.is-nav-selected, .fl-wrap.fl-is-active > input, .fl-wrap.fl-is-active > textarea, .fl-wrap.fl-has-focus > input , .fl-wrap.fl-has-focus > textarea, form .woocommerce-form-row:hover > input, input[type='email']:hover,nput[type='email']:focus,
          input[type='date']:hover,input[type='date']:focus,
          input[type='search']:hover,input[type='search']:focus,
          input[type='number']:hover,input[type='number']:focus,
          input[type='text']:hover,input[type='text']:focus,
          input[type='tel']:hover,input[type='tel']:focus,
          input[type='url']:hover,input[type='url']:focus,
          input[type='password']:hover,input[type='password']:focus,
          textarea:hover,textarea:focus,
          select:hover,select:focus,
          .select-resize-ghost:hover,.select-resize-ghost:focus,
          .select2-container .select2-choice:hover,.select2-container .select2-choice:focus,
          .select2-container .select2-selection:hover,.select2-container .select2-selection:focus
          {border-color: <?php echo $color_primary; ?>;}
      <?php } ?>

      <?php
        $color_success = get_theme_mod( 'color_success' , Flatsome_Default::COLOR_SUCCESS );
        if( $color_success && $color_success !== Flatsome_Default::COLOR_SUCCESS ){
      ?>
          /* COLOR */
          .cart-total-custom.order-save, .cart-total-custom.order-save .amount, .cart-total-custom.order-save .amount, .shop_table .order-save th {
            color: <?php echo $color_success;?>;
          }

          /* BACKGROUND-COLOR */
          [data-icon-label]:after, ul.product-tabs li > a > span{background-color: <?php echo $color_success;?> !important;}
      <?php }?>

  </style>
<?php
  $buffer = ob_get_clean();
  echo flatsome_minify_css($buffer);
}
add_action( 'wp_head', 'uoy_custom_css', 101 );


// Add Sidebar Area
function uoy_sidebar_init() {

  register_sidebar( array(
    'name'          => __( 'After Add To Card Custom Content', 'flatsome' ),
    'id'            => 'after-add-to-card-custom-content',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<span class="widget-title after-add-to-card-custom-content">',
    'after_title'   => '</span>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Header Right Checkout', 'flatsome' ),
    'id'            => 'header-right-checkout',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<span class="widget-title header-right-checkout">',
    'after_title'   => '</span>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Shipping Information Content', 'flatsome' ),
    'id'            => 'shipping-information-content',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<span class="widget-title shipping-information-content">',
    'after_title'   => '</span>',
  ) );

}
add_action( 'widgets_init', 'uoy_sidebar_init', 11 , 1 );


// add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );

function uoy_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'uoy_excerpt_more', 11, 1 );

require 'inc/myaccount.php';

// Remove coupon on top checkout
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

// Add Coupon to the woocommerce_review_order_before_order_total action
function action_woocommerce_review_order_before_order_total(  ) { 
  ?>
    <?php if ( wc_coupons_enabled() ) { ?>
      <tr class="coupon_checkout">
        <td colspan="2">
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
        </td>
      </tr>
    <?php } ?>
  <?php
}; 
add_action( 'woocommerce_review_order_before_order_total', 'action_woocommerce_review_order_before_order_total', 11, 0 ); 

// Add js for product gallery thumbs when click "add to cart" show lightbox
function include_custom_slide_flickity() {
  wp_enqueue_script('flatsome-child-js', get_stylesheet_directory_uri() .'/assets/js/flatsome-child.js', array('flatsome-theme-woocommerce-js'), null, true);
}
add_action('wp_enqueue_scripts', 'include_custom_slide_flickity');

// Add pagination to product header title 
if ( ! function_exists( 'add_pagination_category_title' ) ) {
  /**
   * Add Pagination
   */
  function add_pagination_category_title () {
    wc_get_template_part( 'loop/pagination' );
  }
}
add_action( 'flatsome_category_title_alt', 'add_pagination_category_title', 25 );

// Add woocommerce_after_shop_loop start wrapper 
if ( ! function_exists( 'woocommerce_after_shop_loop_start_wrapper' ) ) {
  /**
   * Add Pagination
   */
  function woocommerce_after_shop_loop_start_wrapper () {
    ?> 
      <div class="pagination-wrapper text-right">
    <?php
  }
}
add_action( 'woocommerce_after_shop_loop', 'woocommerce_after_shop_loop_start_wrapper', 1 );

// Add show result to before pagination shop category end loop 
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 5 );

// Add woocommerce_after_shop_loop end wrapper 
if ( ! function_exists( 'woocommerce_after_shop_loop_end_wrapper' ) ) {
  /**
   * Add Pagination
   */
  function woocommerce_after_shop_loop_end_wrapper () {
    ?> 
      </div>
    <?php
  }
}
add_action( 'woocommerce_after_shop_loop', 'woocommerce_after_shop_loop_end_wrapper', 20 );

function my_template_page_info_redirect(){
   //pages you want to make true, ex. is_shop()
   $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
   if(     stripos($url_path, 'privacy-policy')!== false
        || stripos($url_path, 'shipping-information')!== false
        || stripos($url_path, 'return-refund')!== false
        || stripos($url_path, 'terms-of-service')!== false
     ) {
    load_template(get_theme_file_path().'/page-info.php');
     exit();
   }
}
add_action('template_redirect','my_template_page_info_redirect');

// Add Description to [ux_product_categories]
function add_description_to_ux_product_categories($category) {
  $html = '<div class="description">' . $category->description . '</div>';
  $html .= '<span>Browse This Category</span>';
  echo $html;
}
add_action('woocommerce_after_subcategory_title','add_description_to_ux_product_categories');

/**
 * Redirect users after add to cart.
 */
function redirect_card_page_after_add_to_cart( $url ) {

  $url = wc_get_cart_url();

  return $url;

}
add_filter( 'woocommerce_add_to_cart_redirect', 'redirect_card_page_after_add_to_cart' );

function woo_truck_tailgate_decal_tab_content() {
    ?>
    <style media="screen">
        .truck_tailgate_decal_tab_content strong, .truck_tailgate_decal_tab_content h2, .truck_tailgate_decal_tab_content h3 {
            font-weight: bold;
        }
    </style>
    <div class="truck_tailgate_decal_tab_content">

        <ol>
            <li>
                <p>
                    <strong>Preparation:</strong>
                </p>
               <p>A spray bottle with detergent water, lint-free towel or cloth, razor knife or scissors, squeegee - felt-edge. </p>
                <p><strong>Attention:</strong></p>
                <ul>
                    <li>The optimum temperature range for decal adhesion is between 70º to 80º F with low levels of humidity, away from direct sunlight. </li>
                    <li>We recommend do the installation with the tailgate off and laying flat. </li>
                    <li>Please allow 24 hours for the vinyl decals to completely dry and properly adhere to the tailgate. Do not get the vinyl decals wet during this time.</li>
                    <li>Try not to unroll or place the film on the floor, as this will leave dust and debris on the film, causing scratches when applying with a squeegee.</li>
                </ul>
            </li>
            <li>
                <p><strong>Application Instructions:</strong></p>
                <p>Please read instructions first before you install so you get an idea of what the steps are and make no mistakes.</p>
                <ul style="list-style:none;margin-left:0">
                    <li><strong>Step 1:</strong> Cleaning the surface to remove all grease, wax, tar, dirt and dry with a lint-free towel/cloth. Make sure there is nothing hindering your application.</li>
                    <li><strong>Step 2:</strong> Plan vinyl wrap placement by laying your film (with the liner still on) on the tailgate to determine a good placement for your decal. </li>
                    <li><strong>Step 3:</strong> Use detergent water to spray your tailgate, ensuring that the entire area is wet.</li>
                    <li><strong>Step 4:</strong> Remove the film from the liner and place it on the wet tailgate. Slide the decal around in order to get a good level placement on the tailgate. Just keep the surface wet so that you can position it correctly. </li>
                    <li><strong>Step 5:</strong> Use firm pressure to adhere the vinyl to the surface. The vinyl will quickly adhere to the vehicle as the moisture is removed so be sure it is positioned correctly. </li>
                    <li><strong>Step 6:</strong> Gently blot the excess moisture and bubbles from the area with a squeegee and make several more gentle passes with your thumbs until there is no more moisture coming out from under the vinyl decal. </li>
                    <li><strong>Step 7:</strong> Slowly cut along the edges of the vinyl and remove any excess vinyl. </li>
                </ul>
            </li>
        </ol>
        <h2>YOU ARE NOW DONE!</h2>
    </div>
    <?php
}