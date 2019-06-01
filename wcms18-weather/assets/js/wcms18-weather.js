(function($) {
	// console.log("MY AJAX OBJ IS:", my_ajax_obj.ajax_url);

	$(document).ready(function() {});
})(jQuery);

function w18ww_get_current_weather(widget_id, widget_city, widget_country) {
	// console.log("city " + widget_city + " country " + widget_country + " widget " + widget_id)

	jQuery.post(
		my_ajax_obj.ajax_url,
		{
			action: "get_current_weather",
			city: widget_city,
			country: widget_country
		},

		function(data) {
			var output = "";
			output +=
				"<h3>City: " + widget_city + " - Country: " + widget_country + "</h3>";
			for (let i = 0; i < data.conditions.length; i++) {
				output +=
					'<img src="http://openweathermap.org/img/w/' +
					data.conditions[i].icon +
					'.png" title="' +
					data.conditions[i].description +
					'" alt="' +
					data.conditions[i].main +
					'"><br>';
			}
			output +=
				"<strong>Temperature:</strong> " + data.temperature + "&deg; C<br>";
			output += "<strong>Humidity:</strong> " + data.humidity + "%<br>";
			jQuery("#" + widget_id + " .current-weather").html(output);
		}
	);
}
