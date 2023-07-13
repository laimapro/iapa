<?php include_once('includes/head.php'); ?>

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
        $programaposgraduacao = $row["programaposgraduacao"];
        $nomesocial = $row["nomesocial"];
        
        ?>

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row p-5 align-items-start rounded-3 bg-white  border shadow-lg">
            <div class="col-12 col-md-4 text-center text-lg-start">
                <?php include_once('includes/logo.php') ?>
                <div class="toc">
                </div>
            </div>
            <div class="col-12 mx-auto col-md-8">
                <p id="orientacao"> Oi, <?php echo $pronomeTratamento;
                                        echo " ";
                                        if ($nomesocial != null) {
                                            echo $nomesocial;
                                        } else {
                                            echo $nomeUsuario;
                                            echo " ";
                                            echo $sobrenomeUsuario;
                                        } ?>, permita-me guiar-lhe pelos passos de nosso IAPA.</p>
                <p>Para isso, preciso que você escolha um arquivo na lista de produções acadêmicas.</p>
                <p>Quando você fizer isso, eu imediatamente exibirei os critérios que você deverá avaliar. se não deseja julgar uma produção acadêmica agora ou se quiser avaliar outro trabalho, pressione o botão voltar e estaremos na página anterior, como em um passo de mágica.</p>

                <?php

// Assuming you've already created a mysqli connection named $mysqli

// Prepare and bind the statement
$stmt = $mysqli->prepare("SELECT * FROM tipo_producao WHERE instituicao = ? AND curso = ? AND programaposgraduacao = ?");
$stmt->bind_param("sss", $instituicao, $curso, $programaposgraduacao);

// Execute the prepared statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

?>

    <?php
        while($arquivo = $result->fetch_assoc()){
    ?>

    <?php
        }
    ?>

</table>

<?php
// Reset pointer to the beginning of the MySQLi result set
mysqli_data_seek($result, 0);

while($arquivo = $result->fetch_assoc()){
?>


<?php
}
?>
<?php
$stmt->close();
?>

<label for="selecionarArquivos">Selecione uma produção acadêmica</label>
<select id="arquivos" name="arquivos" onclick="loadFile(this.value)" class="form-select">
    <option value="">Escolha uma opção</option>
    <?php
    $directoryPath = 'IAPA.CRIADOS';

    // Reset pointer to the beginning of the MySQLi result set
    mysqli_data_seek($result, 0);

    while ($arquivo = $result->fetch_assoc()) {
        $filepath = $directoryPath . '/' . $arquivo['arquivo'] . '.json';
        if (file_exists($filepath)) {
            echo '<option value="' . $filepath . '">' . $arquivo['arquivo'] . '</option>';
        }
    }
    ?>
</select>
    <div id="checkboxContainer" style="display: none;">


<form action="avaliado.php" method="post">
    <a class="btn btn-outline-secondary" href="avaliacao.php" title="Permite escolher outro arquivo para avaliação"><i class="me-2 bi bi-arrow-left-right"></i> <span>Selecione outro arquivo</span></a>
    <fieldset>
        <legend>Título da produção acadêmica:</legend>
        <div class="form-floating ">
             <textarea class="form-control" placeholder="Escreva o título da produção acadêmica" name="tituloproducaoacademica" id="tituloproducaoacademica" style="height: 100px" title="Escreva o título da produção acadêmica" required></textarea>
            <label for="tituloproducaoacademica">Título da produção acadêmica</label>
        </div>
    </fieldset>
            <br>
            <p class="my-4" id="itens"></p>
        <fieldset>
            <legend>Estamos quase lá, agora você precisa escolher um tópico e avaliar cada item. Ai calcularei a média para você. Quando você terminar de avaliar pressione o botão Salvar e Avançar e eu farei isso para você</legend>
            <div id="itemContainer">
            </div>

            <div id="mediaContainer"></div>

            <div id="result"></div>
            <br>
            <div class="form-floating mb-5" >
            <label for="Observações do avaliador(a):">Observações do avaliador(a):</label>
            <br><br>
            <div id="observacao"></div>
            </div>
            <div id="aprovacao"></div>
        </fieldset>
        <div class="text-end">
             <button class="btn btn-primary" type="submit" title="" accesskey="2">Salvar e gerar parecer</button>
        </div>
    </div>
</form>
<div class="mt-5">
    <button class="btn btn-link" onclick="window.location.href='home.php'" accesskey="1" title="Retorna para página inicial do IAPA"><i class="bi bi-arrow-left me-1"></i>Voltar para o IAPA</button>
</div>

