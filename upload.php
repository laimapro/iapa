<?php
session_start();
include('conexao.mysqli.php');

// Função para verificar e filtrar dados
function filtrarDados($conexao, $dados) {
    $dados = mysqli_real_escape_string($conexao, $dados);
    $dados = htmlspecialchars($dados, ENT_QUOTES, 'UTF-8');
    return $dados;
}

// Função para gerar token CSRF
function gerarTokenCSRF() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

// Função para verificar token CSRF
function verificarTokenCSRF() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Token CSRF inválido, trate o erro ou redirecione o usuário
        die("Token CSRF inválido.");
    }
}

// Função para verificar se o usuário está autenticado
function verificarAutenticacao() {
    if (!isset($_SESSION['id'])) {
        // Se o usuário não estiver autenticado, redireciona para a página de login
        header("Location: index.php");
        exit();
    }
}

// Verificar a autenticação em todas as páginas que exigem login
verificarAutenticacao();

gerarTokenCSRF();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>IAPA - Instrumento de Avaliação de Produção Acadêmica</title>
</head>
<body>
<img src="img/cropped-logo.png" alt="Logotipo do Laima" lang='en'><span aria-label="Laboratory of Artificial Intelligence and Machine AID" lang="en-us">Laboratory of Artificial Intelligence and Machine AID</span> da Universidade Federal de Pernambuco (UFPE)</span>
<?php
include('conexao.mysqli.php');

