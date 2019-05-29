(function ($) {

	// console.log("MY AJAX OBJ IS:", my_ajax_obj.ajax_url);

	$(document).ready(function () {

	});

})(jQuery);

function w18ww_get_current_weather(widget_id, widget_city, widget_country) {

	// console.log("city " + widget_city + " country " + widget_country + " widget " + widget_id)

	jQuery.post(
		my_ajax_obj.ajax_url, {
			action: 'get_current_weather',
			city: widget_city,
			country: widget_country,
		},

		function (data) {
			// console.log("GOT RESPONSE for widget " + widget_id + "!!!! YAY!!", data);
			var output = "";
			console.log(data.conditions);
			output += '<strong>Temperature:</strong> ' + data.temperature + '&deg; C<br>';
			output += '<strong>Humidity:</strong> ' + data.humidity + '%<br>';
			jQuery('#' + widget_id + ' .current-weather').html(output);
		}
	);
}