<?php
session_start();

// Verificar se o usuário não está logado ou a função é diferente de 0
if (!isset($_SESSION['logado'])) {
    header("Location: index.php");
    exit();
}
?>
