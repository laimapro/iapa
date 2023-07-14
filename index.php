<?php include_once('includes/head.php') ?>
<div class="container px-4 py-5">
    <div class="p-5 rounded-3 bg-white border shadow-lg text-center">
        <!-- <p><span id="saudacao"></span>!<br><i class="mx-2 bi bi-clock"></i>Agora são <span id="horario"></span> </p> -->
        <?php include_once('includes/logo.php') ?>

        <div class=" py-3 text-start col-lg-8 mx-auto my-4 my-4 text-body-secondary">
            <p><span id="saudacao"></span> 👋. São <span id="horario"></span> <span id="horario"></span>. Que bom ter você por aqui 🙂.</p>
            <p>Sou o seu assistente online e estou aqui para lhe ajudar na construção de seu instrumento de avaliação de Produção Acadêmica, ou se você desejar, lhe guiar na avaliação de uma produção acadêmica, de forma simples e eficiente. Para que eu saiba o que você pretende fazer, basta entrar em um dos links abaixo e lhe levarei rapidinho para onde você pediu.</p>
            <p>Será um processo tranquilo. Eu lhe ajudarei em todas as etapas do processo, garantindo que você aproveite ao máximo todos os recursos que o IAPA tem a oferecer.</p>
        </div>
        <!-- <p>Sou Laima, seu assistente online e estou aqui para ajudá-lo(a) a criar seu instrumento de avaliação de Produção acadêmica, ou se você desejar, guia-lo(a) a avaliar uma produção acadêmica, de forma simples e eficiente.</p> -->
        <!-- <p> Fique tranquilo, (a)vou ajudá-lo(a) em todas as etapas do processo e garantir que você aproveite ao máximo todos os recursos que o IAPA tem para lhe oferecer.</p> -->
        <!-- <p>Para que eu saiba o que você pretende fazer, basta entrar em um dos links abaixo e eu lhe levarei rapidinho para onde você pediu.</p> -->
        <nav class="mt-5 flex-wrap justify-content-center d-inline-flex gap-2 mb-5">
            <h2 class="visually-hidden-focusable">Menu</h2>
            <ul>
             <li>   <a class="btn px-4 rounded-pill btn-link" href="sobre.php" title="Saiba mais sobre este programa" accesskey="1">Sobre Este Programa</a></li>
              <li>  <a class="btn px-4 rounded-pill btn-link" href="#" title="Conheça mais sobre nossa equipe" accesskey="2">Quem Somos</a></li>
              <li>  <a class="btn px-4 rounded-pill btn-primary" href="login.php" title="Faça login no IAPA" accesskey="3">Inicie IAPA</a></li>
            </ul>
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