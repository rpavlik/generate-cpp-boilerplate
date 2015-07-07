<?php
/**
 * download.php
 *
 * @package default
 */


error_reporting(E_ALL);

require 'support/sanitize.php';
require 'generate.php';
$params = array(
	'ext' => sanitizeFilenamePart($_GET['ext']),
	'filebase' => sanitizeFilenamePart($_GET['filebase'])
);
if (array_key_exists('authorlines', $_GET)) {
	$params['authorlines'] = $_GET['authorlines'];
}
generateBoilerplate($params);

?>
