<?php
/**
 * Function for communicationg with the StarWars API
 */

function swapi_get_films() {
	// do we have the films cached
	$films = get_transient('swapi_get_films');

	
	if($films) {
		// if so return the cached films
		return $films;

	} else {
		// otherwise, retrieve the films from the starwars api
		$result = wp_remote_get('https://swapi.co/api/films');
	
		if(wp_remote_retrieve_response_code($result) === 200) {
			$data = json_decode(wp_remote_retrieve_body($result));
			$films = $data->results;
			set_transient('swapi_get_films', $films, 60*60);
			
			return $films;
		} else {
			return false;
		}
	}
}

function swapi_get_species($specie_id) {
	// do we have the specie cached
	$specie = get_transient('swapi_get_species_' . $specie_id);

	
	if($specie) {
		// if so return the cached specie
		return $specie;

	} else {
		// otherwise, retrieve the specie from the starwars api
		$result = wp_remote_get('https://swapi.co/api/species/' . $specie_id);
		//var_dump($result);
		if(wp_remote_retrieve_response_code($result) === 200) {
			$specie = json_decode(wp_remote_retrieve_body($result));
			set_transient('swapi_get_species_' . $specie_id, $specie, 60*60*24*7);
			
			return $specie;
		} else {
			return false;
		}
	}
}
