<?php

require get_template_directory() . '/inc/classes/multi-post-thumbnails.php';
// Register Custom Post Type
function custom_post_review() {

	$labels = array(
		'name'                  => _x( 'Reviews', 'Post Type General Name', 'uoy_review' ),
		'singular_name'         => _x( 'Review', 'Post Type Singular Name', 'uoy_review' ),
		'menu_name'             => __( 'Reviews', 'uoy_review' ),
		'name_admin_bar'        => __( 'Review', 'uoy_review' ),
		'archives'              => __( 'Item Archives', 'uoy_review' ),
		'attributes'            => __( 'Item Attributes', 'uoy_review' ),
		'parent_item_colon'     => __( 'Parent Item:', 'uoy_review' ),
		'all_items'             => __( 'All Items', 'uoy_review' ),
		'add_new_item'          => __( 'Add New Item', 'uoy_review' ),
		'add_new'               => __( 'Add New', 'uoy_review' ),
		'new_item'              => __( 'New Item', 'uoy_review' ),
		'edit_item'             => __( 'Edit Item', 'uoy_review' ),
		'update_item'           => __( 'Update Item', 'uoy_review' ),
		'view_item'             => __( 'View Item', 'uoy_review' ),
		'view_items'            => __( 'View Items', 'uoy_review' ),
		'search_items'          => __( 'Search Item', 'uoy_review' ),
		'not_found'             => __( 'Not found', 'uoy_review' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'uoy_review' ),
		'featured_image'        => __( 'Product Image', 'uoy_review' ),
		'set_featured_image'    => __( 'Set product image', 'uoy_review' ),
		'remove_featured_image' => __( 'Remove product image', 'uoy_review' ),
		'use_featured_image'    => __( 'Use as product image', 'uoy_review' ),
		'insert_into_item'      => __( 'Insert into item', 'uoy_review' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'uoy_review' ),
		'items_list'            => __( 'Items list', 'uoy_review' ),
		'items_list_navigation' => __( 'Items list navigation', 'uoy_review' ),
		'filter_items_list'     => __( 'Filter items list', 'uoy_review' ),
	);
	$args = array(
		'label'                 => __( 'Review', 'uoy_review' ),
		'description'           => __( 'UOY Reviews', 'uoy_review' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'review', $args );

}
add_action( 'init', 'custom_post_review', 0 );

// Define additional "mobile thumbnails". Relies on MultiPostThumbnails to work
if (class_exists('MultiPostThumbnails')) {
	new MultiPostThumbnails(array(
		'label' => 'Buyer avatar image',
		'id' => 'buyer-avatar-image',
		'post_type' => 'review'
		)
	);  
};

// Add Header Box to the Flex Post
add_action('add_meta_boxes', 'add_custom_post_review');

function add_custom_post_review() {
  add_meta_box(
    'custom_post_review',		// ID
    'UOY Review',	// Title
    'custom_display_post_review',	// Callback
    'review',						// Targeted post type
    'normal'					// Position
  );
}

function custom_display_post_review($page) {
  $review_text = get_post_meta($page->ID, 'review_text', true);
  $review_title = get_post_meta($page->ID, 'review_title', true);
  $buyer_country = get_post_meta($page->ID, 'buyer_country', true);
  $product_link = get_post_meta($page->ID, 'product_link', true);
  // Display fields
  ?>
  <p>
    <label for="review_text">Review Text:</label><br />
    <textarea class="widefat" type="text" name="review_text" id="review_text" rows="5" cols="40"><?php echo $review_text; ?></textarea>
  </p>
  <p>
    <label for="buyer_country">Review Title or Product Title:</label><br />
    <input class="widefat" type="text" name="review_title" id="review_title" value="<?php echo $review_title; ?>" />
  </p>
  <p>
    <label for="buyer_country">Buyer Country:</label><br />
    <input class="widefat" type="text" name="buyer_country" id="buyer_country" value="<?php echo $buyer_country; ?>" />
  </p>
  <p>
    <label for="product_link">Product link:</label><br />
    <input class="widefat" type="text" name="product_link" id="product_link" value="<?php echo $product_link; ?>" />
  </p>
  <?php
}

add_action('save_post', 'custom_review_post');

function custom_review_post($page_id) {
  // If we're doing an autosave, return
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

  // Save/Update Data
  if ( ! empty( $_POST['review_text'] ) ) {
    update_post_meta( $page_id, 'review_text', esc_html($_POST['review_text']) );
  } else {
    delete_post_meta( $page_id, 'review_text' );
  }

  if ( ! empty( $_POST['review_title'] ) ) {
    update_post_meta( $page_id, 'review_title', esc_html($_POST['review_title']) );
  } else {
    delete_post_meta( $page_id, 'review_title' );
  }

  if ( ! empty( $_POST['buyer_country'] ) ) {
    update_post_meta( $page_id, 'buyer_country', esc_html($_POST['buyer_country']) );
  } else {
    delete_post_meta( $page_id, 'buyer_country' );
  }

  if ( ! empty( $_POST['product_link'] ) ) {
    update_post_meta( $page_id, 'product_link', esc_html($_POST['product_link']) );
  } else {
    delete_post_meta( $page_id, 'product_link' );
  }

}