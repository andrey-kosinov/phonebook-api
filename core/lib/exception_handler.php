<?php

/**
 * Output exception error message and log it
 * @param Exception $e Exception object
 */
function handleException(Exception $e) {

	$msg = $e->getMessage().' on line '.$e->getLine().' in '.$e->getFile();

	$f = fopen('../storage/log/error_log.txt','a+');
	fputs($f,date('c')." - ".$msg.PHP_EOL);
	fclose($f);

	die($msg);
}