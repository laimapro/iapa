<?php
include_once('../conexao.mysqli.php');
include('verifica.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtenha o e-mail do usuário
    $emailQuery = "SELECT email FROM usuarios WHERE id = $id";
    $emailResult = $mysqli->query($emailQuery);
    $row = $emailResult->fetch_assoc();
    $userEmail = $row['email'];

    // Atualize a aprovação do usuário
    $sql = "UPDATE usuarios SET aprovacao = 1 WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result) {
        // Aprovado com sucesso, envie o e-mail
        $to = $userEmail;
        $subject = 'Aprovação de Cadastro';
        $message = 'Seu cadastro foi aprovado. Agora você pode acessar o sistema. Clique no link abaixo para acessar o sistema: http://iapa.laima.pro Atenciosamente, Equipe Laima - IAPA';

        $headers = 'From: contato@laima.pro' . "\r\n" .
            'Reply-To: contato@laima.pro' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Envia o e-mail
        mail($to, $subject, $message, $headers);

        echo "Usuário aprovado com sucesso. Um e-mail de confirmação foi enviado para o usuário.<br><a href='home.php'>Voltar</a>";
    } else {
        echo "Ocorreu um erro ao aprovar o usuário.";
    }
} else {
    echo "ID do usuário não fornecido.";
}

$mysqli->close();
?>
