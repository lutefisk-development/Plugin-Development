<?php
/**
 * Function for communicationg with the Open Weather API
 */

define('OWM_APP_ID', '5ae275d1a0023fc435486dc31a45cd67');

function w18ww_owm_get_current_weather($city, $country) {
	
	// get current weather
	$response = wp_remote_get("http://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&units=metric&appid=" . OWM_APP_ID);
	
	// make sure get valid response
	if(is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
		return false;
	}

	// parse response
	$data = json_decode(wp_remote_retrieve_body($response));

	// pick out data we need
	$current_weather = [];
	$current_weather['temperature'] = $data->main->temp;
	$current_weather['humidity'] = $data->main->humidity;
	$current_weather['city'] = $data->name;
	$current_weather['country'] = $data->sys->country;
	$current_weather['conditions'] = $data->weather;

	// return picked data to caller
	return $current_weather;
}