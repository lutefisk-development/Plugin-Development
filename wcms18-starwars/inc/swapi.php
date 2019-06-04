<?php
/**
 * Function for communicationg with the StarWars API
 */

function swapi_get($endpoint, $id = null, $expiry = 3600) {
	$transient_key = "swapi_get_{$endpoint}";
	if ($id) {
		$transient_key .= "_{$id}";
	}
	$items = get_transient($transient_key);

	if (!$items) {
		if ($id) {
			$items = swapi_get_url("https://swapi.co/api/{$endpoint}/{$id}");
		} else {
			$items = [];
			$url = "https://swapi.co/api/{$endpoint}/";
			while ($url) {
				$res = swapi_get_url($url);
				if (!$res['success']) {
					return false;
				}
				$items = array_merge($items, $res['data']->results);

				$url = $res['data']->next; // "https://swapi.co/" | null
			}
		}

		// save for future use
		set_transient($transient_key, $items, $expiry);
	}

	// return items
	return $items;
}

function swapi_get_url($url) {
	$response = wp_remote_get($url);

	if(is_wp_error($response)) {
		return [
			'success'	=> false,
			'error'		=> wp_remote_retrieve_response_code($response),
		];
	}

	$data = json_decode(wp_remote_retrieve_body($response));

	return [
		'success'	=> true,
		'data'		=> $data,
	];
}

// function swapi_get_films() {
// 	return swapi_get('films');
// }

// function swapi_get_starships() {
// 	return swapi_get('starships');
// }

// function swapi_get_planets() {
// 	return swapi_get('planets');
// }

// function swapi_get_planet($planet_id) {
// 	return swapi_get('planets', $planet_id);
// }

// function swapi_get_vehicles() {
// 	return swapi_get('vehicles');
// }

// function swapi_get_vehicle($vehicle_id) {
// 	return swapi_get('vehicles', $vehicle_id);
// }

// function swapi_get_characters() {
// 	return swapi_get('people');
// }

// function swapi_get_character($character_id) {
// 	return swapi_get('people', $character_id);
// }

// function swapi_get_species() {
// 	return swapi_get('species');
// }

// function swapi_get_specie($specie_id) {
// 	return swapi_get('species', $specie_id);
// }

