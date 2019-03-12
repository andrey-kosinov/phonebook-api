<?php

/**
 * Function to get config for any needs
 *
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */

/**
 * Get config by name
 *
 * Config files are stored in config folder.
 * Each config file must return something which will be the configuraion for a part of a project
 * Usualy it's a string or an array
 *
 * @param  string $name Config storage name
 * @return mixed        Configuration string, array or something else
 */
function config(string $name) {
	$config_path = php_sapi_name() == "cli" ? 'config' : '../config';
	return require_once $config_path.'/'.$name.'.php';
}