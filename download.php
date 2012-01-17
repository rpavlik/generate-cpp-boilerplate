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
echo $ext;
echo $filebase;
?>
<?php
generateBoilerplate(array('ext' => $ext,'filebase' => $filebase));
?>
done with the whole thing
