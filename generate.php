<?php
/**
 * generate.php
 *
 * @package default
 * @see download.php
 */


require 'external/guid.php';
require 'support/attachment.php';

// TODO don't hardcode this author and license stuff

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



/**
 *
 *
 * @param unknown $authorinfo
 * @return unknown
 */
function indentAuthorInfo($authorinfo) {
	return implode("\n", array_map(function ($line) {
	return "\t" . trim($line);
}, explode("\n", $authorinfo)));
}


/**
 *
 *
 * @param unknown $licenseraw
 * @return unknown
 */
function commentLicense($licenseraw) {
	return implode("\n", array_map(
		function ($line) {
			return '// ' . rtrim($line);
		}, explode("\n", $licenseraw)));
}


/**
 *
 *
 * @param unknown $input
 * @param unknown $vars
 * @return unknown
 */
function doSubstitutions($input, $vars) {
	$ret = $input;
	foreach ($vars as $key=>$val) {
		$ret = str_replace("@$key@", $val, $ret);
	}
	return $ret;
}

function array_has_valid_string_for_key($k, $arr) {
	return array_key_exists($k, $arr) && strlen($arr[$k]) > 0;
}

/**
 *
 *
 * @param unknown $params
 */
function generateBoilerplate($params /*$ext, $filebase, $authorinfo, $licenseraw*/) {

	$extmapping = array(
		'cpp'=>'cpp',
		'cxx'=>'cpp',
		'cc'=>'cpp',
		'h'=>'h',
		'hpp'=>'h',
		'hxx'=>'h'
	);

	$mimemapping = array(
		'cpp' => 'text/x-c++src',
		'h' => 'text/x-chdr'
	);

	if (!array_has_valid_string_for_key($params['ext'], $extmapping)) {
		die('Bad value for "ext"');
	}
	$ext = $params['ext'];
	$filebase = $params['filebase'];

	$tpl = $extmapping[$ext];
	$mimetype = $mimemapping[$tpl];

	$filename = $filebase . '.' . $ext;

	// TODO hardcoded hack for prettier templates
	$headerext = '.h';

	$year = date('Y');
	$substitutions = array(
		'YEAR' => $year
	);

	if (array_has_valid_string_for_key('licenselines', $params)) {
		$licenseraw = '[LICENSE]' . $params['licenselines'] . '[LICENSE]';
	} else {
		global $defaultLicense;
		$licenseraw = $defaultLicense;
	}

	if (array_has_valid_string_for_key('authorlines', $params)) {
		$authorinfo = $params['authorlines'];
	} else {
		global $defaultAuthor;
		$authorinfo = $defaultAuthor;
	}
	generateAttachment($filename, $mimetype);

	$mysubstitutions = array(
		'YEAR' => $year,
		'AUTHORLINES' => doSubstitutions(indentAuthorInfo($authorinfo), $substitutions),
		'LICENSELINES' => doSubstitutions(commentLicense($licenseraw), $substitutions),
		'DEF' => strtr('INCLUDED_' . $filebase . '_' . $ext . '_GUID_' . strtoupper(generateGUID()), '-./', '___'),
		'FILEBASE' => $filebase,
		'HEADEREXT' => $headerext
	);
	print(doSubstitutions(file_get_contents('templates/' . $tpl . '.tpl', true), $mysubstitutions));
}


?>
