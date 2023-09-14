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
    
    <p>Olá 👋 <?php echo $pronomeTratamento; ?> <strong><?php if ($nomesocial != null) {echo $nomesocial;} else {echo $nomeUsuario;echo " ";echo $sobrenomeUsuario;} ?></strong>, boas-vindas ao <strong>IAPA.</strong> Agora são <span id="horario"></span> .<span id="saudacao"></span>!</p>
    <p>Sou Laima, seu assistente online e estou aqui para ajudá-lo(a) a criar seu instrumento de avaliação de Produção acadêmica, ou se você desejar, guia-lo(a) a avaliar uma produção acadêmica, de forma simples e eficiente.</p>
    <p> Fique tranquilo(a), ou ajudá-lo(a) em todas as etapas do processo e garantir que você aproveite ao máximo todos os recursos que o IAPA tem a oferecer. Siga minhas orientações e verá como vai ser fácil! Para que eu saiba o que você pretende fazer, basta pressionar um dos botões abaixo. Estamos entendidos? Então, vamos começar. É com você agora.</p>
    <ul class="my-5 list-group list-group-flush">
        <?php if ($funcao == 2 || $funcao == 3  || $funcao == 0) {?><li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="avaliacao.php" accesskey="1" title="Alt + 1: Permite iniciar a avaliação de uma PA">Avaliar uma Produção Acadêmica</a></li>
        <?php } if ($funcao == 2 || $funcao == 3  || $funcao == 0) {?><li class="px-0 list-group-item"><a class="text-decoration-none d-block"  href="avaliacao_em_construcao.php" accesskey="2" title="Alt + 2: Permite retomar a avaliação de uma PA">Continuar avaliação de uma produção acadêmica</a></li><?php } ?>
        <li class="px-0 list-group-item"><a class="text-decoration-none d-block"  href="upload.php" accesskey="3" title="Alt + 3: Permite ver e interagir com suas avaliações salvas">Banco de avaliações</a></li>
        <?php if ($funcao == 1 || $funcao == 3  || $funcao == 0) { ?><li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="pagina_categoria.php" title="Alt + 4: Permite criar um novo IAPA" accesskey="4">Criar um Instrumento de Avaliação de Produção Acadêmica</a></li>
        <?php } if ($funcao == 1 || $funcao == 3  || $funcao == 0) { ?><li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="IAPA_em_construcao.php" accesskey="5" title="Alt + 5: Permite editar um IAPA em construção">Continuar a edição de um Instrumento de Avaliação Acadêmica</a></li><?php } ?>
        <?php  if ($funcao == 3) { ?><li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="admin/index.php" accesskey="," title="Alt + ,: Área administrativa">Área administrativa</a></li><?php } ?>
            <li class="pt-5 px-0 list-group-item"><a href="sair.php" title="Alt + 6: Será necessário fazer login para entrar no IAPA novamente" accesskey="6"><i class="bi bi-arrow-left me-1"></i>Voltar para a página inicial</a></li>
    </ul>
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