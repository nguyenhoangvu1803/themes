<?php
/**
 * The template for displaying lookbook product style content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop, $flatsome_opt;

/* CUSTOM FLATSOME FLIPBOOK TEMPLATE  */

?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <div class="row row-collapse align-middle flip-slide" style="width:100%">
        <div class="large-6 col flip-page-one">
        <div class="featured-product col-inner">
          <a href="<?php the_permalink(); ?>">
                <div class="product-image relative">
                   <div class="front-image">
                    <?php echo get_the_post_thumbnail( $post->ID,  apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' )) ?>
                  </div>
                  <?php wc_get_template( 'loop/sale-flash.php' ); ?>
                </div>
          </a>
        </div>
        </div>
       <div class="large-6 col flip-page-two">
        <div class="product-info col-inner inner-padding">
            <?php // woocommerce_template_single_meta(); ?>

            <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' ); ?>

            <h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <div class="product-star" style="margin-top:-7px;margin-bottom:20px">
              <span class="star">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
              </span>
              <a id="load-review" data-click="0" href="#tab-title-reviews_tab" class="reviews middle-of-product-reviews">
                <?php echo do_shortcode('[jgm-review-rating]'); ?> Stars | <?php echo do_shortcode('[jgm-review-count]'); ?> reviews
              </a>
            </div>
            <?php woocommerce_template_single_excerpt(); ?>
            <?php woocommerce_template_single_price();?>
            <a href="<?php the_permalink(); ?>" class="button"><?php _e( 'Add to Cart', 'woocommerce' ); ?></a>
         </div>
        </div>
</div>
