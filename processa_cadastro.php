<?php
session_start();
include("conexao.mysqli.php");

$nome = mysqli_real_escape_string($mysqli, trim($_POST["nome"]));
$sobrenome = mysqli_real_escape_string($mysqli, trim($_POST["sobrenome"]));
$nomesocial = mysqli_real_escape_string($mysqli, trim($_POST["nomesocial"]));
$pronomeTratamento = mysqli_real_escape_string($mysqli, trim($_POST["pronomeTratamento"]));
$pronomeReferencia = mysqli_real_escape_string($mysqli, trim($_POST["pronomeReferencia"]));
$instituicao = mysqli_real_escape_string($mysqli, trim($_POST["instituicao"]));
$curso = mysqli_real_escape_string($mysqli, trim($_POST["curso"]));
$programadeposgraduacao = mysqli_real_escape_string($mysqli, trim($_POST["programadeposgraduacao"]));
$email = mysqli_real_escape_string($mysqli, trim($_POST["email"]));
$senha = password_hash(trim($_POST["senha"]), PASSWORD_BCRYPT);
$funcao = mysqli_real_escape_string($mysqli, trim($_POST["funcao"]));
$idiomas = isset($_POST["idioma"]) ? $_POST["idioma"] : [];

$idiomasSelecionados = implode(",", $idiomas);

// Compose the email message
$subject = "Solicitação de cadastramento no IAPA";
$message = "Olá, $nome!\n\nSua solicitação de cadastramento no IAPA foi recebida e está pendente de aprovação. Seu acesso será liberado assim que for aprovado. Fique atento ao email cadastrado para futuras notificações.\n\nAtenciosamente,\nEquipe Laima - IAPA";

// Send the email
$headers = "From: contato@laima.pro"; // Replace with your email
if (mail($email, $subject, $message, $headers)) {
    
} else {
    echo "Falha no envio do email.";
}

$Emailaviso = "limafj.us@gmail.com";
// Compose the email message for the second recipient
$subject = "Nova solicitação de cadastramento no IAPA";
$message = "Olá,\n\nUma nova solicitação de cadastramento no IAPA foi recebida de $nome ($email). Acesse o sistema para revisar e aprovar a solicitação.\n\nClique no link abaixo para acessar o sistema:\n\nhttp://iapa.laima.pro/admin/\n\nAtenciosamente,\nEquipe Laima - IAPA";

// Send the email to the second recipient
if (mail($Emailaviso, $subject, $message, $headers)) {
   
} else {
    echo "[ERRO - AVISE O SUPORTE]";
}


$sql = "INSERT INTO usuarios (nome, sobrenome, nomesocial, email, senha, pronomeTratamento, funcao, instituicao, curso, programaposgraduacao, idioma, pronomeReferencia)
 VALUES ('$nome', '$sobrenome', '$nomesocial', '$email', '$senha', '$pronomeTratamento', '$funcao','$instituicao','$curso','$programadeposgraduacao','$idiomasSelecionados','$pronomeReferencia')";


if($mysqli->query($sql) === TRUE){
    
}
$mysqli->close();
header('Location: home.php');
exit;


?>