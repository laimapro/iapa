<?php include("includes/head.php"); ?>

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


        <div class="container col-xl-10 col-xxl-8 px-4 py-5">
            <div class="row p-5 align-items-start rounded-3 bg-white  border shadow-lg">
                <div class="col-12 col-md-4 text-center text-lg-start">
                    <?php include_once('includes/logo.php') ?>
                    <div class="menu-nav">
                    </div>
                </div>
                <div class="col-12 mx-auto col-md-8">
                    <p><span id="saudacao"></span>, <?php echo $pronomeTratamento; echo " "; if ($nomesocial != null) { echo $nomesocial; } else { echo $nomeUsuario; echo " "; echo $sobrenomeUsuario;}?></p>
                    <fieldset>
                        <legend>Criar categoria</legend>
                        <form action="processa_categoria.php" method="post">
                            <div class="form-floating my-4">
                                <input  type="text" name="nomeCategoria" class="form-control" id="nomeCategoria" placeholder="Digite o nome da categoria">
                                <label for="nomeCategoria">Digite o nome da categoria</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="pagina_categoria.php"><i class="bi bi-arrow-left me-1"></i>Voltar para criar IAPA</a>
                                <input type="submit" value="Cadastrar" class="btn btn-primary">
                            </div>
                        </form>
                    </fieldset>



                    


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
                </div>
            </div>
        </div>




        <?php include_once('includes/footer.php') ?>