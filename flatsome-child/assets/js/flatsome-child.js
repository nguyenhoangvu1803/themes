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


	// Listen event change Flickity
	// var $carousel = $('.product-gallery-slider').flickity();
	var flkty = new Flickity('.product-gallery-slider');
	flkty.on( 'change', function( index ) {
	  console.log( index + '/' + flkty.getCellElements().length );
	});


})