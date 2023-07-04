<?php
$file = $_GET["file"];

$filePath = "ARQUIVOS_RECEBIDOS/" . $file;

if (file_exists($filePath) && is_readable($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) == 'pdf') {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $file . '"');
    readfile($filePath);
} else {
    echo "O arquivo selecionado não existe ou não é um arquivo PDF válido.";
}



$filePath1 = "PRODUCOES.AVALIADAS/" . $file;

if (file_exists($filePath1) && is_readable($filePath1) && pathinfo($filePath1, PATHINFO_EXTENSION) == 'pdf') {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $file . '"');
    readfile($filePath1);
} else {
    echo "O arquivo selecionado não existe ou não é um arquivo PDF válido.";
}
?>
