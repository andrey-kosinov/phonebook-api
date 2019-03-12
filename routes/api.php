<?php

/**
 * API Router
 *
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */

use Core\Router;

// Get users list
Router::add('GET', '/users', 'UserController@index');

// Get user properties by id
Router::add('GET', '/user/{id:\d+}', 'UserController@show');

// Get users list by searching parts of the name
Router::add('POST', '/users/search', 'UserController@search');

// Create user
Router::add('PUT', '/user', 'UserController@create');

// update user
Router::add('PATCH', '/user/{id:\d+}', 'UserController@update');

// Delete user by id
Router::add('DELETE', '/user/{id:\d+}', 'UserController@delete');
