(function($) {
	$(document).ready(function() {
		$(".widget_wcms18-weather-widget").each(function(i, widget) {
			let current_weather = $(widget).find(".current-weather"),
				widget_city = $(current_weather).data("city"),
				widget_country = $(current_weather).data("country");

			$.post(my_ajax_obj.ajax_url, {
				action: "get_current_weather",
				city: widget_city,
				country: widget_country
			})
				.done(function(response) {
					var output = "";

					if (response.success) {
						let weather = response.data;

						output +=
							"<h3>City: " +
							widget_city +
							" - Country: " +
							widget_country +
							"</h3>";

						for (let i = 0; i < weather.conditions.length; i++) {
							output +=
								'<img src="http://openweathermap.org/img/w/' +
								weather.conditions[i].icon +
								'.png" title="' +
								weather.conditions[i].description +
								'" alt="' +
								weather.conditions[i].main +
								'"><br>';
						}
						output +=
							"<strong>Temperature:</strong> " +
							weather.temperature +
							"&deg; C<br>";
						output +=
							"<strong>Humidity:</strong> " + weather.humidity + "%<br>";
					} else {
						if (response.data == 404) {
							output += "Could not find current weather for city.";
						} else {
							output += "Something went wrong, please try again 😅.";
						}
					}
					$(current_weather).html(output);
				})
				.fail(function(error) {
					var output = "Unknown error";
					if (error.status == 404) {
						output = "Could not find weather server.";
					}
					$(current_weather).html(output);
				});
		});
	});
})(jQuery);
