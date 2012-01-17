<?php
/**
 * external/guid.php
 *
 * @package default
 * @see generate.php
 */

/** @brief PHP function to generate a Version 4 GUID based on IETF RFC 4122: A Universally Unique IDentifier (UUID) URN Namespace
 *
 * Source: http://randomtweak.com/node/54
 *
 * @return string Version 4 GUID
 */
function generateGUID() {
	$guid = '';

	$time_low = str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT);
	$time_mid = str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT);

	$time_high_and_version = mt_rand(0, 255);
	$time_high_and_version = $time_high_and_version & hexdec('0f');
	$time_high_and_version = $time_high_and_version ^ hexdec('40');  // Sets the version number to 4 in the high byte
	$time_high_and_version = str_pad(dechex($time_high_and_version), 2, '0', STR_PAD_LEFT);

	$clock_seq_hi_and_reserved = mt_rand(0, 255);
	$clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved & hexdec('3f');
	$clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved ^ hexdec('80');  // Sets the variant for this GUID type to '10x'
	$clock_seq_hi_and_reserved = str_pad(dechex($clock_seq_hi_and_reserved), 2, '0', STR_PAD_LEFT);

	$clock_seq_low = str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT);

	$node = str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 65535)), 4, '0', STR_PAD_LEFT);

	$guid = $time_low . '-' . $time_mid . '-' . $time_high_and_version . $clock_seq_hi_and_reserved . '-' . $clock_seq_low . '-' . $node;

	return $guid;
}


?>
