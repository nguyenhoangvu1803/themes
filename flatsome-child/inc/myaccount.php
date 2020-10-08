<?php
function masterScripts() {
  // wp_enqueue_style( 'vendor-style', $urlObj->styleUrl('vendor', $useMin), array(), null );
  $time = time();
  wp_enqueue_style( 'main-style', get_stylesheet_directory_uri().'/dist/min/style.min.css?nocache='.$time, array(), null );

  // wp_enqueue_script( 'vendor-script', $urlObj->scriptUrl('vendor', $useMin), array('jquery'), null, true );
  wp_enqueue_script( 'main-script', get_stylesheet_directory_uri().'/dist/min/script.min.js?nocache='.$time, array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'masterScripts' );

add_filter( 'woocommerce_account_menu_items', 'custom_my_menu_items', 99, 1 );

function custom_my_menu_items( $items ) {
  $new_items = array(
       'dashboard'         => __( 'Dashboard', 'woocommerce' ),
       'orders'            => __( 'Orders', 'woocommerce' ),
       'track-order'       => __( 'Track Order', 'woocommerce' ),
       'edit-address'      => __( 'Addresses', 'woocommerce' ),
       'edit-account'      => __( 'Edit Account', 'woocommerce' ),
   );
   unset($items['downloads']);
   $new_items = array_merge($new_items, $items);
    return $new_items;
}

add_action('woocommerce_account_track-order_endpoint', function() {
	$licenses = [];  // Replace with function to return licenses for current logged in user

	wc_get_template('myaccount/track-order.php', [
		// 'licenses' => $licenses
	]);
});
add_action('init', function() {
	add_rewrite_endpoint('track-order', EP_ROOT | EP_PAGES);
});
function my_custom_query_vars( $vars ) {
    $vars[] = 'track-order';

    return $vars;
}

add_filter( 'query_vars', 'my_custom_query_vars', 0 );

function my_custom_flush_rewrite_rules() {
    flush_rewrite_rules();
}

add_action( 'wp_loaded', 'my_custom_flush_rewrite_rules' );

 ?>
