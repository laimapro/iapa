<?php
session_start();

// Verificar se a sessão "logado" está definida
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    // Remover todas as variáveis de sessão
    session_unset();

    // Destruir a sessão
    session_destroy();
}

// Redirecionar para a página de login (index.php, por exemplo)
header("Location: index.php");
exit();
?>
