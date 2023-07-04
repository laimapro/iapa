<?php
$folderPath = "IAPA.PARECERES";

if (!file_exists($folderPath) && !is_dir($folderPath)) {
    if (mkdir($folderPath, 0777)) {
        echo "A pasta 'IAPA.PARECERES' foi criada com sucesso.";
    } else {
        echo "Falha ao criar a pasta 'IAPA.PARECERES'.";
    }
} else {
    echo "A pasta 'IAPA.PARECERES' já existe.";
}
?>
