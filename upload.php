<?php include_once('includes/head.php'); ?>

<?php
session_start();
include('conexao.mysqli.php');

// Função para verificar e filtrar dados
function filtrarDados($conexao, $dados)
{
    $dados = mysqli_real_escape_string($conexao, $dados);
    $dados = htmlspecialchars($dados, ENT_QUOTES, 'UTF-8');
    return $dados;
}

// Função para gerar token CSRF
function gerarTokenCSRF()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

// Função para verificar token CSRF
function verificarTokenCSRF()
{
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Token CSRF inválido, trate o erro ou redirecione o usuário
        die("Token CSRF inválido.");
    }
}

// Função para verificar se o usuário está autenticado
function verificarAutenticacao()
{
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


<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row p-5 align-items-start rounded-3 bg-white  border shadow-lg">
        <div class="col-12 col-md-4 text-center text-lg-start">
            <?php include_once('includes/logo.php') ?>
            <div class="toc">
            </div>
        </div>
        <div class="col-12 mx-auto col-md-8">
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
                    <p>Instrumento de avaliação de produção Acadêmica</p>
                    <p id="orientacao"><span id="saudacao"></span>, <?php echo $pronomeTratamento;
                                                                    echo " ";
                                                                    if ($nomesocial != null) {
                                                                        echo $nomesocial;
                                                                    } else {
                                                                        echo $nomeUsuario;
                                                                        echo " ";
                                                                        echo $sobrenomeUsuario;
                                                                    } ?>
                    <p><i class="mx-2 bi bi-clock"></i>Agora são <span id="horario"></span> <span id="horario"></span>.</p>

                    <?php
                    if ($funcao == 1 || $funcao == 3 || $funcao == 0) {
                    ?>

                        <form action="#" method="post" class="pb-5" enctype="multipart/form-data">
                            <?php
                            // Definir token CSRF
                            gerarTokenCSRF();
                            ?>
                            <fieldset>
                                <legend id="banco-prod-academica">
                                    <h2 class="anchor">Banco de Produções Acadêmicas</h2>
                                </legend>
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <div class="mb-3">
                                    <label for="arquivo" class="form-label">Selecione um arquivo PDF para Enviar para o Banco de Produções Acadêmicas:</label>
                                    <input aria-describedby="arquivoHelp" class="form-control" type="file" name="arquivo" id="arquivo" accept=".pdf" required>
                                    <div id="arquivoHelp" class="form-text">Apenas arquivos no formato PDF</div>
                                    
                                </div>
                                    <button type="submit" class="btn btn-outline-primary ">Enviar Produção</button>
                            </fieldset>
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

                                echo "<div class='mb-5 alert alert-success d-flex align-items-center' role='alert'><i class='bi bi-check-circle-fill me-2'></i>O arquivo foi enviado e salvo com sucesso.</div>";
                            } else {
                                echo "<div class='mb-5 alert alert-danger d-flex align-items-center' role='alert'><i class='bi bi-exclamation-triangle-fill me-2'></i>Ocorreu um erro ao enviar o arquivo.</div>";
                            }
                        }
                    }

                    echo "<fieldset class='mb-5'>
                            <legend id='banco-prod-academica'><h3 class='anchor'>Listar Produções acadêmicas no Banco</h3></legend>";
                    $targetDir = "ARQUIVOS_RECEBIDOS/";

                    $avaliado = "PRODUCOES.AVALIADAS/";

                    // Obtenha a lista de arquivos no diretório
                    $fileList = glob($targetDir . "*.pdf");

                    $Listadearquivos = glob($avaliado . "*.pdf");

                    // Verifique se há arquivos no diretório
                    if (empty($fileList)) {
                        echo "<p>Nenhum arquivo encontrado no diretório.</p>";
                        exit;
                    };
                    ?>


                    <?php
                    // Obtém a lista de arquivos do banco de dados
                    $sql = "SELECT * FROM upload WHERE instituicao = ? AND curso = ? AND posgraduacao = ?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("sss", $instituicao, $curso, $programadeposgraduacao);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo '<div class="form-floating mb-3">';
                        echo '<select class="form-select" name="arquivo_selecionado" id="arquivo_selecionado">';
                        while ($row = $result->fetch_assoc()) {
                            $fileName = $row['arquivo'];
                            echo '<option value="' . urlencode($fileName) . '">' . $fileName . '</option>';
                        }
                        echo '</select><label for="arquivo_selecionado">Selecione uma Produção Acadêmica:</label></div>';
                    } else {
                        echo "Nenhum arquivo enviado.";
                    }
                    ?>
                        <button onclick="visualizarSelecionado()"class="btn btn-outline-primary ">Visualizar Produção</button>
                    </fieldset>


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
                        <fieldset class='mb-5'>
                            <legend id='banco-prod-academica'><h3 class='anchor'>Meus Pareceres:</h3></legend>
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
                            echo '<div class="form-floating mb-3"><select class="form-select" name="arquivo_avaliacao_selecionado" id="arquivo_avaliacao_selecionado">';
                            foreach ($fileList as $file) {
                                $fileName = basename($file);
                                echo '<option value="' . urlencode($fileName) . '">' . $fileName . '</option>';
                            }
                            echo '</select>';
                            echo '<label for="arquivo_avaliacao_selecionado">Escolha um Parecer para Visualizar:</label></div>';
                        } else {
                            echo "<p>Nenhuma avaliação encontrada no banco de dados.</p>";
                        }
                        ?>

                            <button onclick="visualizarAvaliacaoSelecionada()" class="btn btn-outline-primary ">Visualizar Parecer</button>
                    </fieldset>



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
                   
                    <div class="pt-5 d-flex align-items-center justify-content-between">
                    <a href="home.php" title="Voltar para página inicial do IAPA" accesskey="1" title="Pressione 1 para voltar para a página inicial" class="">
                    <i class="bi bi-arrow-left me-1"></i>Voltar para a página inicial
                    </a>
                    <a href="avaliacao.php" title="Avançar para avaliação" accesskey="2" title="Pressione 2 para avançar para a avaliação" class="btn btn-primary">
                        Avançar para Avaliação
                    </a>
                    </div>

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

        </div>
    </div>
</div>
<?php include_once('includes/footer.php') ?>