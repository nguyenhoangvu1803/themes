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

	// $('.slider-nav').flickity({
	//   	asNavFor: '.slider',
	//   	contain: true,
	//   	pageDots: true,
	//   	prevNextButtons: false,
	//   	cellAlign: 'left'
	// });

	var cellElements = $('.product-gallery-slider').flickity('getCellElements')
	console.log( cellElements );

	var flkty = $('.product-gallery-slider').data('flickity')
	console.log( 'carousel at ' + flkty.selectedIndex );

})