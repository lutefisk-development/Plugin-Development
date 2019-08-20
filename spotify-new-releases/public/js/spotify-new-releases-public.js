(function($) {
	$(document).ready(function() {
		$(".widget_spotify-new-releases .content").each(function(i, widget) {
			$.post(my_ajax_obj.ajax_url, {
				action: "spotify_new_releases__get"
			})
				.done(function(response) {
					let output = "";
					if (response) {
						output += "<h1>Album One</h1>";
						output +=
							"<p>Artist: " + response.data["release_one_artist"] + "</p>";
						output +=
							"<p>Album name: " +
							response.data["release_one_album_name"] +
							"</p>";
						output +=
							"<p>Album type: " +
							response.data["release_one_album_type"] +
							"</p>";
						output +=
							"<a href=" +
							response.data["release_one_url"] +
							"><img src=" +
							response.data["release_one_image"] +
							"></a><br>";
						output += "<hr>";
						output += "<h1>Album Two</h1>";
						output +=
							"<p>Artist: " + response.data["release_two_artist"] + "</p>";
						output +=
							"<p>Album name: " +
							response.data["release_two_album_name"] +
							"</p>";
						output +=
							"<p>Album type: " +
							response.data["release_two_album_type"] +
							"</p>";
						output +=
							"<a href=" +
							response.data["release_two_url"] +
							"><img src=" +
							response.data["release_two_image"] +
							"></a><br>";
						output += "<hr>";
						output += "<h1>Album Three</h1>";
						output +=
							"<p>Artist: " + response.data["release_three_artist"] + "</p>";
						output +=
							"<p>Album name: " +
							response.data["release_three_album_name"] +
							"</p>";
						output +=
							"<p>Album type: " +
							response.data["release_three_album_type"] +
							"</p>";
						output +=
							"<a href=" +
							response.data["release_three_url"] +
							"><img src=" +
							response.data["release_three_image"] +
							"></a>";
					} else {
						if (response.data == 404) {
							output += "Could not find new releases";
						} else {
							output += "Something went wrong.";
						}
					}
					$(widget).html(output);
				})
				.fail(function(error) {
					let output = "Unknown error";
					if (error.status == 404) {
						output = "Could not find new releases";
					}
					$(widget).html(output);
				});
		});
	});
})(jQuery);
