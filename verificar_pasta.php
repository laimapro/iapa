<?php
$folderPath = "IAPA.PARECERES";

if (!file_exists($folderPath) && !is_dir($folderPath)) {
    echo "false";
} else {
    echo "true";
}
?>
