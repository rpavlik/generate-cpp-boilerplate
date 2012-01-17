<?php
/**
 * download.php
 *
 * @package default
 */


error_reporting(E_ALL);

require 'support/sanitize.php';
require 'generate.php';
generateBoilerplate(array(
		'ext' => sanitizeFilenamePart($_GET['ext']),
		'filebase' => sanitizeFilenamePart($_GET['filebase'])
	)
);
?>
