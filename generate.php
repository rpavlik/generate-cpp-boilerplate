<?php
require("external/guid.php");
require("support/attachment.php");

$defaultAuthor =
'Ryan Pavlik
<rpavlik@iastate.edu> and <abiryan@ryand.net>
http://academic.cleardefinition.com/
Iowa State University Virtual Reality Applications Center
Human-Computer Interaction Graduate Program';

$defaultLicense =
'          Copyright Iowa State University @YEAR@.
 Distributed under the Boost Software License, Version 1.0.
    (See accompanying file LICENSE_1_0.txt or copy at
          http://www.boost.org/LICENSE_1_0.txt)';


function indentAuthorInfo($authorinfo) {
	return implode("\n", array_map(
		function($line) {
			return "\t" . trim($line);
		}, explode("\n", $authorinfo)));
}

function commentLicense($licenseraw) {
	return implode("\n", array_map(
		function($line) {
			return "// " . rtrim($line);
		}, explode("\n", $licenseraw)));
}

function doSubstitutions($input, $vars) {
	$ret = $input;
	foreach ($vars as $key=>$val) {
		$ret = str_replace("@$key@", $val, $ret);
	}
	return $ret;
}

function generateBoilerplate($ext, $filebase, $authorinfo, $licenseraw) {

	$extmapping = array(
		"cpp"=>"cpp",
		"cxx"=>"cpp",
		"cc"=>"cpp",
		"h"=>"h",
		"hpp"=>"h",
		"hxx"=>"h"
	);

	$mimemapping = array(
		"cpp" => "text/x-c++src",
		"h" => "text/x-chdr"
	);

	if (!array_key_exists($ext, $extmapping)) {
		die("Bad value for 'ext'");
	}

	$tpl = $extmapping[$ext];
	$mimetype = $mimemapping[$tpl];

	$filename = $filebase . "." . $ext;

	$year = date("Y");
	$substitutions = array(
		"YEAR" => $year
	);

	$authorlines = doSubstitutions(indentAuthorInfo($authorinfo), $substitutions);
	$license = doSubstitutions(commentLicense($licenseraw), $substitutions);

	$def = "INCLUDED_" . $filebase . "_" . $ext . "_GUID_" . strtr(strtoupper(generateGUID()), "-./", "___");

	generateAttachment($filename, $mimetype);

	include("templates/" . $tpl . ".tpl");
}
?>
