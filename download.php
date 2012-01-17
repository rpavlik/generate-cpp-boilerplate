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
		'authorlines' => sanitizeLine($_GET['authorlines']),
		'filebase' => sanitizeFilenamePart($_GET['filebase'])
	)
);
?>
