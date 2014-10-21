<?php

function getDownloadURL($ext) {
        return 'download.php?' . http_build_query(array_merge(array("ext" => $ext), $_GET));
}
function getDownloadLink($ext) {
        return '<a href="' . getDownloadURL($ext) . '">' . "Click to download the .$ext file</a>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="generator" content=
  "HTML Tidy for Linux (vers 25 March 2009), see www.w3.org" />

  <title>C++ Boilerplate Generator - Download Page</title>
</head>

<body>
  <ul>
    <li><?php echo getDownloadLink("cpp"); ?></li>

    <li><?php echo getDownloadLink("h"); ?></li>

    <li><?php echo getDownloadLink("ch"); ?></li>
  </ul>
</body>
</html>
