<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>IAPA - Instrumento de Avaliação de Produção Acadêmica</title>
</head>
<body>
<img src="img/cropped-logo.png" alt="Logotipo do Laima" lang='en'><span aria-label="Laboratory of Artificial Intelligence and Machine AID" lang="en-us">Laboratory of Artificial Intelligence and Machine AID</span> da Universidade Federal de Pernambuco (UFPE)</span>
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
            <h1>Instrumento de avaliação de produção Acadêmica</h1>
            <p><span id="saudacao"></span>!<br><i class="mx-2 bi bi-clock"></i>Agora são <span id="horario"></span>: <span id="horario"></span> <span id="saudacao"></span></p><br>

            <strong>Oi, <?php echo $pronomeTratamento; echo " "; if ($nomesocial != null){echo $nomesocial;}else{echo $nomeUsuario; echo " "; echo $sobrenomeUsuario;} ?>, seja bem-vindo(a) ao IAPA.</strong>
    
        
            <br>
            <h2>
            <p>Sou, Laima, seu assistente online e estou aqui para ajudá-lo(a) a criar seu instrumento de avaliação de Produção acadêmica, ou se você desejar, guia-lo(a) a avaliar uma produção acadêmica, de forma simples e eficiente.</p>

            <p> Fique tranquilo(a), ou ajudá-lo(a) em todas as etapas do processo e garantir que você aproveite ao máximo todos os recursos que o IAPA tem a oferecer.</p>Siga minhas orientações e verá como vai ser fácil!</h2>

            <p>Para que eu saiba o que você pretende fazer, basta pressionar um dos botões abaixo. Estamos entendidos? Então, vamos começar. É com você agora.</p>

            <br>
            <?php
            if($funcao == 2 || $funcao == 3  || $funcao == 0){
                ?>
                <div class="tooltip">
                <a href="avaliacao.php"  accesskey="1" title="Alt + 1: Permite iniciar a avaliação de uma PA">
                    Avaliar uma Produção Acadêmica
                </a>
            </div><br>
            <?php
            }
            if($funcao == 2 || $funcao == 3  || $funcao == 0){
                ?>
            <div class="tooltip">
                <a href="http://" accesskey="2" title="Alt + 2: Permite retomar a avaliação de uma PA">
                    Continuar avaliação de uma produção acadêmica
                </a>
            </div><br>
                <?php } ?>
            <div class="tooltip">
                <a href="upload.php" accesskey="3" title="Alt + 3: Permite ver e interagir com suas avaliações salvas">
                   Banco de avaliações
                </a>
            </div><br>
            <?php
            if($funcao == 1 || $funcao == 3  || $funcao == 0){
                ?>
            <div class="tooltip">
                <a href="pagina_categoria.php" title="Alt + 4: Permite criar um novo IAPA" accesskey="4">
                    Criar um Instrumento de Avaliação de Produção Acadêmica
                </a>
            </div><br>
            <?php
            }if($funcao == 1 || $funcao == 3  || $funcao == 0){
                ?>
            <div class="tooltip">
                <a href="http://" accesskey="5" title="Alt + 5: Permite editar um IAPA em construção">
                    Continuar a edição de um Instrumento de Avaliação Acadêmica
                </a>
            </div><br><?php }?>
            <div class="tooltip">
                <a href="sair.php" title="Alt + 6: Será necessário fazer login para entrar no IAPA novamente" accesskey="6">
                    Voltar para a página inicial
                </a>
            </div>

            <br>

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

