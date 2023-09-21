<!DOCTYPE html>
<html>
<head>
    <title>IAPA</title>
</head>
<body>
    <h1>Visualizador PDF | IAPA</h1>
    <a href="upload.php" accesskey="1" >Voltar para banco de produções e pareceres </a>
    <?php
    if (isset($_GET['diretorio']) && isset($_GET['arquivo'])) {
        $diretorio = $_GET['diretorio'];
        $arquivo = $_GET['arquivo'];
        $caminho_arquivo = $diretorio . $arquivo;

        echo '<iframe src="' . $caminho_arquivo . '" width="100%" height="800px"></iframe>';
    } else {
        echo '<p>Parâmetros inválidos.</p>';
    }
    ?>
</body>
</html>
