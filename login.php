<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Área exclusiva para Editores e Avaliadores / IAPA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-body-secondary">
  <div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row p-5 align-items-center rounded-3 bg-white  border shadow-lg">
      <div class="col-lg-7 text-center text-lg-start">
        <?php include_once('includes/logo.php') ?>
        <h2 class="pt-4 mt-5 text-body-emphasis">Boas-vindas ao IAPA</h2>
      </div>
    
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-3 border rounded-3 bg-body-tertiary" id="signin" action="" method="POST">
          <h4 class="mb-3">Acesso ao Sistema</h4>
          <?php
          include("conexao.mysqli.php");

          if(isset($_POST['email']) || isset($_POST['senha'])){

          $email = $mysqli->real_escape_string($_POST['email']);
          $senha = md5($mysqli->real_escape_string($_POST['senha']));

          $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha' AND aprovacao = 1";
          $sql_query = $mysqli->query($sql_code)or die("Falha na execução: " . $mysqli->error);

          $quantidade = $sql_query->num_rows;

          if($quantidade == 1){

          $usuario = $sql_query->fetch_assoc();
          if(!isset($_SESSION)){
          session_start();
          }
          $_SESSION['id'] = $usuario['id'];
          $_SESSION['nome'] = $usuario['nomecompleto'];

          header("Location: home.php");

          }else{
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
          <div>

          <div class="mb-3 divCheck"></div>

          <button class="w-100 btn btn-lg btn-primary" type="submit" accesskey="2" class="tooltip" aria-label="Entrar" title="Inicia o programa IAPA">Entrar</button>

         <p class="pt-4 border-top mt-5 text-center mb-0 text-body-secondary">
            Não tem conta? <a href="criar_conta.php" accesskey="3" title="Permite preencher o cadastro para usar o IAPA">Crie sua conta</a>
          </p>
        </form>
  
        <div class="mt-5 d-block text-start">
          <a href="index.php"  accesskey="1" class="btn-link color-text" title="Volta para a página inicial do IAPA">Voltar</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('includes/footer.php') ?>

<script src="js/login.js"></script>
</body>
</html>