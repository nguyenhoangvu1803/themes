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
	var $carousel = $('.product-gallery-slider').flickity();
	console.log($carousel);
	$carousel.on( 'change.flickity', function( event, index ) {
		console.log(this);
	  	console.log( index + '/' + $carousel.flickity('getCellElements').length )
	  	let span = $('<span />')
	  	span.addClass('cureent-index')
	  	span.text(index + '/' + $carousel.flickity('getCellElements').length)
	  	span.appendTo($carousel);
	});


})