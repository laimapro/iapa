<?php
include('conexao.mysqli.php');
session_start();

// Verifique se o usuário está logado (se o ID do usuário está definido na sessão)
if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id'];

    // Consulta para obter todos os dados do usuário com base no ID
    $sql = "SELECT * FROM usuarios WHERE id = $idUsuario";
    $result = $mysqli->query($sql);
    
    include_once('includes/head.php');
    echo '<div class="container px-4 py-5"><div class="p-5 rounded-3 bg-white border shadow-lg text-center">';
    include_once('includes/logo.php');

    if ($result->num_rows > 0) {
        // Exibe os dados do usuário
        $row = $result->fetch_assoc();
        $nomeUsuario = $row["nome"];
        $sobrenomeUsuario = $row["sobrenome"];
        $pronomeTratamento = $row["pronomeTratamento"];
        $pronomeReferencia = $row["pronomeReferencia"];
        $instituicao = $row["instituicao"];
        $curso = $row["curso"];
        $nomesocial = $row["nomesocial"];
        $posgraduacao = $row["programaposgraduacao"];

        $nomeCategoria = isset($_POST['nomeCategoria']) ? $_POST['nomeCategoria'] : '';
        $nomeCategoria = filter_var($nomeCategoria, FILTER_SANITIZE_STRING);

        $stmt = $mysqli->prepare("INSERT INTO categoria (idUsuario, dataCriado, instituicao, curso, posgraduacao, categoria) VALUES (?, NOW(), ?, ?, ?, ?)");
        $stmt->bind_param("issss", $idUsuario, $instituicao, $curso, $posgraduacao, $nomeCategoria);
        $stmt->execute();
        
        
        echo "<p>Categoria: <strong class='text-uppercase text-success'>".$nomeCategoria. "</strong> cadastrada com sucesso!</p>";
    } else {
        echo "Nenhum usuário encontrado.";
    }
    echo '<div class="btn-action"><a accesskey="1" href="pagina_categoria.php" title="Volta a página inicial do IAPA"><i class="bi bi-arrow-left me-1"></i>Voltar para página inicial</a></li></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    include_once('includes/footer.php');
    
    $mysqli->close();
} else {
    // Se o usuário não estiver logado, redirecione-o para a página de login
    header("Location: index.php");
    exit();
}
?>
