<ul class="dashboard-links-flagwix">
<?php if ( has_nav_menu( 'my_account' ) ) { ?>
  <?php
    wp_nav_menu(array(
      'theme_location' => 'my_account',
      'container'      => false,
      'items_wrap' => '%3$s',
      'depth' => 1
    ));
  ?>
<?php } else if(!function_exists('wc_get_account_menu_items')) { ?>
    <li>Define your My Account dropdown menu in <b>Appearance > Menus</b></li>
<?php } ?>

<?php
    $orders  = get_posts(
    	apply_filters(
    		'woocommerce_my_account_my_orders_query',
    		array(
    			'numberposts' => -1,
    			'meta_key'    => '_customer_user',
    			'meta_value'  => get_current_user_id(),
    			'post_type'   => wc_get_order_types( 'view-orders' ),
    			'post_status' => array_keys( wc_get_order_statuses() ),
    		)
    	)
    );
    $textOrder = count($orders) > 0 ? '<span class="orders-sum">'.count($orders).'</span>' : '';
  if(function_exists('wc_get_account_menu_items') && flatsome_option('wc_account_links')){ ?>
  <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
    if($endpoint == 'dashboard') continue;
    ?>

    <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
      <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><div class="dashboard__item <?php echo $endpoint ?>"><?php echo esc_html( $label );if($endpoint == 'orders') echo $textOrder; ?></div></a>
    </li>
  <?php endforeach; ?>
  <?php do_action('flatsome_account_links'); ?>
<?php } ?>
</ul>
