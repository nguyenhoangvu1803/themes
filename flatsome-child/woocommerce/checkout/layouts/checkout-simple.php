<!DOCTYPE html>
<!--[if lte IE 9 ]>
<html class="ie lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<link rel="profile" href="http://gmpg.org/xfn/11"/>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="main-content" class="site-main">

	<div id="main" class="page-checkout-simple">

		<?php while ( have_posts() ) : the_post(); ?>

			<div class="cart-header text-left medium-text-center">
				<div class="card-header-top">
					<div class="container">
						<?php get_template_part( 'template-parts/header/partials/element', 'logo' ); ?>
						<?php if(!get_theme_mod('check_out_hide_massage')) { ?>
							<?php if ( is_active_sidebar( 'header-right-checkout' ) ) { ?>
								<div class="message-container right">
								    <?php dynamic_sidebar( 'header-right-checkout' ); ?>
								</div>
							<?php } ?>
						<?php }?>
					</div>
				</div>
				<?php if(!get_theme_mod('check_out_nav_step')) { ?>
					<div class="card-header-bottom">
						<div class="container">
							<?php wc_get_template( 'checkout/header-small.php' ); ?>
						</div>
					</div>
				<?php }?>
			</div>

			<div id="content" role="main">
				<div class="container">
					<?php wc_print_notices(); ?>
					<?php the_content(); ?>

				</div>
			</div>

		<?php endwhile; // end of the loop. ?>

	</div>

	<div class="focused-checkout-footer">
		<?php get_template_part( 'template-parts/footer/footer', 'absolute' ); ?>
	</div>

</div>

</div>

<?php wp_footer(); ?>

</body>
</html>
