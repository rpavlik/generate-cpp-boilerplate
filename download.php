<?php
require('support/sanitize.php');
require('generate.php');
generateBoilerplate(array(
	'ext' => sanitizeFilenamePart($_GET['ext']),
	'filebase' => sanitizeFilenamePart($_GET['filebase'])
	)
);
?>
