$(function() {

	// Custom JS
	$('#main-mnu-button').click(function() {
		$('.main-mnu').slideToggle();
	})

	$('#catalog').click(function() {
		$('.first-ul').slideToggle();
	})

	$('#for-byers').click(function() {
		$('.second-ul').slideToggle();
	})
	
	$('#about-us').click(function() {
		$('.third-ul').slideToggle();
	})

	$("li").click(function() {
		$(this).next('li').children("ul").slideToggle();
	});

	$('.size').click(function() {
		$('.size').removeClass('active');
		$(this).addClass('active');
	})

});
