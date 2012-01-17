

function generateDownloadHeader($filename, $mimetype)
{
	header('Content-disposition: attachment; filename=$filename');
	header('Content-type: $mimetype');
}
