<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></td>
						<td class="value">
							<?php
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									)
								);
								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="single_variation_wrap">
      <div style="font-size: 0.88em;">This is the best offer you've ever seen, <span style="font-weight: 700;">only this <?php echo date('F'); ?></span></div>
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<script type="text/javascript">

jQuery('[data-date]').each(function() {
	var day = parseInt(jQuery(this).attr('data-date'));
	var currentdate = new Date();
	var showDate = new Date(currentdate.setDate(currentdate.getDate() - day));
	var text = (showDate.getMonth() + 1) + "/" + showDate.getDate() + "/" + showDate.getFullYear();
	jQuery(this).html(text);
});

jQuery(function ($) {

  if ($('.product-quick-view-container').length) {
    $('.product-quick-view-container .variations select').each(function (selectIndex, selectElement) {

      var $title = $('.product-title');
      var select = $(selectElement);
      var container = $("<div class='radioSelectContainer' />");
      select.parent().append(container);
      container.append(select);

      select.find('option').each(function (optionIndex, optionElement) {
        var radioGroup = select.attr('id') + "Group";
        var label = $("<label />");
        container.append(label);

        if (select.val() == $(this).val()) {
          $("<input type='radio' name='" + radioGroup + "' />")
            .attr("value", $(this).val())
            .prop('checked', true)
            .addClass('active')
            .appendTo(label);
        } else {
          $("<input type='radio' name='" + radioGroup + "' />")
            .attr("value", $(this).val())
            .appendTo(label);
        }

        if ($title.text().toLowerCase().includes("rug")) {
          $("<span>" + $(this).text() + "</span>").appendTo(label);
        } else {
          $("<span>" + $(this).text() + "</span>").appendTo(label);
        }
      });

      container.find(":radio + span").mousedown(
        function (e) {
          var $span = $(this);
          var $radio = $($span.prev());
          if ($radio.is(':checked')) {
            return false;
          } else {
            select.val($radio.val()).trigger('change');
          }
        }
      );
      if (select.find("option").length == 1) {
        container.hide();
        container.closest('tr').hide();
      }
      select.change((function () { //select updates radio
        $("input[name='" + select.attr('id') + "Group" + "'][value='" + this.value + "']").prop("checked", true);
      }));

      if ($title.text().toLowerCase().includes("flag")) {
        select.val('house-flag-29-5-x-39-5').trigger('change');
      }

      var input = container.find(":radio:checked");
      select.val(input.val()).trigger('change');
      
    });
  } else {
    $('.variations select').each(function (selectIndex, selectElement) {

      var $title = $('.product-title');
      var select = $(selectElement);
      var container = $("<div class='radioSelectContainer' />");
      select.parent().append(container);
      container.append(select);

      select.find('option').each(function (optionIndex, optionElement) {
        var radioGroup = select.attr('id') + "Group";
        var label = $("<label />");
        container.append(label);

        if (select.val() == $(this).val()) {
          $("<input type='radio' name='" + radioGroup + "' />")
            .attr("value", $(this).val())
            .prop('checked', true)
            .addClass('active')
            .appendTo(label);
        } else {
          $("<input type='radio' name='" + radioGroup + "' />")
            .attr("value", $(this).val())
            .appendTo(label);
        }

        $("<span>" + $(this).text() + "</span>").appendTo(label);
      });


      container.find(":radio + span").mousedown(
        function (e) {
          console.log($(this));
          var $span = $(this);
          var $radio = $($span.prev());
          if ($radio.is(':checked')) {
            return false;
          } else {
            select.val($radio.val()).trigger('change');
          }
        }
      );
      if (select.find("option").length == 1) {
        container.hide();
        container.closest('tr').hide();
      }
      select.change((function () { //select updates radio
        $("input[name='" + select.attr('id') + "Group" + "'][value='" + this.value + "']").prop("checked", true);
      }));

      if ($title.text().toLowerCase().includes("flag")) {
        select.val('house-flag-29-5-x-39-5').trigger('change');
      }

      var input = container.find(":radio:checked");
      select.val(input.val()).trigger('change');
    });
  }


});
</script>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );
