(function($) {
	"use strict";

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function() {
		$(".widget_wcms18-random-dog .content").each(function(i, widget) {
			$.post(my_ajax_obj.ajax_url, {
				action: "wcms18_random_dog__get"
			})
				.done(function(response) {
					let output = "";
					if (response) {
						if (response.data["is_video"]) {
							output += "<h1>A cute DOGGO vid</h1>";
							output +=
								"<video src=" + response.data["src"] + " controls></video>";
						} else {
							output += "<h1>A cute DOGGO picture</h1>";
							output += "<img src=" + response.data["src"] + ">";
						}
					} else {
						if (response.data == 404) {
							output += "Could not find doggies.";
						} else {
							output += "Something went wrong, please try again 😅.";
						}
					}
					$(widget).html(output);
				})
				.fail(function(error) {
					var output = "Unknown error";
					if (error.status == 404) {
						output = "Could not find doggo.";
					}
					$(widget).html(output);
				});
		});
	});
})(jQuery);
