jQuery(document).ready(function($) {

	var $carouselNav = $('.slider-nav');

	$carouselNav.on( 'click', '.nav-cell', function( event ) {
		console.log(1);
	  	var index = $( event.currentTarget ).index();
		console.log(index);
	  	$('.product-lightbox .product-gallery .slider').flickity( 'select', index );
	});

	// $('.product-lightbox .product-gallery .slider').flickity('select', 3);


})