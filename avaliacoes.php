<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>IAPA - Instrumento de Avaliação de Produção Acadêmica</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
</head>
<body>
<img src="img/cropped-logo.png" alt="logotipo do Laima">
<span aria-label="Laboratory of Artificial Intelligence and Machine AID" lang="en-us">
    Laboratory of Artificial Intelligence and Machine AID
</span> da Universidade Federal de Pernambuco (UFPE)
<br><br><br>
Clique em um arquivo para visualiza-lo: 

<?php
include('conexao.mysqli.php');
session_start();

if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id'];
    $sql = "SELECT * FROM usuarios WHERE id = $idUsuario";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomeUsuario = $row["nome"];
        $sobrenomeUsuario = $row["sobrenome"];
        $emailUsuario = $row["email"];
        $pronomeTratamento = $row["pronomeTratamento"];
        $pronomeReferencia = $row["pronomeReferencia"];
        $nomesocial = $row["nomesocial"];
        $sql = "SELECT arquivo FROM avaliado WHERE idUsuario = $idUsuario";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            $arquivos = array();
            while ($row = $result->fetch_assoc()) {
                $arquivos[] = $row["arquivo"];
            }

            $directoryPath = 'PRODUCOES.AVALIADAS';

            ?>

            <select id="file-selector">
                <?php
                foreach ($arquivos as $arquivo) {
                    $fullPath = $directoryPath . '/' . $arquivo;
                    echo "<option value='$fullPath'>$arquivo</option>";
                }
                ?>
            </select>

            <!-- Use o visualizador de PDF PDF.js aqui -->
            <div id="pdf-viewer" style="width:100%; height:500px;"></div>

            <script src="PATH_TO_PDFJS/pdf.js"></script> <!-- Substitua PATH_TO_PDFJS com o caminho correto para a biblioteca PDF.js -->
            <script>
                var pdfPath = $('#file-selector').val(); // Caminho inicial do PDF

                // Carregue o PDF inicial
                pdfjsLib.getDocument(pdfPath).promise.then(function(pdf) {
                    pdf.getPage(1).then(function(page) {
                        var scale = 1.5;
                        var viewport = page.getViewport({ scale: scale, });

                        var canvas = document.createElement('canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };

                        $('#pdf-viewer').html(canvas);

                        var renderTask = page.render(renderContext);
                        renderTask.promise.then(function () {
                            console.log('Page rendered');
                        });
                    });
                });

                $('#file-selector').on('change', function() {
                    var pdfPath = $(this).val(); // Obtenha o caminho do PDF selecionado

                    // Carregue o novo PDF
                    pdfjsLib.getDocument(pdfPath).promise.then(function(pdf) {
                        pdf.getPage(1).then(function(page) {
                            var scale = 1.5;
                            var viewport = page.getViewport({ scale: scale, });

                            var canvas = document.createElement('canvas');
                            var context = canvas.getContext('2d');
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            var renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };

                            $('#pdf-viewer').html(canvas);

                            var renderTask = page.render(renderContext);
                            renderTask.promise.then(function () {
                                console.log('Page rendered');
                            });
                        });
                    });
                });
            </script>
            
            <?php
        } else {
            echo "Nenhum arquivo encontrado.";
        }
    } else {
        echo "Nenhum usuário encontrado.";
    }

    $mysqli->close();
} else {
    header("Location: index.php");
    exit();
}
?>

</body>
</html>
