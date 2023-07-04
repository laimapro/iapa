<?php
include_once('../conexao.mysqli.php');
include('verifica.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $sql = "UPDATE usuarios SET aprovacao = 1 WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result) {
        echo "Usuário aprovado com sucesso. <br> <a href='home.php'>Voltar</a>";

    } else {
        echo "Ocorreu um erro ao aprovar o usuário.";
    }
} else {
    echo "ID do usuário não fornecido.";
}

$mysqli->close();
?>
