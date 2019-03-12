<?php

/**
 * Class to get outer data for validation of Time zones and Country codes
 *
 * The logic is so simple that there is no need to use third party packages such as Guzzle.
 * All requests to outer API cached with self made Cache class for 24 hours
 *
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */

namespace App\Helpers;

use Core\Cache;

class OuterCheckAPI {

	/**
	 * Get countries array from outer API
	 * @return array Array of countries where keys are country codes and values are country names
	 */
	public static function getCountries() {

		$seconds = 60*60*24; // Cache for 24 hours
		$countries = Cache::remember('countries', $seconds, function() {
			$raw_data = file_get_contents('https://api.hostaway.com/countries');
			return json_decode($raw_data,true)['result'];
		});

		return $countries;
	}

	/**
	 * Get time zones array from outer API
	 * @return array Array of time zones, where keys are time zone names
	 */
	public static function getTimeZones() {

		$seconds = 60*60*24; // Cache for 24 hours
		$timezones = Cache::remember('timezones', $seconds, function() {
			$raw_data = file_get_contents('https://api.hostaway.com/timezones');
			return json_decode($raw_data,true)['result'];
		});

		return $timezones;
	}

}