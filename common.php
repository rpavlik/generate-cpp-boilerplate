<?php

if(!defined('__DIR__')) {
  define('__DIR__', dirname(__FILE__));
}

$defaults = array(
  'author'=>'Ryan Pavlik
<ryan@sensics.com>
<http://sensics.com>',
  "license"=>'Copyright @YEAR@ Sensics, Inc.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

	http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.',
  'indentation'=>'    '
);

foreach ($defaults as $key=>&$val) {
  $fn = __DIR__ . '/default' . $key . '.txt';
  if (file_exists($fn)) {
    $arr = file($fn);
    if (count($arr) == 0) {
      continue;
    }
    if ($key == 'indentation') {
      # just take the first line
      $val = $arr[0];
    } else {
      $val = implode("\n", array_map("rtrim", $arr));
    }
  }
}

if (file_exists( __DIR__ . '/config.php')) {
  require_once( __DIR__ . '/config.php');
}

$templatemapping = array(
  'cpp'=>'cpp',
  'cxx'=>'cpp',
  'cc'=>'cpp',
  'h'=>'h',
  'hpp'=>'h',
  'hxx'=>'h',
  'ch'=>'ch' // C-safe header file
);

$extmapping = array(
  'ch' => 'h'
);

$mimemapping = array(
  'cpp' => 'text/x-c++src',
  'h' => 'text/x-chdr'
);


function getTemplateType($type) {
	global $templatemapping;
	if (array_key_exists($type, $templatemapping)) {
		return $templatemapping[$type];
	}
	return "";
}

function getExtensionForType($type) {
	global $extmapping;
	if (array_key_exists($type, $extmapping)) {
		return $extmapping[$type];
	}
	return $type;
}

function getMimeForExtension($ext) {
  global $mimemapping;
	if (array_key_exists($ext, $mimemapping)) {
		return $mimemapping[$ext];
	}
	return "application/octet-stream";
}

function makeCIdentifier($str) {
  return strtr($str, '-./', '___');
}
