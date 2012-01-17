<?php
require('external/guid.php');
require('support/attachment.php');

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


function _indentImpl($line) {
	return '\t' . trim($line);
}
function _commentImpl($line) {
	return '// ' . rtrim($line);
}

function indentAuthorInfo($authorinfo) {
	//return implode('\n', array_map('_indentImpl', explode('\n', $authorinfo)));
	return $authorinfo;
}

function commentLicense($licenseraw) {
	//return implode('\n', array_map('_commentImpl', explode('\n', $licenseraw)));
	return $licenseraw;
}

function doSubstitutions($input, $vars) {
	$ret = $input;
	foreach ($vars as $key=>$val) {
		$ret = str_replace('@$key@', $val, $ret);
	}
	return $ret;
}

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

	/*
	if (!array_key_exists($params['ext'], $extmapping)) {
		die('Bad value for 'ext'');
	}
	*/

	$tpl = $extmapping[$params['ext']];
	$mimetype = $mimemapping[$tpl];

	$filename = $params['filebase'] . '.' . $params['ext'];

	// TODO hardcoded hack for prettier templates
	$headerext = '.h';

	$year = date('Y');
	$substitutions = array(
		'YEAR' => $year
	);

	if (array_key_exists('licenselines', $params)) {
		$licenseraw = $params['licenselines'];
	} else {
		$licenseraw = $defaultLicense;
	}
	
	if (array_key_exists('authorlines', $params)) {
		$authorinfo = $params['authorlines'];
	} else {
		$authorinfo = $defaultAuthor;
	}
	$authorlines = doSubstitutions(indentAuthorInfo($authorinfo), $substitutions);
	$license = doSubstitutions(commentLicense($licenseraw), $substitutions);

	$def = 'INCLUDED_' . $filebase . '_' . $ext . '_GUID_' . strtr(strtoupper(generateGUID()), '-./', '___');

	#generateAttachment($filename, $mimetype);

	require('templates/' . $tpl . '.tpl');
}
?>
