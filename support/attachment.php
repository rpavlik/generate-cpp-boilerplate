<?php
/**
 * support/attachment.php
 *
 * @package default
 * @see generate.php
 */


/** @brief Generates headers for downloading an "attachment" that is a
 * generated file.
 *
 * @param string $filename The filename you'd like to give the generated file.
 * @param string $mimetype The mimetype of the generated file.
 */
function generateAttachment($filename, $mimetype) {
	header('Content-disposition: attachment; filename="' . $filename . '"');
	header('Content-type: ' . $mimetype);
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
}


?>
