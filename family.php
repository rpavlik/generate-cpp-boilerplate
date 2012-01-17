<?php

function getDownloadURL($ext) {
	return 'download.php?' . http_build_query(array_merge(array("ext" => $ext), $_GET));
}
function getDownloadLink($ext) {
	return '<a href="' . getDownloadURL($ext) . '">' . "Click to download the .$ext file</a>";
}
?>
