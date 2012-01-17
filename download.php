<?php
$ext = filter_var($_GET["ext"], FILTER_SANITIZE_STRING);
$filebase = filter_var($_GET["filebase"], FILTER_SANITIZE_STRING);

require("generate.php");
generateBoilerplate($ext, $filebase, $defaultAuthor, $defaultLicense);
?>
