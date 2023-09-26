<?php include_once('includes/head.php') ?>
<div class="container px-4 py-5">
    <div class="p-5 rounded-3 bg-white border shadow-lg text-center">
        <?php include_once('includes/logo.php') ?>

        <div class=" py-3 text-start col-lg-8 mx-auto my-4 my-4 text-body-secondary">
            <p>👋 <span id="saudacao"></span>! Agora são <span id="horario"></span>. É muito bom ter você por aqui 🙂.</p>
            <p>Sou o seu assistente online e estou aqui para lhe ajudar na construção de seu <strong>Instrumento de Avaliação de Produção Acadêmica</strong>, ou se você desejar, lhe guiar na avaliação de uma produção acadêmica, de forma simples e eficiente. Para que eu saiba o que você pretende fazer, basta entrar em um dos links abaixo e lhe levarei rapidinho para onde você pediu.</p>
        </div>
        <nav class="mt-5 flex-wrap justify-content-center d-inline-flex gap-2 mb-5">
            <h2 class="visually-hidden-focusable">Menu</h2>
            <ul class="d-flex align-items-center flex-wrap flex-md-row flex-column mb-0 list-unstyled">
                <li class="px-3"><a class="btn px-4 rounded-pill btn-link" href="sobre.php" title="Saiba mais sobre este programa" accesskey="1">Sobre Este Programa</a></li>
                <li class="px-3"><a class="btn px-4 rounded-pill btn-link" href="#" title="Conheça mais sobre nossa equipe" accesskey="2">Quem Somos</a></li>
                <li class="px-3"><a class="btn px-4 rounded-pill btn-primary" href="login.php" title="Faça login no IAPA" accesskey="3">Inicie IAPA</a></li>
                <li class="px-3"><button class="btn px-4 rounded-pill btn-link contrast-btn" onclick="toggleContrast()" title="Alterar a aparência da página" accesskey="4"><i class="bi bi-circle-half" title="Alterar a aparência da página"></i></button></li>

            </ul>
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