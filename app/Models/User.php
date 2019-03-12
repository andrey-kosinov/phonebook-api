<?php

/**
 * User model
 *
 * Phonebook contains user records.
 * Each user in phonebook has fields:
 * 	- First name
 * 	- Last name
 * 	- Phone number
 * 	- Country code
 * 	- Timezone name
 * 	- CreatedAt
 * 	- UpdatedAt
 *
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */


namespace App\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Core\Response;
use App\Helpers\OuterCheckAPI;

class User extends Eloquent {

	// Fiields for mass assignment model creation
	protected $fillable = ['first_name','last_name','phone_number','country_code','timezone'];

	// Hide timestamps from response. They are just for internal use
	protected $hidden = ['created_at','updated_at'];


	/**
	 * Validation data for creating or updating user
	 * @param  stdClass  $obj               Decoded from JSON request body data
	 * @param  boolean $all_fields_required If true all fields of user model are required, otherwise none is required
	 */
	public function validate($obj,$all_fields_required=true) {

		if ($all_fields_required) {

			$error_msgs = [];
			$required_fields = $this->fillable;

			foreach ($required_fields as $field) {
				if (!isset($obj->$field) || trim($obj->$field)=='') {
					$error_msg[] = "$field is required";
				}
			}

			if ($error_msg) {
				Response::abort(400, implode("\n",$error_msg));
			}

		}

		if (isset($obj->country_code)) {
			$countries = OuterCheckAPI::getCountries();
			if (!array_key_exists($obj->country_code, $countries)) {
				Response::abort(422, 'Country code not found');
			}
		}

		if (isset($obj->timezone)) {
			$timezones = OuterCheckAPI::getTimeZones();
			if (!array_key_exists($obj->timezone, $timezones)) {
				Response::abort(422, 'Timezone not found');
			}
		}

		if (isset($obj->phone_number)) {
			if (!preg_match("/\+?([0-9]{1,3})(\-|\s)?([0-9]{3})(\-|\s)?([0-9]{6,7})/", $obj->phone_number)) {
				Response::abort(422, 'Phone number given in incorrect format. Rules: +111 222 3334455');
			}
		}

		return true;
	}

	/**
	 * Store user to phone book. If $id is given then update user otherwise create
	 * @param  stdClass $obj Decoded from JSON request body data
	 * @param  integer  $id  ID of the user to update
	 */
	public function store($obj) {

		$this->validate($obj,$all_fields_required = $this->id ? false : true);

		foreach ($this->fillable as $field) {
			if (isset($obj->$field) && trim($obj->$field)!='') {
				$this->$field = $obj->$field;
			}
		}

		return $this->save();
	}

}