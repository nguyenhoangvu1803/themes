<?php
/*
Template name: WooCommerce - My Account
This templates add My account to the sidebar.
*/

get_header(); ?>

<?php do_action( 'flatsome_before_page' ); ?>

<?php // wc_get_template('myaccount/header.php'); ?>

<div class="page-wrapper my-account mb">
<div class="container" role="main">

<?php if(is_user_logged_in()){?>

<div class="row vertical-tabs">
	<div class="large-3 col col-border">

		<?php wc_get_template('myaccount/account-user.php'); ?>
		<div class="myaccount__nav p-relative js-toggle-navi-mobile">
			<ul class="myaccount__nav--mobile account-nav nav nav-line nav-uppercase d-block d-md-none ">
			     <?php wc_get_template('myaccount/account-links.php'); ?>
			</ul>
			<ul id="my-account-nav" class="account-nav nav nav-line nav-uppercase nav-vertical mt-half">
			     <?php wc_get_template('myaccount/account-links.php'); ?>
			</ul>

		</div>

	</div>

	<div class="large-9 col">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; // end of the loop. ?>
	</div>
</div>

<?php } else { ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>

	<?php endwhile; // end of the loop. ?>

<?php } ?>

</div>
</div>
<script type="text/javascript">
	(function($){
		$(document).on('click', function(event) {
			var $target = $(event.target);
			 if(!$target.closest('.js-toggle-navi-mobile').length) {
				 $('.js-toggle-navi-mobile').find('ul.is-active').removeClass('is-active');
			 } else {
				 $('.js-toggle-navi-mobile').find('ul').eq(0).toggleClass('is-active');
			 }
		});

	})(jQuery)
</script>
<?php do_action( 'flatsome_after_page' ); ?>

<?php get_footer(); ?>
