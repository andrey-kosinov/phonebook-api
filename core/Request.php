<?php

/**
 * Class to work with JSON API requests
 *
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */

namespace Core;

class Request {

	/**
	 * Request URL input array parsed from query (after ?)
	 * @var array
	 */
	private static $inputs = [];

	/**
	 * Get body of POST/PUT/PATCH and such HTTP methods
	 * @return string Body of a request
	 */
	public static function getBody() {
		return file_get_contents('php://input');
	}

	/**
	 * Get HTTP request body, decode it from JSON and return as object
	 * @return stdClass Decoded object
	 */
	public static function getDecodedBodyObject() {
		return json_decode(self::getBody());
	}

	/**
	 * Parses request query string (after ?) and puts variables and values to an array
	 * @return array  Array of query parameters
	 */
	public static function input() {

		if (count(self::$inputs)>0) {
			return self::$inputs;
		}

		$query = parse_url($_SERVER['REQUEST_URI'])['query'];
		if ($query) {
			$chunks = explode('&',$query);
			foreach ($chunks as $chunk) {
				$part = explode('=',$chunk);
				self::$inputs[$part[0]] = $part[1];
			}
		}

		return self::$inputs;
	}
}