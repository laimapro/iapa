<?php
require '../conexao.mysqli.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para obter o hash da senha para o nome de usuário fornecido
    $sql = "SELECT * FROM usuarios WHERE email='$username' AND funcao = 0";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHash = $row["senha"];

        // Verifica a senha fornecida com o hash armazenado
        if (password_verify($password, $storedHash)) {
            echo "Login bem-sucedido!";
            
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['logado'] = true; // Definindo a sessão "logado" como verdadeira
            $_SESSION['id'] = $row['id']; // Usar $row para acessar os dados do usuário
            $_SESSION['nome'] = $row['nomecompleto'];
            header("Location: home.php");
            exit();  // Certifique-se de sair após redirecionar

        } else {
            echo "Usuário ou senha incorretos.";
        }
    } else {
        echo "Usuário ou senha incorretos.";
    }
}

$mysqli->close();
?>
