<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>IAPA - Instrumento de Avaliação de Produção Acadêmica</title>
    <style>
        /* Estilos adicionais para melhorar a visualização */
        body {
            font-family: Arial, sans-serif;
        }
        
        h1 {
            font-size: 24px;
        }
        
        h3 {
            font-size: 18px;
        }
        
        a {
            display: block;
            margin-bottom: 10px;
        }
        
        .tooltip {
            position: relative;
            display: inline-block;
        }
        
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>
<img src="img/cropped-logo.png" alt="Logotipo do Laima" lang='en'><span aria-label="Laboratory of Artificial Intelligence and Machine AID" lang="en-us">Laboratory of Artificial Intelligence and Machine AID</span> da Universidade Federal de Pernambuco (UFPE)</span>
    <?php
    include('conexao.mysqli.php');
    session_start();
    
    // Verifique se o usuário está logado (se o ID do usuário está definido na sessão)
    if (isset($_SESSION['id'])) {
        $idUsuario = $_SESSION['id'];
    
        // Consulta para obter todos os dados do usuário com base no ID
        $sql = "SELECT * FROM usuarios WHERE id = $idUsuario AND aprovacao = 1";
        $result = $mysqli->query($sql);
    
        if ($result->num_rows > 0) {
            // Exibe os dados do usuário
            $row = $result->fetch_assoc();
            $nomeUsuario = $row["nome"];
            $sobrenomeUsuario = $row["sobrenome"];
            $funcao = $row["funcao"];
            $instituicao = $row["instituicao"];
            $curso = $row["curso"];
            $programadeposgraduacao = $row["programaposgraduacao"];
            $pronomeTratamento = $row["pronomeTratamento"];
            $nomesocial = $row["nomesocial"];
    
            ?>
            <h1>Instrumento de avaliação de produção Acadêmica</h1>
            <p id="orientacao"> Oi, <?php echo $pronomeTratamento; echo " "; if ($nomesocial != null){echo $nomesocial;}else{echo $nomeUsuario; echo " "; echo $sobrenomeUsuario;} ?>
            <p>Agora são: <span id="horario"></span> <span id="saudacao"></span></p><br>
            <script>
                var agora = new Date();
                var horas = agora.getHours();
    
                var saudacao = "";
    
                if (horas >= 1 && horas < 12) {
                    saudacao = "Bom dia";
                } else if (horas >= 12 && horas < 18) {
                    saudacao = "Boa tarde";
                } else {
                    saudacao = "Boa noite";
                }
    
                var minutos = agora.getMinutes();
                var segundos = agora.getSeconds();
    

                if (horas < 10) {
                    horas = "0" + horas;
                }
                if (minutos < 10) {
                    minutos = "0" + minutos;
                }
                if (segundos < 10) {
                    segundos = "0" + segundos;
                }
    
                // Atualize o conteúdo da span com o horário e a saudação
                document.getElementById("horario").textContent = horas + ":" + minutos + ":" + segundos;
                document.getElementById("saudacao").textContent = saudacao;
            </script>
            <?php if($funcao == 1 || $funcao == 3 || $funcao == 0){
            ?>
            <h1>Submeter arquivo para avaliação</h1>

            <form action="#" method="post" enctype="multipart/form-data">
                <input type="file" name="arquivo" id="arquivo">
                <input type="submit" value="Salvar e visualizar">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $targetDir = "ARQUIVOS_RECEBIDOS/"; // Diretório onde os arquivos estão armazenados
                $targetFile = $targetDir . basename($_FILES["arquivo"]["name"]);
                $uploadOk = 1;
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            
                // Verificar se o arquivo é um PDF
                if ($fileType != "pdf") {
                    echo "Apenas arquivos PDF são permitidos.";
                    $uploadOk = 0;
                }
            
                // Verificar se houve algum erro no upload
                if ($uploadOk == 0) {
                    echo "Ocorreu um erro durante o upload do arquivo.";
                } else {
                    if (move_uploaded_file($_FILES["arquivo"]["tmp_name"], $targetFile)) {
                        // Obter apenas o nome do arquivo
                        $originalFileName = basename($targetFile);
                    
                        // Gerar um ID exclusivo com base no horário atual
                        $randomNumber = rand(1,99);
                        
                        // Criar um novo nome de arquivo adicionando o número aleatório antes do nome original
                        $newFileName = $randomNumber . '_' . $originalFileName;
                    
                        // Caminho completo do novo arquivo com o nome alterado
                        $newFilePath = $targetDir . $newFileName;
                    
                        // Renomear o arquivo movendo-o para o diretório de destino
                        if (rename($targetFile, $newFilePath)) {
                            $fileName = $newFileName;
                            
                            $sql = "INSERT INTO upload (arquivo, usuario, instituicao, curso, posgraduacao, datapostagem) VALUES (
                                '$fileName', '$idUsuario', '$instituicao', '$curso', '$programadeposgraduacao', NOW()
                            )";
                            
                            if ($mysqli->query($sql) === TRUE) {
                                // Redirecionar para a página de visualização com o nome do arquivo como parâmetro
                                header("Location: visualizar.php?file=" . urlencode($fileName));
                                exit();
                            } else {
                                echo "Ocorreu um erro ao salvar o arquivo no banco de dados.";
                            }
                        } else {
                            echo "Ocorreu um erro ao renomear o arquivo.";
                        }
                    } else {
                        echo "Ocorreu um erro ao mover o arquivo para o diretório de destino.";
                    }
                    
                }
            }
            
        }






            echo "<h1>Ver produções acadêmicas enviadas</h1> <br>";
 
            $targetDir = "ARQUIVOS_RECEBIDOS/";

            $avaliado = "PRODUCOES.AVALIADAS/";

            // Obtenha a lista de arquivos no diretório
            $fileList = glob($targetDir . "*.pdf");

            $Listadearquivos= glob($avaliado . "*.pdf");

            // Verifique se há arquivos no diretório
            if (empty($fileList)) {
                echo "Nenhum arquivo encontrado no diretório.";
                exit;
            }
            ?>

            <h1>Escolha um arquivo para visualizar:</h1>

            <?php

            $sql1 = "SELECT * FROM upload WHERE instituicao = ? AND curso = ? AND posgraduacao = ?";
            $stmt = $mysqli->prepare($sql1);
            $stmt->bind_param("sss", $instituicao, $curso, $programadeposgraduacao);
            $stmt->execute();
            $result1 = $stmt->get_result();

            if ($result1->num_rows > 0) {
                $fileList = array();

                // Adicionar os nomes de arquivo em um array
                while ($row = $result1->fetch_assoc()) {
                    $fileList[] = $row['arquivo'];
                }

                // Exibir apenas os nomes de arquivo que correspondem aos registros no banco de dados
                foreach ($fileList as $file) {
                    $fileName = basename($file);
                    echo '<input type="radio" name="arquivo" id="' . $fileName . '" value="' . urlencode($fileName) . '">';
                    echo '<label for="' . $fileName . '">' . $fileName . '</label><br>';
                }
            } else {
                echo "Nenhum arquivo enviado.";
            }

            
                ?>

