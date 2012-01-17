<?php
/**
 * support/sanitize.php
 *
 * @package default
 * @see debug.php
 * @see download.php
 */


/**
 *
 *
 * @param unknown $input
 * @return unknown
 */
function sanitizeFilenamePart($input) {
	return filter_var($input, FILTER_SANITIZE_STRING);
	/*
	static $unacceptable = '[^[:alnum:]-_.]';
	return preg_filter($unacceptable, '_', $input);
	*/
}


/**
 *
 *
 * @param unknown $input
 * @return unknown
 */
function sanitizeLine($input) {
	return filter_var($input, FILTER_SANITIZE_STRING);
	/*
	static $unacceptable = '[^[:alnum:][:punct:][:space:]]';
	return str_replace(array('<?', '?>'), '', preg_filter($unacceptable, '_', $input));
	*/
}


?>
