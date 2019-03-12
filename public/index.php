<?php

/**
 * Phonebook API PHP Project
 *
 * @package  Phonebook
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */

use Core\Router;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer let us autoload application classes and config files
|
*/
require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Connect to database
|--------------------------------------------------------------------------
|
| Connect Eloquent ORM to database
|
*/
require __DIR__.'/../core/lib/bootEloquentORM.php';

try {
	Router::run('api');
} catch(Exception $e) {
	handleException($e);
}

