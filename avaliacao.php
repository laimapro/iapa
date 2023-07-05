<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IAPA</title>
</head>
<body>

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

<img src="img/cropped-logo.png" alt="Logotipo do Laima" lang='en'><span aria-label="Laboratory of Artificial Intelligence and Machine AID" lang="en-us">Laboratory of Artificial Intelligence and Machine AID</span> da Universidade Federal de Pernambuco (UFPE)</span>
<h1>IAPA - Instrumento de Avaliação de Produção Acadêmica</h1>
<p>Agora são: <span id="horario"></span> <span id="saudacao"></span></p>

<p id="orientacao"> Oi, <?php echo $pronomeTratamento; echo " "; if ($nomesocial != null){echo $nomesocial;}else{echo $nomeUsuario; echo " "; echo $sobrenomeUsuario;} ?>, permita-me guiar-lhe pelos passos de nosso IAPA.
Para isso, preciso que você escolha um arquivo na lista de produções acadêmicas.
Quando você fizer isso, eu imediatamente exibirei os critérios que você deverá avaliar. se não deseja julgar uma produção acadêmica agora ou se quiser avaliar outro trabalho, pressione o botão voltar e estaremos na página anterior, como em um passo de mágica.</p>



<script>
  var agora = new Date();
  var horas = agora.getHours();

  var saudacao = "";

  if (horas >= 01 && horas < 12) {
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


<body>

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


<br>
<select id="arquivos" name="arquivos" onclick="loadFile(this.value)" >
    <option value="">Selecione uma produção acadêmica:</option>
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
<button onclick="window.location.href='avaliacao.php'" title="Permite escolher outro arquivo para avaliação">Voltar</button>
    <fieldset>
        <legend>Título da produção acadêmica:</legend>
        <textarea name="tituloproducaoacademica" id="tituloproducaoacademica" title="Escreva o Título da produção acadêmica" required></textarea>
    </fieldset>
            <br>
            <p id="itens"></p>
        <fieldset>
            <legend>Estamos quase lá, agora você precisa escolher um tópico e avaliar cada item. Ai calcularei a média para você. Quando você terminar de avaliar pressione o botão Salvar e Avançar e eu farei isso para você</legend>
            <div id="itemContainer"></div>

            <div id="mediaContainer"></div>

            <div id="result"></div>
            <br>
            <label for="Observações do avaliador(a):">Observações do avaliador(a):</label>
            <div id="observacao"></div>
            <div id="aprovacao"></div>
        </fieldset>
        <button type="submit" title="" accesskey="2">Salvar e gerar parecer</button> 
    </div>
</form>
<button onclick="window.location.href='home.php'" accesskey="1" title="Retorna para página inicial do IAPA">Voltar para o IAPA</button> 


<script>
    async function loadFile(fileName) {
        var checkboxContainer = document.getElementById("checkboxContainer");
        var selecionarArquivoBtn = document.getElementById("arquivos");
        var orientacao = document.getElementById("orientacao");
        var itens = document.getElementById("itens");
        var observacao = document.getElementById("observacao");
        var mediarelatorio = document.getElementById("mediarelatorio");
        var aprovacao = document.getElementById("aprovacao");

            if (fileName) {
                
                checkboxContainer.style.display = "block"; 
                selecionarArquivoBtn.style.display = "none";
                orientacao.textContent = "Oi, <?php echo $pronomeTratamento; echo" "; if ($nomesocial != null){echo $nomesocial;}else{echo $nomeUsuario; echo " "; echo $sobrenomeUsuario;} ?>, agora estamos prontos para avaliar a produção acadêmica que você escolheu. se você deseja avaliar outro arquivo, pressione o botão voltar Abaixo, assinale quais as opções que se aplicam a produção acadêmica em avaliação.";
                itens.textContent = "Agora vamos dar notas aos itens dos diferentes tópicos exigidos para sua produção acadêmica.";
                
                
                
                var textareaElement = document.createElement("textarea");
                    textareaElement.id = "minhaTextarea";
                    textareaElement.name = "observacaoValor";
                    textareaElement.title= "Escreva uma observação (opcional)";
                    textareaElement.value = "";


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
                        label.value = item;
                        div.appendChild(label);

                        var input = document.createElement("input");
                        input.type = "number";
                        input.min = 1;
                        input.max = 10;
                        input.name = "nota[]"; // Define o nome do input como o valor do item
                        input.value = valoresAvaliados[index]; // Valor padrão
                        div.appendChild(input);

                        itemContainer.appendChild(div);


                        input.addEventListener("input", function() {
                            var valor = parseInt(input.value);
                            if (isNaN(valor) || valor < 1 || valor > 10) {
                                alert("Digite uma nota válida entre 1 e 10.");
                                input.value = valoresAvaliados[index]; // Restaura o valor padrão
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

                        div.appendChild(label);
                        div.appendChild(input);

                        itemContainer.appendChild(div);
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

        function calcularMedia(valores) {
            var soma = 0;
            var contador = 0;
            for (var i = 0; i < valores.length; i++) {
                if (!isNaN(valores[i])) {
                    soma += valores[i];
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
</body>
</html>