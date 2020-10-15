jQuery(document).ready(function($) {

	var $carouselNav = $('.slider-nav');

	console.log(2);

	$(document).on('click', '.nav-cell', function(e) {
	  var index = $( e.currentTarget ).index();
	  console.log(index);
	  console.log(3);
	});

	$carouselNav.on( 'click', '.nav-cell', function( event ) {
		console.log(1);
	  	var index = $( event.currentTarget ).index();
		console.log(index);
	  	$('.product-lightbox .product-gallery .slider').flickity( 'select', index );
	});

	// $('.product-lightbox .product-gallery .slider').flickity('select', 3);


})