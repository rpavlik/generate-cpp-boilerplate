<?php
/**
 * support/sanitize.php
 *
 * @package default
 * @see debug.php
 * @see download.php
 */


/** @brief Cleans up input that is intended as part of a filename.
 *
 *
 * @param string $input
 * @return string cleaned
 */
function sanitizeFilenamePart($input) {
	return filter_var($input, FILTER_SANITIZE_STRING);
	/*
	static $unacceptable = '[^[:alnum:]-_.]';
	return preg_filter($unacceptable, '_', $input);
	*/
}


/** @brief Cleans up other general input
 *
 *
 * @param string $input
 * @return string cleaned
 */
function sanitizeLine($input) {
	return filter_var($input, FILTER_SANITIZE_STRING);
	/*
	static $unacceptable = '[^[:alnum:][:punct:][:space:]]';
	return str_replace(array('<?', '?>'), '', preg_filter($unacceptable, '_', $input));
	*/
}


?>
