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

$indentation = "    ";

$defaultAuthor =
	'Ryan Pavlik
&lt;ryan@sensics.com&gt;
&lt;http://sensics.com&gt;';

$defaultLicense =
	'Copyright @YEAR@ Sensics, Inc.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

	http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.';

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
				return $indentation . trim($line);
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
				return '// ' . rtrim($line);
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

	$extmapping = array(
		'cpp'=>'cpp',
		'cxx'=>'cpp',
		'cc'=>'cpp',
		'h'=>'h',
		'hpp'=>'h',
		'hxx'=>'h',
		'ch'=>'ch' // C-safe header file
	);

	$mimemapping = array(
		'cpp' => 'text/x-c++src',
		'h' => 'text/x-chdr'
		'ch' => 'text/x-chdr'
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
