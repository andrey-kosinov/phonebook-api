<?php

/**
 * Controller for manipulating with User model
 *
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */

namespace App\Controllers;

use App\Models\User;
use Core\{Response, Request};

class UserController
{

	/**
	 * Get list of users from phonebook
	 */
	public function index() {

		$users = User::orderBy('id','asc');
		$total_count = $users->count();

		if (Request::input()['skip'] && Request::input()['take']) {
			$users->skip(Request::input()['skip'])->take(Request::input()['take']);
		}

		$users = $users->get();

		return Response::json($users,$info=['total_count'=>$total_count]);
	}

	/**
	 * Get user properties by ID
	 * @param  integer $id ID of the user to show
	 */
	public function show($id) {

		$user = User::find($id);

		if (!$user) {
			return Response::abort(404, 'User not found');
		}

		return Response::json($user);
	}

	/**
	 * Search users by keyword
	 */
	public function search() {
		$request_data = Request::getDecodedBodyObject();
		if (!$request_data->keyword) {
			return Response::abort(400, 'Keyword is required to make search');
		}

		$keyword = trim($request_data->keyword);
		$users = User::where('first_name','like',"%$keyword%")->orWhere('last_name','like',"%$keyword%");
		$total_count = $users->count();

		if (Request::input()['skip'] && Request::input()['take']) {
			$users->skip(Request::input()['skip'])->take(Request::input()['take']);
		}

		$users = $users->get();

		return Response::json($users,$info=['total_count'=>$total_count]);
	}

	/**
	 * Create user
	 */
	public function create() {

		$request_data = Request::getDecodedBodyObject();
		$user = new User();

		if (!$user->store($request_data)) {
			Response::abort(500,'Something wrong happened');
		}

		Response::success('User created');
	}

	/**
	 * Update user by ID
	 * @param  integer $id ID of the user to update
	 */
	public function update($id) {

		$request_data = Request::getDecodedBodyObject();
		$user = User::find($id);

		if (!$user) {
			return Response::abort(404, 'User not found');
		}

		if (!$user->store($request_data)) {
			Response::abort(500,'Something wrong happened');
		}

		Response::success('User updated');
	}

	/**
	 * Delete user by ID
	 * @param  integer $id ID of the user to delete
	 */
	public function delete($id) {

		$user = User::find($id);
		if (!$user) {
			return Response::abort(404, 'User not found');
		}

		if (!$user->delete()) {
			Response::abort(500,'Something wrong happened');
		}

		return Response::success('User deleted');
	}
}