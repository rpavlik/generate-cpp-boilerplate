<?php
/** @brief checks to see if $arr[$k] is a nonempty string
 *
 *
 * @param string $k key
 * @param array $arr array to search
 * @return true or false
 */
function array_has_valid_string_for_key($k, &$arr) {
	return array_key_exists($k, $arr) && strlen($arr[$k]) > 0;
}
?>
