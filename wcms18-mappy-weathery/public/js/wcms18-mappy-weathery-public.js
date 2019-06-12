let googleMap, geocoder;

function initMap() {
	let $ = jQuery,
		$wrapper = $("#wcms18-mappy-weather"),
		address = $wrapper.data("address"),
		$map = $wrapper.find("#map"),
		map = $map[0];

	geocoder = new google.maps.Geocoder();
	geocoder.geocode(
		{
			address: address
		},
		function(results, status) {
			if (results.length > 0) {
				let latLng = results[0].geometry.location;
				googleMap = createMap(map, latLng);

				let centerMarker = new google.maps.Marker({
					position: latLng,
					map: googleMap
				});
			}
		}
	);
}

function createMap(mapElement, latLng) {
	return new google.maps.Map(mapElement, {
		center: latLng,
		zoom: 1
	});
}
