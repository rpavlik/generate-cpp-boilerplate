<?php
require('support/sanitize.php');
require('generate.php');
$ext = sanitizeFilenamePart($_GET['ext']);
$filebase = sanitizeFilenamePart($_GET['filebase']);
generateBoilerplate(array('ext' => $ext,'filebase' => $filebase));
?>