<button onclick="visualizarSelecionado()">Visualizar</button>

<script>
    function visualizarSelecionado() {
        var radios = document.getElementsByName('arquivo');
        var selecionado = null;

        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                selecionado = radios[i].value;
                break;
            }
        }

        if (selecionado) {
            window.open("visualizar.php?file=" + selecionado, "_blank");
        } else {
            alert("Nenhum arquivo selecionado.");
        }
    }
</script>

<?php if($funcao == 3 || $funcao == 2 || $funcao == 0){?>
    <h1>Minhas avaliações:</h1><br>
    <h1>Escolha um arquivo para visualizar:</h1>
    <?php
    $sql = "SELECT * FROM avaliado WHERE idUsuario = ? AND instituicao = ? AND curso = ? AND programaposgraduacao  = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $idUsuario, $instituicao, $curso, $programadeposgraduacao);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $fileList = array();

        // Adicionar os nomes de arquivo em um array
        while ($row = $result->fetch_assoc()) {
            $fileList[] = $row['arquivo'];
        }

        // Exibir apenas os nomes de arquivo que correspondem aos registros no banco de dados
        foreach ($fileList as $file) {
            $fileName = basename($file);
            echo '<input type="radio" name="arquivo_avaliacao" id="' . $fileName . '" value="' . urlencode($fileName) . '">';
            echo '<label for="' . $fileName . '">' . $fileName . '</label><br>';
        }
    } else {
        echo "Nenhuma avaliação encontrada no banco de dados.";
    }
    ?>
    <button onclick="visualizarAvaliacaoSelecionada()">Visualizar</button>

    <script>
        function visualizarAvaliacaoSelecionada() {
            var radios = document.getElementsByName('arquivo_avaliacao');
            var selecionado = null;

            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    selecionado = radios[i].value;
                    break;
                }
            }

            if (selecionado) {
                window.open("visualizar.php?file=" + selecionado, "_blank");
            } else {
                alert("Nenhum arquivo selecionado.");
            }
        }
    </script>
<?php } ?>
            <br>
            <br><br>

            <a href="home.php" title="Volta para página inicial do IAPA" accesskey="1">
                 Voltar para a página inicial
            </a>
            <a href="avaliacao.php" title="Avança para avaliação" accesskey="2">
                 Avançar para Avaliação
            </a>


            <?php
        } else {
            echo "Nenhum usuário encontrado.";
        }

        $mysqli->close();
    } else {
        // Se o usuário não estiver logado, redirecione-o para a página de login
        header("Location: index.php");
        exit();
    }
    ?>
</body>
</html>
