<?php

include("../conexao.mysqli.php");

if (isset($_POST['email']) || isset($_POST['senha'])) {

    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = md5($mysqli->real_escape_string($_POST['senha']));

    $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha' AND funcao = 0";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução: " . $mysqli->error);

    $quantidade = $sql_query->num_rows;

    if ($quantidade == 1) {
        $usuario = $sql_query->fetch_assoc();
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['logado'] = true; // Definindo a sessão "logado" como verdadeira
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nomecompleto'];

        header("Location: home.php");
        exit();
    } else {
        echo "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi bi-exclamation-triangle me-2' role='img' aria-label='Cuidado:'></i><div>E-mail e/ou senha inseridos estão errados</div></div>";
    }
}

?>
