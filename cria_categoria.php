<?php 
include("includes/logo.php");
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IAPA</title>
</head>
<body>
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
?>


<h1>Instrumento de avaliação de produção Acadêmica</h1>
<h3>Olá, <?php echo $pronomeTratamento; echo " ";
if ($nomesocial != null) {
    echo $nomesocial;
} else {
    echo $nomeUsuario; echo " "; echo $sobrenomeUsuario;
}
?></h3>

<p>Agora são: <span id="horario"></span> <span id="saudacao"></span></p>

<script>
    var agora = new Date();
    var horas = agora.getHours();

    var saudacao = "";

    if (horas >= 01 && horas < 12) {
        saudacao = "Bom dia";
    } else if (horas >= 12 && horas < 18) {
        saudacao = "Boa tarde";
    } else {
        saudacao = "Boa noite";
    }

    var minutos = agora.getMinutes();
    var segundos = agora.getSeconds();

    // Formate a hora para exibir sempre dois dígitos
    if (horas < 10) {
        horas = "0" + horas;
    }
    if (minutos < 10) {
        minutos = "0" + minutos;
    }
    if (segundos < 10) {
        segundos = "0" + segundos;
    }

    // Atualize o conteúdo da span com o horário e a saudação
    document.getElementById("horario").textContent = horas + ":" + minutos + ":" + segundos;
    document.getElementById("saudacao").textContent = saudacao;

</script>


<br>
<h1>Crie a categoria: </h1>
<form action="processa_categoria.php" method="post">
    <label for="Para criar a categoria digite o nome dela">Digite o nome da categoria:</label>
    <input type="text" name="nomeCategoria">
    <input type="submit" value="Cadastrar">

</form>






















<?php
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
</body>
</html>