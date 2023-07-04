<?php
include_once('../conexao.mysqli.php');
include('verifica.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Atualizar o campo "aprovacao" para 2
    $sql = "UPDATE usuarios SET aprovacao = 2 WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result) {
        echo "Usuário rejeitado com sucesso. <br><a href='home.php'>Voltar</a>";
    } else {
        echo "Ocorreu um erro ao rejeitar o usuário.";
    }
} else {
    echo "ID do usuário não fornecido.";
}

$mysqli->close();
?>