<script>
    async function loadFile(fileName) {
        var checkboxContainer = document.getElementById("checkboxContainer");
        var selecionarArquivoBtn = document.getElementById("arquivos");
        var orientacao = document.getElementById("orientacao");
        var itens = document.getElementById("itens");
        var observacao = document.getElementById("observacao");
        var mediarelatorio = document.getElementById("mediarelatorio");
        var aprovacao = document.getElementById("aprovacao");
        var labelSelectArquivo = document.querySelector("label[for='selecionarArquivos']");
        

            if (fileName) {
                
                labelSelectArquivo.style.display = "none";
                checkboxContainer.style.display = "block"; 
                selecionarArquivoBtn.style.display = "none";
                orientacao.textContent = "Oi, <?php echo $pronomeTratamento; echo" "; if ($nomesocial != null){echo $nomesocial;}else{echo $nomeUsuario; echo " "; echo $sobrenomeUsuario;} ?>, agora estamos prontos para avaliar a produção acadêmica que você escolheu. se você deseja avaliar outro arquivo, pressione o botão voltar Abaixo, assinale quais as opções que se aplicam a produção acadêmica em avaliação.";
                itens.textContent = "Agora vamos dar notas aos itens dos diferentes tópicos exigidos para sua produção acadêmica.";

                labelSelectArquivo.class ="hidden";
                
                var textareaElement = document.createElement("textarea");
                    textareaElement.id = "minhaTextarea";
                    textareaElement.name = "observacaoValor";
                    textareaElement.title= "Escreva uma observação (opcional)";
                    textareaElement.value = "";
                    textareaElement.className = "form-control";


                    observacao.appendChild(textareaElement);

                try {
                    const response = await fetch(fileName);
                    const data = await response.json();

                    var itemContainer = document.getElementById("itemContainer");
                    itemContainer.innerHTML = ""; // Limpa o conteúdo anterior

                    var mediaContainer = document.getElementById("mediaContainer");
                    mediaContainer.innerHTML = ""; // Limpa a média anterior, se houver

                    var valoresAvaliados = Array(data.length).fill(5); // Array com valores padrão 5

                    data.forEach(function(item, index) {
                        var div = document.createElement("div");
                        var itemContainer = document.getElementById("itemContainer");

                        var label1 = document.createElement("label");
                        label1.textContent = item;
                        div.appendChild(label1);

                        var label = document.createElement("input");
                        label.type = "hidden";
                        label.name = "label[]";
                        label.id = "inputMensagem";
                        label.value = item;
                        div.appendChild(label);

                        var input = document.createElement("input");
                        input.type = "number";
                        input.min = 1;
                        input.max = 10;
                        input.name = "nota[]";
                        input.value = valoresAvaliados[index];
                        input.id = "inputNota";
                        div.appendChild(input);

                        itemContainer.appendChild(div);

                        var mensagemComparar = "Apresenta";
                        var primeiraPalavraInput = item.trim().split(" ")[0];

                        if (primeiraPalavraInput.toLowerCase() === mensagemComparar.toLowerCase()) {
                            input.remove();

                        var nao = document.createElement("input");
                        nao.type = "hidden";
                        nao.value = "Não "+label.value.toLowerCase();
                        nao.name = "apresenta[]";

                        div.appendChild(nao);
                            // Criação da checkbox
                        var apresenta = document.createElement("input");
                        apresenta.type = "checkbox";
                        apresenta.value = label.value;
                        apresenta.name = "apresenta[]";
        
                        // Adiciona a checkbox ao elemento pai do input
                        div.appendChild(apresenta);
                        apresenta.addEventListener("change", function() {
                        if (apresenta.checked) {
                            div.removeChild(nao);
                        } else {
                            div.appendChild(nao);
                        }
                        });       
                        }


                        input.addEventListener("input", function() {
                            var valor = parseInt(input.value);
                            if (isNaN(valor) || valor < 1 || valor > 10) {
                            alert("Digite uma nota válida entre 1 e 10.");
                            input.value = valoresAvaliados[index];
                            return;
                            }

                            valoresAvaliados[index] = valor;
                            var media = calcularMedia(valoresAvaliados);
                            localStorage.setItem("medianota", mediaContainer.textContent = "Média: " + media);
                            mediaContainer.textContent = "Média: " + media;

                            var mensagem = "";
                            if (media >= 8) {
                            mensagem = "Produção Acadêmica Aprovada";
                            } else if (media >= 6.5) {
                            mensagem = "Produção Acadêmica Aprovada com Restrições";
                            } else {
                            mensagem = "Produção Acadêmica Reprovada";
                            }
                            document.getElementById("result").textContent = mensagem;
                        });
                        });


                    var media = calcularMedia(valoresAvaliados);
                     mediaContainer.textContent = "Média: " + media;
                    
                    var mediarelatorio = document.createElement("input");
                        mediarelatorio.id = "minhaTextarea";
                        mediarelatorio.name = "observacaoValor";
                        mediarelatorio.value = "oi";


                    observacao.appendChild(textareaElement);


                } catch (error) {
                    console.log("Erro ao carregar o arquivo: " + error);
                }
            } else {
                checkboxContainer.style.display = "none";
                var itemContainer = document.getElementById("itemContainer");
                itemContainer.innerHTML = ""; // Limpa o conteúdo quando nenhum arquivo é selecionado

                var mediaContainer = document.getElementById("mediaContainer");
                mediaContainer.innerHTML = ""; // Limpa a média quando nenhum arquivo é selecionado

                document.getElementById("result").textContent = "";
            }
        }

        function calcularMedia() {
            var inputs = document.getElementsByName("nota[]");
            var soma = 0;
            var contador = 0;

            for (var i = 0; i < inputs.length; i++) {
                var valor = parseInt(inputs[i].value);
                if (!isNaN(valor)) {
                soma += valor;
                contador++;
                }
            }

            return contador > 0 ? (soma / contador).toFixed(2) : 0;
            }

</script>  
  
  <?php


// ... exiba os outros campos do usuário que você deseja mostrar
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
<?php include_once('includes/footer.php') ?>
