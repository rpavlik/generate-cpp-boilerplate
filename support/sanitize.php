<?php

function sanitizeFilenamePart($input) {
	static $unacceptable = '[^[:alnum:]-_.]';
	return preg_filter($unacceptable, '_', $input);
}

function sanitizeLine($input) {
	static $unacceptable = '[^[:alnum:][:punct:][:space:]]';
	return str_replace(array('<?', '?>'), '', preg_filter($unacceptable, '_', $input));
}

?>
