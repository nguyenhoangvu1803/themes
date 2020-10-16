jQuery(document).ready(function($) {

	
	$(document).on('click', '.nav-cell', function(e) {
	  var index = $( e.currentTarget ).index();
	  $('.nav-cell').removeClass('active');
	  $(this).addClass('active');
	  $('.product-lightbox .product-gallery .slider').flickity( 'select', index );
	});

	$('.header-search > a').on('click', function(e){
		$(this).parent().find('input[type="search"]').focus();;
	})

	$('.single-product.slider-nav').flickity({
	  asNavFor: '.slider',
	  contain: true,
	  pageDots: false
	});

	var sliderNav = $('.single-product.slider-nav');

	sliderNav.on('click', '.nav-cell', function(e) {
		var index = $( e.currentTarget ).index();
		console.log(index);
	})

})