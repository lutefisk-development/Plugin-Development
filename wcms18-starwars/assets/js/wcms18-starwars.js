(function($) {
	$(".widget_wcms18-starwars-widget .trivia").each(function(i, widget) {
		let trivia = $(widget).data("trivia");

		$.post(my_ajax_obj.ajax_url, {
			action: "get_sw_trivia",
			trivia: trivia
		})

			.done(function(response) {
				let output = "";
				if (response.success) {
					let triviaDetails = response.data;
					output += "<p>Trivia for: " + trivia + "</p><br>";
					output += "<em>";
					switch (trivia) {
						case "starships":
							for (let i = 0; i < triviaDetails.length; i++) {
								output +=
									"<strong>Name:</strong> " +
									triviaDetails[i].name +
									"<br>" +
									"<strong>Model:</strong> " +
									triviaDetails[i].model +
									"<br>" +
									"<strong>Crew:</strong> " +
									triviaDetails[i].crew +
									"<br><br>";
							}
						case "planets":
							for (let i = 0; i < triviaDetails.length; i++) {
								output +=
									"<strong>Name:</strong> " +
									triviaDetails[i].name +
									"<br>" +
									"<strong>Diameter:</strong> " +
									triviaDetails[i].diameter +
									"<br>" +
									"<strong>Population:</strong> " +
									triviaDetails[i].population +
									"<br><br>";
							}
						case "species":
							for (let i = 0; i < triviaDetails.length; i++) {
								output +=
									"<strong>Name:</strong> " +
									triviaDetails[i].name +
									"<br>" +
									"<strong>Classification:</strong> " +
									triviaDetails[i].classification +
									"<br>" +
									"<strong>Language:</strong> " +
									triviaDetails[i].language +
									"<br><br>";
							}
						case "films":
							for (let i = 0; i < triviaDetails.length; i++) {
								output +=
									"<strong>Title:</strong> " +
									triviaDetails[i].title +
									"<br>" +
									"<strong>Episode Number:</strong> " +
									triviaDetails[i].episode_id +
									"<br>" +
									"<strong>Director:</strong> " +
									triviaDetails[i].director +
									"<br><br>";
							}
						case "vehicles":
							for (let i = 0; i < triviaDetails.length; i++) {
								output +=
									"<strong>Name:</strong> " +
									triviaDetails[i].name +
									"<br>" +
									"<strong>Cost:</strong> " +
									triviaDetails[i].cost_in_credits +
									"<br>" +
									"<strong>Manufacturer:</strong> " +
									triviaDetails[i].manufacturer +
									"<br><br>";
							}
						case "people":
							for (let i = 0; i < triviaDetails.length; i++) {
								output +=
									"<strong>Name:</strong> " +
									triviaDetails[i].name +
									"<br>" +
									"<strong>Height:</strong> " +
									triviaDetails[i].height +
									" cm" +
									"<br>" +
									"<strong>Mass:</strong> " +
									triviaDetails[i].mass +
									" kg" +
									"<br><br>";
							}
					}
					output += "</em>";
				}
				$(widget).html(output);
			})

			.fail(function(error) {
				alert("ERROR!!!!!!!! ZOMG", error);
			});
	});
})(jQuery);
