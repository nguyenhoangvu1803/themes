<?php

$align = 'small-text-center';
if ( get_theme_mod( 'footer_bottom_align' ) == 'center' ) {
  $align = 'text-center';
}

ob_start();
do_action( 'flatsome_absolute_footer_secondary' );
$flatsome_absolute_footer_secondary = trim( ob_get_clean() );
$flatsome_footer_right_text = trim( get_theme_mod( 'footer_right_text' ) );

?>

<div class="absolute-footer <?php echo flatsome_option('footer_bottom_text'); ?> medium-text-center <?php echo $align;?> hide-for-small">
  
  <div class="container clearfix">

    <?php if ( $flatsome_footer_right_text || $flatsome_absolute_footer_secondary ) : ?>
      <div class="footer-secondary pull-right">

        <?php if(is_checkout()) { ?>

          <?php echo do_shortcode('[ux_payment_icons]');?>

        <?php } else { ?>

          <?php if ( $flatsome_footer_right_text ) : ?>
            <div class="footer-text inline-block small-block">
              <?php echo do_shortcode($flatsome_footer_right_text); ?>
            </div>
          <?php endif; ?>
          <?php echo $flatsome_absolute_footer_secondary; ?>

        <?php } ?>

      </div>
    <?php endif; ?>

    <div class="footer-primary pull-left">
      <?php if ( has_nav_menu( 'footer' ) ) : ?>
        <?php
        wp_nav_menu( array(
          'theme_location' => 'footer',
          'menu_class' => 'links footer-nav uppercase',
          'depth' => 1,
          'fallback_cb' => false,
        ) );
        ?>
      <?php endif; ?>
      <div class="copyright-footer">
        <?php echo do_shortcode( get_theme_mod( 'footer_left_text', 'Copyright [ux_current_year] &copy; <strong>UX Themes</strong>' ) ); ?>
      </div>
      <?php do_action( 'flatsome_absolute_footer_primary' ); ?>
    </div>
  </div>
</div>