<?php
/**
 * generate.php
 *
 * @package default
 * @see download.php
 */

require_once 'common.php';
require 'external/guid.php';
require 'support/attachment.php';

$indentation = $defaults['indentation'];

$defaultAuthor = $defaults['author'];

$defaultLicense = $defaults['license'];

date_default_timezone_set('America/New_York');

/**
 *
 *
 * @param string $authorinfo
 * @return string author info indented to match the doxygen header
 */
function indentAuthorInfo($authorinfo) {
	global $indentation;
	return implode("\n", array_map(
			function ($line) {
				global $indentation;
				return rtrim($indentation . trim($line));
			},
			explode("\n", $authorinfo)
		)
	);
}


/**
 *
 *
 * @param string $licenseraw
 * @return string license with appropriate comment syntax
 */
function commentLicense($licenseraw) {
	return implode("\n", array_map(
			function ($line) {
				return rtrim('// ' . rtrim($line));
			},
			explode("\n", $licenseraw)
		)
	);
}


/** @brief for each value of KEY, replace @KEY@ in
 *  the input with $vars["KEY"]
 *
 * @param string $input
 * @param array $vars
 * @return string result of replacement
 */
function doSubstitutions($input, $vars) {
	$ret = $input;
	foreach ($vars as $key=>$val) {
		$ret = str_replace("@$key@", $val, $ret);
	}
	return $ret;
}


/** @brief checks to see if $arr[$k] is a nonempty string
 *
 *
 * @param string $k key
 * @param array $arr array to search
 * @return true or false
 */
function array_has_valid_string_for_key($k, $arr) {
	return array_key_exists($k, $arr) && strlen($arr[$k]) > 0;
}


/**
 *
 *
 * @param array $params with at least filebase and ext as required keys,
 * and licenselines and authorlines as optional keys.
 */
function generateBoilerplate($params) {
	$ext = $params['ext'];
	$type = getTemplateType($ext);
	if (strlen($type) == 0) {
			die('Bad value for "ext" - could not look up template type for: ' . $ext);
	}

	$output_ext = getExtensionForType($ext);
	$mimetype = getMimeForExtension($output_ext);

	$filebase = $params['filebase'];
	$filename = $filebase . '.' . $output_ext;

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
		'DEF' => makeCIdentifier('INCLUDED_' . $filebase . '_' . $output_ext . '_GUID_' . strtoupper(generateGUID())) ,
		'FILEBASE' => $filebase,
		'HEADEREXT' => $headerext
	);
	print(doSubstitutions(file_get_contents('templates/' . $type . '.tpl', true), $mysubstitutions));
}


?>
