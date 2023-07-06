<?php include_once('includes/header.php') ?>
<div class="container col-xl-10 col-xxl-8 px-4 py-5">
<div class="row p-5 align-items-start rounded-3 bg-white  border shadow-lg">
    <div class="col-lg-4 col-12 text-center text-lg-start">
      <?php include_once('includes/logo.php') ?>
      <h2 class="pt-4 fs-6 mt-5 text-body-emphasis border-top">IAPA, Instrumento de Avaliação de Produção Acadêmica</h2>
      <p><span id="saudacao"></span>!<br><i class="mx-2 bi bi-clock"></i>Agora são <span id="horario"></span> </p>
    </div>

    <div class="col-md-8 mx-auto col-12">
    <strong>Seja bem-vindo(a) ao IAPA.</strong>

    <script>
        var agora = new Date();
        var horas = agora.getHours();

        var saudacao = "";

        if (horas >= 1 && horas < 12) {
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
    <h2>
        <p>Sou Laima, seu assistente online e estou aqui para ajudá-lo(a) a criar seu instrumento de avaliação de Produção acadêmica, ou se você desejar, guia-lo(a) a avaliar uma produção acadêmica, de forma simples e eficiente.</p>

        <p> Fique tranquilo, (a)vou ajudá-lo(a) em todas as etapas do processo e garantir que você aproveite ao máximo todos os recursos que o IAPA tem para lhe oferecer.</p>
    </h2>

    <p>Para que eu saiba o que você pretende fazer, basta entrar em um dos links abaixo e eu lhe levarei rapidinho para onde você pediu.</p>

    <div class="menu">
        <ul>
            <li><a href="sobre.php" title="Saiba mais sobre este programa" accesskey="1">Sobre Este Programa</a></li>
            <li><a href="#" title="Conheça mais sobre nossa equipe" accesskey="2">Quem Somos</a></li>
            <li><a href="login.php" title="Faça login no IAPA" accesskey="3">Inicie IAPA</a></li>
        </ul>
    </div>

    <br>

    <button class="contrast-btn" onclick="toggleContrast()" title="Altera a aparência desta página" accesskey="4">Contraste</button>

</div>
</div>
</div>
    <script>
        function toggleContrast() {
            var body = document.body;
            var classes = ["contrast-mode", "contrast-mode-1", "contrast-mode-2", "contrast-mode-3", "contrast-mode-dalt"];
            var currentIndex = classes.indexOf(body.className);
            var newIndex = (currentIndex + 1) % classes.length;
            body.className = classes[newIndex];
        }

    </script>
<?php include_once('includes/footer.php') ?>
