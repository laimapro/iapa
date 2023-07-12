<?php include_once('includes/head.php') ?>

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
  <div class="row p-5 align-items-start rounded-3 bg-white  border shadow-lg">
    <div class="col-12 col-md-4 text-center text-lg-start">
      <div class="logo">
        <?php include_once('includes/logo.php') ?>
      </div>
      <div class="menu-nav">
        <h2 class="menu-title" title="Confira as seções das informações necessárias para criar a conta nos links a seguir">
          Criar conta
        </h2>
        <ul class="list-group list-group-flush">
          <li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="#identificacao" title="Insira seu nome, sobrenome ou nome social">Identificação</a></li>
          <li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="#pronomes" title="Escolha um pronome de tratamento e um pronome para referência">Pronomes</a></li>
          <li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="#associacoes" title="Insira o nome da sua instituição de ensino superior e/ou  do programa de pós graduação">Associação</a></li>
          <li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="#acesso" title="Insira email, senha e a função desejada para acessar o IAPA">Acesso</a></li>
          <li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="#idiomas" title="Escolha um ou mais idiomas em que você pode avaliar uma produção acadêmica">Idioma</a></li>
        </ul>
      </div>
    </div>
    <div class="col-12 mx-auto col-md-8">
      <form class="p-3 border rounded-3 bg-body-tertiary" action="processa_cadastro.php" method="POST">

        <fieldset class="mb-4">
          <legend role="h2" id="identificacao">Identificação</legend>
          <div class="row">
            <div class="col-12 col-md">
              <div class="form-floating mb-4">
                <input class="form-control" type="text" id="nome" name="nome" aria-label="Nome" aria-required="true">
                <label for="nome">Nome:</label>
              </div>
            </div>
            <div class="col-12 col-md">
              <div class="form-floating mb-4">
                <input class="form-control" type="text" id="sobrenome" name="sobrenome" aria-label="Sobrenome" aria-required="true">
                <label for="sobrenome">Sobrenome:</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating mb-4">
                <input class="form-control" type="text" id="nomesocial" name="nomesocial" aria-label="nomesocial" aria-required="true">
                <label for="nomesocial">Nome Social:</label>
              </div>
            </div>
        </fieldset>

        <fieldset class="mb-4">
          <legend id="pronomes">Pronomes</legend>
          <div class="row">
            <div class="col-12 col-md">
              <div class="form-floating mb-4">
                <select id="pronomeTratamento" name="pronomeTratamento" aria-label="Pronome de tratamento" class="form-select">
                  <option value="" selected>Escolha uma opção</option>
                  <option value="Senhorita">Senhorita</option>
                  <option value="Senhora">Senhora</option>
                  <option value="Senhor">Senhor</option>
                  <option value="Professora">Professora</option>
                  <option value="Professor">Professor</option>
                  <option value="Especialista">Especialista</option>
                  <option value="Mestre">Mestre</option>
                  <option value="Doutor">Doutor</option>
                </select>
                <label for="pronomeTratamento">Pronome de tratamento:</label>
              </div>
            </div>
            <div class="col-12 col-md">
              <div class="form-floating mb-4">
                <select id="pronomeReferencia" name="pronomeReferencia" aria-label="Pronome para referência" class="form-select">
                  <option value="" selected>Escolha uma opção</option>
                  <option value="ela/dela">Ela / Dela</option>
                  <option value="ele/dele">Ele /Dele </option>
                  <option value="elu/ delu">Elu/ Delu</option>
                </select>

                <label for="pronomeReferencia">Pronome para referência:</label>
              </div>
            </div>
          </div>
        </fieldset>

        <fieldset class="mb-4">
          <legend id="associacoes">Associação</legend>
          <div class="form-floating mb-3">
            <input class="form-control" type="text" id="instituicao" name="instituicao" aria-label="Instituição de ensino superior" aria-required="true" required>
            <label for="instituicao de ensino superior">Instituição de ensino superior, Centro ou Faculdade:</label>
          </div>

          <div class="form-floating mb-3">
            <input class="form-control" type="text" id="curso" name="curso" aria-label="Curso" aria-required="true" required>
            <label for="instituicao">Curso:</label>
          </div>

          <div class="form-floating mb-3">
            <input class="form-control" type="text" id="programadeposgraduacao" name="programadeposgraduacao" aria-label="Programa de Pós-Graduação">
            <label for="programadeposgraduacao">Programa de Pós-Graduação (opcional):</label>
          </div>
        </fieldset>


        <fieldset class="mb-4">
          <legend id="acesso">Acesso</legend>

          <div class="form-floating mb-3">
            <input class="form-control" type="email" id="email" name="email" aria-label="E-mail" aria-required="true" required>
            <label for="email">E-mail:</label>
          </div>

          <div class="form-floating mb-3">
            <input class="form-control" type="password" id="senha" name="senha" aria-label="Senha" aria-required="true" required>
            <label for="senha">Senha</label>
          </div>

          <div class="mb-4">
            <label class="mb-2">Função</label>
            <div class="row">
              <div class="col">
                <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="funcao" id="funcaoAvaliador" value="1"><label class="form-check-label" for="funcaoAvaliador">Avaliador</label></div>
              </div>
              <div class="col">
                <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="funcao" id="funcaoEditor" value="2"><label class="form-check-label" for="funcaoEditor">Editor</label></div>
              </div>
              <div class="col">
                <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="funcao" id="funcaoGerente" value="3"><label class="form-check-label" for="funcaoGerente">Gerente</label></div>
              </div>
            </div>

            <!-- <select class="form-select" id="funcao" name="funcao" aria-label="Função">
                <option value="" selected>Escolha uma opção</option>
                <option value="2">Avaliador</option>
                <option value="1">Editor</option>]
                <option value="3">Gerente</option>
              </select>
              <label for="funcao">Função:</label> -->
          </div>
        </fieldset>


        <fieldset class="mb-4">
          <legend id="idiomas">Idiomas</legend>

          <div class="row">

            <div class="mb-3 col-12 col-md-4">
              <div class="form-check"><input class="form-check-input" type="checkbox" name="idioma[]" id="alemao-checkbox" value="alemao"> <label class="form-check-label" for="alemao-checkbox">Alemão</label></div>
            </div>
            <div class="mb-3 col-12 col-md-4">
              <div class="form-check"><input class="form-check-input" type="checkbox" name="idioma[]" id="espanhol-checkbox" value="espanhol"> <label class="form-check-label" for="espanhol-checkbox">Espanhol</label></div>
            </div>
            <div class="mb-3 col-12 col-md-4">
              <div class="form-check"><input class="form-check-input" type="checkbox" name="idioma[]" id="frances-checkbox" value="frances"> <label class="form-check-label" for="frances-checkbox">Francês</label></div>
            </div>
            <div class="mb-3 col-12 col-md-4">
              <div class="form-check"><input class="form-check-input" type="checkbox" name="idioma[]" id="ingles-checkbox" value="ingles"> <label class="form-check-label" for="ingles-checkbox">Inglês</label></div>
            </div>
            <div class="mb-3 col-12 col-md-4">
              <div class="form-check"><input class="form-check-input" type="checkbox" name="idioma[]" id="libras-checkbox" value="libras"> <label class="form-check-label" for="libras-checkbox">Libras</label></div>
            </div>
            <div class="mb-3 col-12 col-md-4">
              <div class="form-check"><input class="form-check-input" type="checkbox" name="idioma[]" id="portugues-checkbox" value="portugues"> <label class="form-check-label" for="portugues-checkbox">Português</label></div>
            </div>
          </div>
        </fieldset>

        <div class="d-flex justify-content-between">
          <a href="index.php" accesskey="1" title="Volta para a página inicial do IAPA"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
          <button class=" btn btn-primary" type="submit" accesskey="2" title="Salva seus dados e requisita seu acesso no IAPA." onclick="aviso()">Solicitar cadastramento</button>

        </div>
      </form>
    </div>
  </div>
  <script>
    function aviso() {
      window.alert("Solicitação pendente. Seu acesso será liberado assim que for aprovado. Consulte o email cadastrado!")
    }
  </script>

  <?php include_once('includes/footer.php') ?>