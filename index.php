<?php include_once('includes/header.php') ?>
<div class="container col-sm-12 col-md-6 px-4 py-5">
    <div class="p-5 rounded-3 bg-white border shadow-lg text-center">
        <!-- <p><span id="saudacao"></span>!<br><i class="mx-2 bi bi-clock"></i>Agora são <span id="horario"></span> </p> -->
        <img src="img/icone.svg" class="logo  bi me-2" width="100px" height="100px" alt="logotipo do Laima">


        <h1 class="mt-4 mb-4 text-body-emphasis">IAPA</h1>
        <p class="lead">Instrumento de Avaliação de Produção Acadêmica</p>
        <div class="col-lg-8 mx-auto text-muted">
            <p>Boas vindas ao IAPA 👋.</p>
            <p>Sou o seu assistente online e estou aqui ter ajudar na construçao da sua avaliação de Produção Acadêmica, ou se você desejar, te guiar a avaliar uma produção acadêmica, de forma simples e eficiente. Para que eu saiba o que você pretende fazer, basta entrar em um dos links abaixo e eu lhe levarei rapidinho para onde você pediu.</p>
            <p>Será um processo tranquilo, te ajudarei em todas as etapas do processo e garantindo que você aproveite ao máximo todos os recursos que o IAPA tem para lhe oferecer.</p>
        </div>
        <!-- <p>Sou Laima, seu assistente online e estou aqui para ajudá-lo(a) a criar seu instrumento de avaliação de Produção acadêmica, ou se você desejar, guia-lo(a) a avaliar uma produção acadêmica, de forma simples e eficiente.</p> -->
        <!-- <p> Fique tranquilo, (a)vou ajudá-lo(a) em todas as etapas do processo e garantir que você aproveite ao máximo todos os recursos que o IAPA tem para lhe oferecer.</p> -->
        <!-- <p>Para que eu saiba o que você pretende fazer, basta entrar em um dos links abaixo e eu lhe levarei rapidinho para onde você pediu.</p> -->
        <nav class="mt-5 d-inline-flex gap-2 mb-5">
            <h2 class="visually-hidden-focusable">Menu</h2>
            <a class="btn px-4 rounded-pill btn-link" href="sobre.php" title="Saiba mais sobre este programa" accesskey="1">Sobre Este Programa</a>
            <a class="btn px-4 rounded-pill btn-link" href="#" title="Conheça mais sobre nossa equipe" accesskey="2">Quem Somos</a>
            <a class="btn px-4 rounded-pill btn-primary" href="login.php" title="Faça login no IAPA" accesskey="3">Inicie IAPA</a>
            <button class="btn px-4 rounded-pill btn-link contrast-btn" onclick="toggleContrast()" title="Alterar a aparência desta página" accesskey="4"><i class="bi bi-circle-half"></i></button>
        </nav>
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