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

		<div id="content" role="main">
			<div class="container">
				<?php while ( have_posts() ) : the_post(); ?>

					<div class="cart-header text-left medium-text-center">
						<div class="card-header-top">
							<?php get_template_part( 'template-parts/header/partials/element', 'logo' ); ?>
							<?php if(!get_theme_mod('check_out_hide_massage')) { ?>
								<div class="message-container right">
									<a href="https://flagwix.com/delivery-processing-delays-due-to-covid-19/"><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M17.4265 10.6873L11.2514 1.17375C10.7368 0.432432 9.90055 0 9 0C8.09945 0 7.26323 0.432432 6.74864 1.17375L0.573463 10.6873C-0.134108 11.7992 -0.198433 13.0965 0.444814 14.2085C1.08806 15.3205 2.31023 16 3.66105 16H14.339C15.6898 16 16.9119 15.3205 17.5552 14.2085C18.1984 13.0965 18.1341 11.7992 17.4265 10.6873ZM7.64918 4.88031C8.29243 4.139 9.64325 4.139 10.2865 4.88031C10.6081 5.25096 10.8011 5.74517 10.6724 6.23938L10.2222 9.32819C10.1578 9.63707 9.90055 9.88417 9.57892 9.88417H8.29243C7.9708 9.88417 7.71351 9.63707 7.64918 9.32819L7.19891 6.23938C7.19891 5.74517 7.32756 5.25096 7.64918 4.88031ZM9.32162 13.5907H8.67838C7.77783 13.5907 7.07026 12.9112 7.07026 12.0463C7.07026 11.1815 7.77783 10.5019 8.67838 10.5019H9.32162C10.2222 10.5019 10.9297 11.1815 10.9297 12.0463C10.9297 12.9112 10.2222 13.5907 9.32162 13.5907Z" fill="#EB3939"/>
										</svg>Delays in Shipping and COVID-19 Statement</a>
								</div>
							<?php }?>
						</div>
						<?php if(!get_theme_mod('check_out_nav_step')) { ?>
							<div class="card-header-bottom">
								<?php wc_get_template( 'checkout/header-small.php' ); ?>
							</div>
						<?php }?>
					</div>
					<?php wc_print_notices(); ?>
					<?php the_content(); ?>

				<?php endwhile; // end of the loop. ?>
			</div>
		</div>

	</div>

	<div class="focused-checkout-footer">
		<?php get_template_part( 'template-parts/footer/footer', 'absolute' ); ?>
	</div>

</div>

</div>

<?php wp_footer(); ?>

</body>
</html>
