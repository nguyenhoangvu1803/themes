jQuery(document).ready(function($) {

	var $carouselNav = $('.slider-nav');
	var $carouselNavCells = $carouselNav.find('.nav-cell');

	$carouselNav.on( 'click', '.nav-cell', function( event ) {
	  	var index = $( event.currentTarget ).index();
	  	$('.product-lightbox .product-gallery .slider').flickity( 'select', index );
	});

	// $('.product-lightbox .product-gallery .slider').flickity('select', 3);


})