<?php

/**
 * Class to work with API responses
 *
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */

namespace Core;

class Response
{

	/**
	 * Abort execution with error code and message
	 * @param  int    $code    HTTP Response Code
	 * @param  string $message Abotion reason description
	 */
	public static function abort(int $code, string $message='') {
		header('Content-type: application/json');
		http_response_code($code);
		$response_arr = ['status'=>false,'error'=>['code'=>$code,'message'=>$message]];
		die(json_encode($response_arr));
	}

	/**
	 * Return success HTTP code 200 and a short message
	 * @param  string $message Description of successfull request
	 */
	public static function success(string $message='') {
		header('Content-type: application/json');
		http_response_code(200);
		$response_arr = ['status'=>'success','result'=>['code'=>200,'message'=>$message]];
		die(json_encode($response_arr));
	}


	/**
	 * Return string as response, for example, when we return a view
	 * @param  string $data String to return
	 */
	public static function return($data=null) {
		if (isset($data)) {
			die($data);
		}
	}

	/**
	 * Return JSON encoded object or aray
	 * @param  stdClass $obj Object to encode and return to response
	 * @param  stdClass $info Additional information object that will be added to a response
	 */
	public static function json($obj,$info=null) {
		header('Content-type: application/json');
		$response_arr = ['status'=>'success'];
		if ($info)
			$response_arr['info'] = $info;
		$response_arr['result'] = $obj;
		die(json_encode($response_arr));
	}
}