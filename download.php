<?php
require('support/sanitize.php');
?>
OK got to load sanitize
<?php
require('generate.php');
?>
got to load generate.
<?php
$ext = sanitizeFilenamePart($_GET['ext']);
$filebase = sanitizeFilenamePart($_GET['filebase']);
?> 
and successfully sanitized.
<?php
generateBoilerplate($ext, $filebase, $defaultAuthor, $defaultLicense);
?>
