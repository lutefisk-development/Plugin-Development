(function ($) {

	console.log("MY AJAX OBJ IS:", my_ajax_obj.ajax_url);

	$(document).ready(function () {
		$.post(
			my_ajax_obj.ajax_url, {
				action: 'get_current_weather'
			},
			function (response) {
				console.log("got response", response);
			}
		);
	});

})(jQuery);