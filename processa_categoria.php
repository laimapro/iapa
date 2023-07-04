<?php
include('conexao.mysqli.php');
session_start();

// Verifique se o usuário está logado (se o ID do usuário está definido na sessão)
if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id'];

    // Consulta para obter todos os dados do usuário com base no ID
    $sql = "SELECT * FROM usuarios WHERE id = $idUsuario";
    $result = $mysqli->query($sql);

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
        $posgraduacao = isset($row["posgraduacao"]) ? $row["posgraduacao"] : '';

        $nomeCategoria = isset($_POST['nomeCategoria']) ? $_POST['nomeCategoria'] : '';
        $nomeCategoria = filter_var($nomeCategoria, FILTER_SANITIZE_STRING);

        $stmt = $mysqli->prepare("INSERT INTO categoria (idUsuario, dataCriado, instituicao, curso, posgraduacao, categoria) VALUES (?, NOW(), ?, ?, ?, ?)");
        $stmt->bind_param("issss", $idUsuario, $instituicao, $curso, $posgraduacao, $nomeCategoria);
        $stmt->execute();
        

        echo "Categoria: " .$nomeCategoria. "  cadastrado com sucesso!";
        echo"<br> <a href='pagina_categoria.php'>Voltar</a>";
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
