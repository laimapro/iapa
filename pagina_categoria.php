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
        $funcao = $row["funcao"];
        $programaposgraduacao = $row["programaposgraduacao"];
?>

<img src="img/cropped-logo.png" alt="Logotipo do Laima" lang="en">
<span aria-label="Laboratory of Artificial Intelligence and Machine AID" lang="en-us">Laboratory of Artificial Intelligence and Machine AID</span>
da Universidade Federal de Pernambuco (UFPE)

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
<h1>Agora que estamos aqui, escolha uma das produções acadêmicas, pressione o botão Continuar e eu lhe levarei para o próximo passo:</h1>
<br>

<form action="pagina_itens.php" method="get">
    <label for="categorias" class="tooltip" aria-label="Escolha o tipo de produção acadêmica" role="tooltip">Produção acadêmica:</label>
    <select id="categorias" name="categorias">
        <option value="PreProjeto">Pré-projeto</option>
        <option value="Projeto">Projeto</option>
        <option value="TCC">TCC</option>
        <option value="Monografia">Monografia</option>
        <option value="Dissertacao">Dissertação</option>
        <option value="Tese">Tese</option>
        <option value="ArtigoCientifico">Artigo Científico</option>
        <option value="ArtigoOpiniao">Artigo de Opinião</option>
        <option value="AudioDescricao">Áudio-descrição</option>
        <option value="Comunicacao">Comunicação</option>
        <option value="Ensaio">Ensaio</option>
        <option value="Entrevista">Entrevista</option>
        <option value="Resenha">Resenha</option>
        <option value="Resumo">Resumo</option>
        <option value="ResumoEstendido">Resumo estendido</option>
        <option value="RelatoExperiencia">Relato de Experiência</option>
        <option value="Relatorio">Relatório</option>
        <option value="Traducao">Tradução</option>
        <?php
        // Consulta na tabela categoria para obter os campos
        $sql = "SELECT * FROM categoria WHERE instituicao = '$instituicao' AND curso = '$curso' AND posgraduacao = '$programaposgraduacao'";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['categoria'] . '">' . $row['categoria'] . '</option>';
            }
        }

        ?>
    </select>

    <br>
    <input type="submit" Value="Inicia a Construção do IAPA Escolhido" accesskey="2" class="tooltip" aria-label="continuar" role="button">
</form>
<?php  if($funcao == 0 || $funcao == 2 || $funcao == 3){ ?><a href="cria_categoria.php">Não tem categoria pretendida? Crie aqui</a> <br><?php } ?>
<button onclick="window.location.href='home.php'" accesskey="1" title="Volta para a página inicial do IAPA">
  Voltar
</button>

<script>
    document.getElementById("categorias").addEventListener("change", function() {
        document.getElementById("categoriasHidden").value = this.value;
    });
</script>

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
