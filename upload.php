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


                    // Verificar a autenticação em todas as páginas que exigem login
verificarAutenticacao();

gerarTokenCSRF();
            ?>

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row p-5 align-items-start rounded-3 bg-white  border shadow-lg">
        <div class="col-12 col-md-4 text-center text-lg-start">
            <?php include_once('includes/logo.php') ?>
            <h5>Banco de produções e pareceres</h5>
            <div id="toc">
            </div>
        </div>
        <div class="col-12 mx-auto col-md-8">

                    <p id="orientacao">
                        <span id="saudacao"></span>, <span class="text-lowercase"><?php echo $pronomeTratamento; ?></span>
                        <?php if ($nomesocial != null) {
                            echo $nomesocial;
                        } else {
                            echo $nomeUsuario;
                            echo " ";
                            echo $sobrenomeUsuario;
                        } ?>
                        , agora são <span id="horario"></span>
                        <?php
                        if ($funcao == 1 || $funcao == 3 || $funcao == 0) {
                        ?>

                        <form action="mandandopdf.php" method="post" class="pb-5" enctype="multipart/form-data">
                            <fieldset>
                                <legend>
                                    <h2 class="anchor">Cadastrar produções acadêmicas</h2>
                                </legend>
                                <p>Selecione um arquivo PDF para enviar para o banco de dados uma produções acadêmicas.</p>
                                <div class="mb-3">
                                <label for="arquivo" class="form-label">Selecionar arquivo</label>
                                    <input type="file" class="form-control" name="arquivo_pdf" accept=".pdf">
                                    <div id="arquivoHelp" class="form-text">Apenas arquivos no formato PDF são permitidos.</div>

                                    <input type="submit" class="btn btn-outline-primary " value="Cadastrar Produção">
                                </div>
                        </form>


                <?php
                        
                        }

                        $diretorio_recebidos = 'ARQUIVOS_RECEBIDOS/';
                        
                        echo "<fieldset class='mb-5'>
                        <legend><h3 class='anchor'>Visualizar Produções cadastradas</h3></legend>";

                        if (is_dir($diretorio_recebidos)) {
                            // Consulta SQL para recuperar arquivos apenas para o usuário atual
                            $sql = "SELECT arquivo FROM upload WHERE usuario = $idUsuario";
                            $result = $mysqli->query($sql);
                        
                            // Verifica se há arquivos na pasta
                            if ($result->num_rows > 0) {
                                echo '<form method="get" action="exibir_conteudo.php">';
                                echo '<div class="form-floating mb-3">';
                                echo '<input type="hidden" name="diretorio" value="' . $diretorio_recebidos . '">';
                                echo '<select class="form-select" name="arquivo">';
                                while ($row = $result->fetch_assoc()) {
                                    $arquivo_recebido = $row["arquivo"];
                                    echo '<option value="' . $arquivo_recebido . '">' . $arquivo_recebido . '</option>';
                                }
                                echo '</select>';
                                echo '</select><label for="arquivo_selecionado">Selecione uma Produção Acadêmica:</label></div>';
                                echo '<input type="submit" class="btn btn-outline-primary " value="Visualizar Produção">';
                                echo '</form>';
                            } else {
                                echo '<p>Sem conteúdo para Arquivos Recebidos.</p>';
                            }
                        } else {
                            echo '<p>O diretório de Arquivos Recebidos não existe.</p>';
                        }
                        
                            ?>
                    
                        <?php

                    if ($funcao == 3 || $funcao == 2 || $funcao == 0) {?>

                        <fieldset class='mb-5'>
                        <legend>
                            <h3 class='anchor'>Meus pareceres</h3>
                        </legend>
                        <p></p>

                        <?php
                
                        $diretorio_avaliadas = 'PRODUCOES.AVALIADAS/';
                            if (isset($_SESSION['id'])) {
                                $idUsuario = filtrarDados($mysqli, $_SESSION['id']);
                            
                                // Consulta para obter os nomes dos arquivos da tabela "avaliado" correspondentes ao idUsuario
                                $sqlAvaliado = "SELECT arquivo FROM avaliado WHERE idUsuario = ?";
                                $stmtAvaliado = $mysqli->prepare($sqlAvaliado);
                                $stmtAvaliado->bind_param("i", $idUsuario);
                                $stmtAvaliado->execute();
                                $resultAvaliado = $stmtAvaliado->get_result();
                            
                                if ($resultAvaliado->num_rows > 0) {
                                    $arquivosAvaliados = $resultAvaliado->fetch_all(MYSQLI_ASSOC);
                                    $arquivosAvaliadosNomes = array_column($arquivosAvaliados, 'arquivo');
                            
                                    // Filtra os arquivos na pasta que correspondem aos nomes na tabela "avaliado"
                                    $arquivosFiltrados = array_intersect($arquivosAvaliadosNomes, array_diff(scandir($diretorio_avaliadas), array('..', '.')));
                            
                                    if (!empty($arquivosFiltrados)) {
                                        echo '<div class="form-floating mb-3">';
                                        echo '<form method="get" action="exibir_conteudo.php">';
                                        echo '<input type="hidden" name="diretorio" value="' . $diretorio_avaliadas . '">';
                                        echo '<label for="arquivo">Escolha um Parecer para Visualizar:</label></div>';
                                        echo '<select class="form-select" name="arquivo">';
                                        
                                        foreach ($arquivosFiltrados as $arquivo_avaliado) {
                                            echo '<option value="' . $arquivo_avaliado . '">' . $arquivo_avaliado . '</option>';
                                        }
                                        echo '</select>';
                                        echo'<br>';
                                        echo '<input type="submit" class="btn btn-outline-primary "value="Abrir Parecer">';
                                        echo '</form>';
                                    } else {
                                        echo '<p>Sem conteúdo para Produções Avaliadas.</p>';
                                    }
                                } else {
                                    echo '<p>Nenhum arquivo avaliado encontrado para este usuário.</p>';
                                }
                            } else {
                                echo '<p>O usuário não está autenticado.</p>';
                            }


                        ?>
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
                    "Nenhum usuário encontrado.";
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