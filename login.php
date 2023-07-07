<?php include_once('includes/head.php') ?>
<div class="container px-4 py-5">
  <div class="p-5 rounded-3 bg-white border shadow-lg text-center">
    <img src="img/icone.svg" class="logo  bi me-2" width="100px" height="100px" alt="logotipo do Laima">
    <h2 class="pt-4 mt-5 text-body-emphasis">Boas-vindas ao IAPA 👋</h2>
    <form class="col-lg-8 mx-auto p-5" id="signin" action="" method="POST">
      <h4 class="mb-3">Acesso ao Sistema</h4>
      <?php
      include("conexao.mysqli.php");

      if (isset($_POST['email']) || isset($_POST['senha'])) {

        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = md5($mysqli->real_escape_string($_POST['senha']));

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha' AND aprovacao = 1";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {

          $usuario = $sql_query->fetch_assoc();
          if (!isset($_SESSION)) {
            session_start();
          }
          $_SESSION['id'] = $usuario['id'];
          $_SESSION['nome'] = $usuario['nomecompleto'];

          header("Location: home.php");
        } else {
          echo "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi bi-exclamation-triangle me-2'role='img' aria-label='Cuidado:'></i><div>E-mail e/ou senha inseridos estão errados</div></div>";
        }
      }

      ?>
      <div class="form-floating mb-4">
        <input type="email" id="email" class="form-control" placeholder="E-mail" name="email" required />
        <label for="email">E-mail</label>
      </div>

      <div class="form-floating mb-4">
        <input type="password" id="password" class="form-control" placeholder="Senha" name="senha" required />
        <label for="password">Senha</label>

        <div class="mb-3 divCheck"></div>
        <div class="d-flex align-items-center justify-content-between">
        <a href="index.php"  accesskey="1" title="Volta para a página inicial do IAPA"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
          <button class="btn btn-primary" type="submit" accesskey="2" class="tooltip" aria-label="Entrar" title="Inicia o programa IAPA">Entrar</button>
        </div>
    </form>
    <p class="pt-4 border-top mt-5 text-center mb-0 text-body-secondary">
      Não tem conta? <a href="criar_conta.php" accesskey="3" title="Permite preencher o cadastro para usar o IAPA">Crie sua conta</a>
    </p>

   
  </div>
</div>
</div>
</div>
<script src="js/login.js"></script>
<?php include_once('includes/footer.php') ?>