function return_index(location_page)
{
	$(".container").animate({
		opacity: 0
	}, 1000, function() {
		$(this).css({
			"display": "none",
			"padding": "60px 30px"
		});
		$(this).load(location_page);
		$(this).css({
			"display": "block"
		}).animate({
			opacity: 1
		}, 1000);
	});
}