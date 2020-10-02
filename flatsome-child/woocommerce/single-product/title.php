<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<h1 class="product-title product_title entry-title">
	<?php the_title(); ?>
</h1>
<div class="hide-for-medium" style="margin-top:-7px;margin-bottom:5px">
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
<?php if ( get_theme_mod( 'product_title_divider', 1 ) ) { ?>
	<div class="is-divider small"></div>
<?php } ?>
<script>
  var $ = jQuery;
  $(document).ready(function() {
    $("#load-review").click(function(event){
      event.preventDefault();
      $('ul.product-tabs').find('> li.active').removeClass('active');
      $('#tab-title-reviews_tab').addClass('active');
      $('.tab-panels').find('> div.active').removeClass('active');
      $('#tab-reviews_tab').addClass('active');
      var targetOffset = $('#tab-title-reviews_tab').offset().top - 100;
      $('html, body').animate({scrollTop: targetOffset}, 500);
      if ($(this).attr("data-click") == '0') {
        $(this).attr('data-click', '1');
        $('<link/>', {
          rel: 'stylesheet',
          type: 'text/css',
          href: 'https://cdn.judge.me/judgeme_widget_v2.css'
        }).appendTo('head');
        $.getScript("https://cdn.judge.me/judgeme_widget_v2.js");
      }
    });
    $('.woocommerce-tabs').waypoint(function(direction) {
      if ($("#load-review").attr("data-click") == '0') {
        $("#load-review").attr('data-click', '1');
        $('<link/>', {
          rel: 'stylesheet',
          type: 'text/css',
          href: 'https://cdn.judge.me/judgeme_widget_v2.css'
        }).appendTo('head');
        $.getScript("https://cdn.judge.me/judgeme_widget_v2.js");
      }
    }, {
      offset: '25%'
    });
  });
</script>