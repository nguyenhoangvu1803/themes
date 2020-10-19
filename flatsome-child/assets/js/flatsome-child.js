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
	var $carousel = $('.product-gallery-slider').flickity()
	var flkty = $carousel.data('flickity');
	var span = $('<span />')
	.addClass('current-slider-number show-for-small')
	.text( ($flkty.selectedIndex + 1) + '/' + $carousel.flickity('getCellElements').length + flkty.selectedElement)
	.appendTo($carousel.parent())

	$carousel.on( 'change.flickity', function( event, index ) {
	  	console.log( index + '/' + $carousel.flickity('getCellElements').length )
	  	span.empty()
	  	.text( (index +1 ) + '/' + $carousel.flickity('getCellElements').length)
	});


})