<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>IAPA - Instrumento de Avaliação de Produção Acadêmica</title>
    <style>
        /* Estilos adicionais para melhorar a visualização */
        body {
            font-family: Arial, sans-serif;
        }
        
        h1 {
            font-size: 24px;
        }
        
        h3 {
            font-size: 18px;
        }
        
        a {
            display: block;
            margin-bottom: 10px;
        }
        
        .tooltip {
            position: relative;
            display: inline-block;
        }
        
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        
        .contrast-btn {
            position: fixed;
            right: 10px;
            bottom: 10px;
            padding: 10px;
            background-color: #000;
            color: #fff;
            z-index: 9999;
        }

        .contrast-mode {
            /* Defina os estilos de contraste aqui */
            background-color: #fff;
            color: #000;
        }

        .contrast-mode-1 {
            /* Primeiro estilo de contraste */
            background-color: #000;
            color: #fff;
        }

        .contrast-mode-2 {
            /* Segundo estilo de contraste */
            background-color: #ff0000;
            color: #00ff00;
        }

        .contrast-mode-3 {
            /* Terceiro estilo de contraste */
            background-color: #0000ff;
            color: #ffff00;
        }

        .contrast-mode-dalt {
            /* Estilo de contraste para daltonismo */
            background-color: #808080;
            color: #fff;
        }

        .menu ul {
            list-style-type: none;
            padding: 0;
        }

        .menu li {
            display: inline-block;
            margin-right: 10px;
        }

        .menu li a {
            text-decoration: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <img src="img/cropped-logo.png" alt="logotipo do Laima"><span aria-label="Laboratory of Artificial Intelligence and Machine AID" lang="en-us">Laboratory of Artificial Intelligence and Machine AID</span> da Universidade Federal de Pernambuco (UFPE)</span>

    <h1>IAPA, Instrumento de avaliação de produção Acadêmica</h1>
    <p>Agora são: <span id="horario"></span> <span id="saudacao"></span></p><br>

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


    <script>
        function toggleContrast() {
            var body = document.body;
            var classes = ["contrast-mode", "contrast-mode-1", "contrast-mode-2", "contrast-mode-3", "contrast-mode-dalt"];
            var currentIndex = classes.indexOf(body.className);
            var newIndex = (currentIndex + 1) % classes.length;
            body.className = classes[newIndex];
        }

    </script>
</body>
</html>
