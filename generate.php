<?php
include("external/guid.php");
include("support/attachment.php");

$extmapping = array(
	"cpp"=>"cpp",
	"cxx"=>"cpp",
	"cc"=>"cpp",
	"h"=>"h",
	"hpp"=>"h",
	"hxx"=>"h"
)

$mimemapping = array(
	"cpp" = "text/x-c++src",
	"h" = "text/x-chdr"
)


$ext = filter_var($_GET["ext"], FILTER_SANITIZE_STRING);
$filebase = filter_var($_GET["filebase"], FILTER_SANITIZE_STRING);

if (!array_key_exists($extmapping, $ext) {
	die("Bad value for 'ext'");
}

$tpl = $extmapping[$ext]
$mimetype = $mimemapping[$tpl]

$filename = $filebase . "." . $ext;

$year = date("Y");

$def = "INCLUDED_" . $filebase . "_" . $ext . "_GUID_" . strtr(strtoupper(generateGUID()), "-./", "___");

generateAttachment($filename, $mimetype);

include("templates/" . $tpl . ".tpl")
?>
