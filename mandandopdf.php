<?php include_once('includes/head.php'); ?>

<?php
session_start();
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
<?php

// Verifica se o usuário está autenticado
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Diretório para salvar os arquivos recebidos
$diretorio_recebidos = 'ARQUIVOS_RECEBIDOS/';

// Verifica se o diretório existe, se não, cria
if (!is_dir($diretorio_recebidos)) {
    mkdir($diretorio_recebidos, 0777, true);
}

// Verifica se um arquivo foi enviado
if (isset($_FILES['arquivo_pdf'])) {
    $arquivo_nome = $_FILES['arquivo_pdf']['name'];
    $arquivo_tmp = $_FILES['arquivo_pdf']['tmp_name'];

    // Move o arquivo para o diretório de recebidos
    move_uploaded_file($arquivo_tmp, $diretorio_recebidos . $arquivo_nome);


    
    // Obtém a data atual no formato desejado (você pode ajustar o formato conforme necessário)
    $dataPostagem = date('Y-m-d H:i:s');

    // Insere os dados no banco de dados
    $sql_inserir_arquivo = "INSERT INTO upload (arquivo, usuario, instituicao, curso, posgraduacao, datapostagem) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_inserir_arquivo = $mysqli->prepare($sql_inserir_arquivo);
    $stmt_inserir_arquivo->bind_param("sissss", $arquivo_nome, $idUsuario, $instituicao, $curso, $programadeposgraduacao, $dataPostagem);
    $stmt_inserir_arquivo->execute();


    // Redireciona de volta para a página principal após o upload
    header("Location: upload.php");
    exit();
}
?>
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