<?php

/**
 * Create Eloquent ORM instance and connect it to a database
 *
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */

use Illuminate\Database\Capsule\Manager as Capsule;

$DB_CONF = config('database');

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $DB_CONF['server'],
    'database'  => $DB_CONF['database'],
    'username'  => $DB_CONF['user'],
    'password'  => $DB_CONF['password'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();

// Setup the Eloquent ORM
$capsule->bootEloquent();

