<?php
/**
 * debug.php
 *
 * @package default
 */


?>
<html><body>
<?php
error_reporting(E_ALL);
require "support/sanitize.php";

echo sanitizeFilenamePart($_GET["ext"]);
echo sanitizeFilenamePart($_GET["filebase"]);

?>
</body></html>
