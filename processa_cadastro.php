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

$sql = "INSERT INTO usuarios (nome, sobrenome, nomesocial, email, senha, pronomeTratamento, funcao, instituicao, curso, programaposgraduacao, idioma, pronomeReferencia)
 VALUES ('$nome', '$sobrenome', '$nomesocial', '$email', '$senha', '$pronomeTratamento', '$funcao','$instituicao','$curso','$programadeposgraduacao','$idiomasSelecionados','$pronomeReferencia')";


if($mysqli->query($sql) === TRUE){
    
}
$mysqli->close();
header('Location: home.php');
exit;


?>