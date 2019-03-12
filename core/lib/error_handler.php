<?php

/**
 * Custom error handler to convert errors to exceptions
 * Parameters for the function are standart for error handler function
 * https://secure.php.net/manual/en/function.set-error-handler.php
 */
function customErrorHandler($errno, $message, $errfile, $errline) {

    if (!(error_reporting() & $errno)) {
        // Error code not included in error reporting, just let it go
        return false;
    }

	throw new ErrorException($message, 0, $errno, $errfile, $errline);
}

set_error_handler("customErrorHandler");
