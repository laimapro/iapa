
    <title>IAPA | OPS recurso ainda não está disponível</title>

<?php include_once('includes/head.php') ?>
    <?php
        include('conexao.mysqli.php');
        session_start();

        // Verifique se o usuário está logado (se o ID do usuário está definido na sessão)
        if (isset($_SESSION['id'])) {
            $idUsuario = $_SESSION['id'];

            // Consulta para obter todos os dados do usuário com base no ID
            $sql = "SELECT * FROM usuarios WHERE id = $idUsuario AND aprovacao = 1";
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
            // Exibe os dados do usuário
            $row = $result->fetch_assoc();
            $nomeUsuario = $row["nome"];
            $sobrenomeUsuario = $row["sobrenome"];
            $emailUsuario = $row["email"];
            $pronomeTratamento = $row["pronomeTratamento"];
            $pronomeReferencia = $row["pronomeReferencia"];
            $nomesocial = $row["nomesocial"];
            $funcao = $row["funcao"];
            // ... outros campos que você possui no banco de dados
    ?>

<div class="container px-4 py-5">
    <div class="p-5 rounded-3 bg-white border shadow-lg">
    <?php include_once('includes/logo.php') ?>
    
    <p>Olá 👋 <?php echo $pronomeTratamento; ?> <strong><?php if ($nomesocial != null) {echo $nomesocial;} else {echo $nomeUsuario;echo " ";echo $sobrenomeUsuario;} ?></strong>, Agora são <span id="horario"></span> .<span id="saudacao"></span>!</p>
    <p>Este recurso ainda não está disponível.</p><a href="home.php" accesskey="1" title="Volta para página inicial do IAPA">Voltar</a>
</div>

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
<?php include_once('includes/footer.php') ?>