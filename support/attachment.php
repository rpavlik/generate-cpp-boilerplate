<?php

function generateAttachment($filename, $mimetype)
{
	header('Content-disposition: attachment; filename=$filename');
	header('Content-type: $mimetype');
}

?>