// Verifique se o usuário está logado (se o ID do usuário está definido na sessão)
if (isset($_SESSION['id'])) {
    $idUsuario = filtrarDados($mysqli, $_SESSION['id']);

    // Consulta para obter todos os dados do usuário com base no ID
    $sql = "SELECT * FROM usuarios WHERE id = ? AND aprovacao = 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Exibe os dados do usuário
        $row = $result->fetch_assoc();
        $nomeUsuario = filtrarDados($mysqli, $row["nome"]);
        $sobrenomeUsuario = filtrarDados($mysqli, $row["sobrenome"]);
        $funcao = filtrarDados($mysqli, $row["funcao"]);
        $instituicao = filtrarDados($mysqli, $row["instituicao"]);
        $curso = filtrarDados($mysqli, $row["curso"]);
        $programadeposgraduacao = filtrarDados($mysqli, $row["programaposgraduacao"]);
        $pronomeTratamento = filtrarDados($mysqli, $row["pronomeTratamento"]);
        $nomesocial = filtrarDados($mysqli, $row["nomesocial"]);

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
        <?php
        if ($funcao == 1 || $funcao == 3 || $funcao == 0) {
            ?>
            <h1>Banco de Produções Acadêmicas</h1>

            <form action="#" method="post" enctype="multipart/form-data">
                <?php
                // Definir token CSRF
                gerarTokenCSRF();
                ?>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <label for="arquivo">Selecione um arquivo PDF para Enviar para o Banco de Produções Acadêmicas:</label>
                <input type="file" name="arquivo" id="arquivo" accept=".pdf" required>
                <input type="submit" value="Enviar Produção">
            </form>

            <?php
            // Resto do processamento do formulário...
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    verificarTokenCSRF();

    // Verificar o tamanho do arquivo
    $tamanhoMaximo = 10 * 1024 * 1024; // 10 MB
    if ($_FILES['arquivo']['size'] > $tamanhoMaximo) {
        die("O arquivo enviado é muito grande. O tamanho máximo permitido é de 10MB.");
    }

    // Verificar o tipo de arquivo
    $tiposPermitidos = array('application/pdf');
    if (!in_array($_FILES['arquivo']['type'], $tiposPermitidos)) {
        die("Tipo de arquivo inválido. Apenas arquivos PDF são permitidos.");
    }

      // Diretório de destino para salvar o arquivo
      $targetDir = "ARQUIVOS_RECEBIDOS/";

      // Obter o nome do arquivo original
      $originalFileName = $_FILES['arquivo']['name'];
  
      // Gerar um número aleatório
      $randomNumber = mt_rand();
  
      // Obter a extensão do arquivo
      $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
  
      // Gerar o novo nome do arquivo
      $fileName = $originalFileName . '_' . $randomNumber . '.' . $fileExtension;
  
      // Caminho completo do arquivo no diretório de destino
      $targetPath = $targetDir . $fileName;

    // Mover o arquivo temporário para o diretório de destino
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $targetPath)) {
        // O arquivo foi salvo com sucesso

        $sql = "INSERT INTO upload (arquivo, usuario, instituicao, curso, posgraduacao, datapostagem) VALUES (?, ?, ?, ?, ?, NOW())";

        // Preparar a declaração SQL
        $stmt = $mysqli->prepare($sql);
        
        // Atribuir os valores aos parâmetros
        $stmt->bind_param("sssss", $fileName, $idUsuario, $instituicao, $curso, $programadeposgraduacao);
        
        // Executar a consulta
        $stmt->execute();

        echo "O arquivo foi enviado e salvo com sucesso.";
    } else {
        echo "Ocorreu um erro ao enviar o arquivo.";
    }
}

        }

        echo "<h1>Listar Produções acadêmicas no Banco</h1> <br>";

        $targetDir = "ARQUIVOS_RECEBIDOS/";

        $avaliado = "PRODUCOES.AVALIADAS/";

        // Obtenha a lista de arquivos no diretório
        $fileList = glob($targetDir . "*.pdf");

        $Listadearquivos = glob($avaliado . "*.pdf");

        // Verifique se há arquivos no diretório
        if (empty($fileList)) {
            echo "Nenhum arquivo encontrado no diretório.";
            exit;
        }
        ?>


        <?php
            // Obtém a lista de arquivos do banco de dados
            $sql = "SELECT * FROM upload WHERE instituicao = ? AND curso = ? AND posgraduacao = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sss", $instituicao, $curso, $programadeposgraduacao);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo '<label for="arquivo_selecionado">Selecione uma Produção Acadêmica:</label>';
                echo '<select name="arquivo_selecionado" id="arquivo_selecionado">';
                while ($row = $result->fetch_assoc()) {
                    $fileName = $row['arquivo'];
                    echo '<option value="' . urlencode($fileName) . '">' . $fileName . '</option>';
                }
                echo '</select>';
            } else {
                echo "Nenhum arquivo enviado.";
            }


        ?>

        <button onclick="visualizarSelecionado()">Visualizar Produção</button>

        <script>
            function visualizarSelecionado() {
                var select = document.getElementById('arquivo_selecionado');
                var selecionado = select.options[select.selectedIndex].text; // Obter o nome do arquivo em vez do valor

                if (selecionado) {
                    window.open("ARQUIVOS_RECEBIDOS/" + selecionado, "_blank"); // Abrir o arquivo com o caminho correto
                } else {
                    alert("Nenhum arquivo selecionado.");
                }
            }
        </script>

        <?php if ($funcao == 3 || $funcao == 2 || $funcao == 0) { ?>
            <h1>Meus Pareceres:</h1><br>
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
                echo '<label for="arquivo_avaliacao_selecionado">Escolha um Parecer para Visualizar:</label>';
                echo '<select name="arquivo_avaliacao_selecionado" id="arquivo_avaliacao_selecionado">';
                foreach ($fileList as $file) {
                    $fileName = basename($file);
                    echo '<option value="' . urlencode($fileName) . '">' . $fileName . '</option>';
                }
                echo '</select>';
            } else {
                echo "Nenhuma avaliação encontrada no banco de dados.";
            }
            ?>
            <button onclick="visualizarAvaliacaoSelecionada()">Visualizar Parecer</button>

            <script>
                function visualizarAvaliacaoSelecionada() {
                    var select = document.getElementById('arquivo_avaliacao_selecionado');
                    var selecionado = select.options[select.selectedIndex].text; // Obter o nome do arquivo em vez do valor

                    if (selecionado) {
                        window.open("PRODUCOES.AVALIADAS/" + selecionado, "_blank"); // Abrir o arquivo com o caminho correto
                    } else {
                        alert("Nenhum arquivo selecionado.");
                    }
                }
            </script>
        <?php } ?>
        <br>
        <br><br>

        <a href="home.php" title="Voltar para página inicial do IAPA" accesskey="1" title ="Pressione 1 para voltar para a página inicial">
            Voltar para a página inicial
        </a> <br>
        <a href="avaliacao.php" title="Avançar para avaliação" accesskey="2" title="Pressione 2 para avançar para a avaliação">
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
