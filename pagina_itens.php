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
        $categorias = $_GET['categorias'];
        $nomesocial = $row["nomesocial"];


        ?>

<img src="img/cropped-logo.png" alt="Logotipo do Laima" lang='en'><span aria-label="Laboratory of Artificial Intelligence and Machine AID" lang="en-us">Laboratory of Artificial Intelligence and Machine AID</span> da Universidade Federal de Pernambuco (UFPE)</span>
<h1>Instrumento de avaliação de produção científica</h1>
<h3>Olá, <?php echo $pronomeTratamento; echo " "; if ($nomesocial != null){echo $nomesocial;}else{echo $nomeUsuario; echo " "; echo $sobrenomeUsuario;} ?></h3>

<p>Agora são: <span id="horario"></span> <span id="saudacao"></span></p>

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

      <form id="formItens" action="salvar_arquivo.php" method="POST">
    <h2>Excelente! Estamos prontos para começar nosso trabalho. Quero dizer, o seu.</h2>
<p>Selecione em cada tópico, os itens que você quer que eu adicione no IAPA que você está construindo. Se nenhum item de um tópico for aplicável, apenas pule-o, e eu não o incluirei no IAPA. Não se esqueça de pressionar o botão Avançar e salvar, para eu lhe levar ao próximo passo.</p>
<strong> Está pronto, <?php echo $pronomeTratamento; echo " ";  echo $nomeUsuario; ?>, Então vamos trabalhar!</strong>

    <input type="hidden" name="categorias" value="<?php echo $categorias;?>">
    <fieldset>
        <legend><h4>Aspectos Gerais</h4></legend>
        <input type="checkbox" name="item[]" value="Aspectos Gerais: Completude da Produção Acadêmica"> Completude da Produção Acadêmica<br>
        <input type="checkbox" name="item[]" value="Aspectos Gerais: Completude e organização das seções da Produção Acadêmica"> Completude e organização das seções da Produção Acadêmica<br>
        <input type="checkbox" name="item[]" value="Aspectos Gerais: Uso de vocabulário acadêmico/científico"> Uso de vocabulário acadêmico/científico<br>
        <input type="checkbox" name="item[]" value="Aspectos Gerais: Originalidade e relevância da Produção Acadêmica"> Originalidade e relevância da Produção Acadêmica<br>
        <p> Deseja adicionar mais algum item?</p>
      <textarea name="item[]" id=""></textarea>
    </fieldset>
    <fieldset>
        <legend><h4>Resumo</h4></legend>
            <input type="checkbox" name="item[]" value="Resumo: Adequação científica do Resumo"> Adequação científica do Resumo<br>
            <input type="checkbox" name="item[]" value="Resumo: Qualidade do resumo"> Qualidade do resumo<br>
            <input type="checkbox" name="item[]" value="Resumo: Qualidade do resumo em língua estrangeira"> Qualidade do resumo em língua estrangeira<br>
            <p> Deseja adicionar mais algum item?</p>
            <textarea name="item[]" id=""></textarea>
    </fieldset>
    <fieldset>
        <legend><h4>Palavra-chave</h4></legend>
            <input type="checkbox" name="item[]" value="Palavra-chave: Adequação das palavras-chaves apresentadas ao tema da Produção Acadêmica"> Adequação das palavras-chaves apresentadas ao tema da Produção Acadêmica<br>
            <p> Deseja adicionar mais algum item?</p>
            <textarea name="item[]" id=""></textarea>
        </fieldset>
    <fieldset>
        <legend><h4>Introdução</h4></legend>
        <input type="checkbox" name="item[]" value="Introdução: Completude da Introdução e da contextualização da Produção Acadêmica"> Completude da Introdução e da contextualização da Produção Acadêmica<br>
        <input type="checkbox" name="item[]" value="Introdução: Qualidade da Introdução e da contextualização da Produção Acadêmica"> Qualidade da Introdução e da contextualização da Produção Acadêmica<br>
        <p> Deseja adicionar mais algum item?</p>
        <textarea name="item[]" id=""></textarea>
      </fieldset>
    <fieldset>
        <legend><h4>Objetivo Gerais e especificos</h4></legend>
        <input type="checkbox" name="item[]" value="Objetivo Gerais e especificos: Adequação dos objetivos"> Adequação dos objetivos <br>
        <input type="checkbox" name="item[]" value="Objetivo Gerais e especificos: Relevancia dos objetivos"> Relevancia dos objetivos <br>
        <input type="checkbox" name="item[]" value="Objetivo Gerais e especificos: Completude dos objetivos especificos"> Completude dos objetivos especificos<br>
        <input type="checkbox" name="item[]" value="Objetivo Gerais e especificos: Qualidade dos objetivos"> Qualidade dos objetivos<br>
        <p> Deseja adicionar mais algum item?</p>
    <textarea name="item[]" id=""></textarea>
        
    </fieldset>
    <fieldset>
        <legend><h4>justificativa</h4></legend>
        <input type="checkbox" name="item[]" value="justificativa: Fundamentação da justificativa"> Fundamentação da justificativa <br>
        <input type="checkbox" name="item[]" value="justificativa: Relevancia da justificativa"> Relevancia da justificativa <br>
        <p> Deseja adicionar mais algum item?</p>
    <textarea name="item[]" id=""></textarea>
    </fieldset>
    
    <fieldset>
        <legend><h4>Estado da arte</h4></legend>
    
            <input type="checkbox" name="item[]" value="Estado da arte: Completude do estado da arte"> Completude do estado da arte<br>
            <input type="checkbox" name="item[]" value="Estado da arte: Qualidade do estado da arte"> Qualidade do estado da arte<br>
            <p> Deseja adicionar mais algum item?</p>
    <textarea name="item[]" id=""></textarea>
    </fieldset>
    
    <fieldset>
        <legend><h4>Método</h4></legend>
    
        <input type="checkbox" name="item[]" value="Método: Qualidade da estrutura científico-metodológica utilizada"> Qualidade da estrutura científico-metodológica utilizada<br>
        <input type="checkbox" name="item[]" value="Método: Adequação e qualidade das figuras, gráficos, tabelas ou esquemas usados"> Adequação e qualidade das figuras, gráficos, tabelas ou esquemas usados
        <p> Deseja adicionar mais algum item?</p>
    <textarea name="item[]" id=""></textarea>
      </fieldset>
    <fieldset>
        <legend><h4>Análise</h4></legend>
            <input type="checkbox" name="item[]" value="Análise: Profundidade da análise"> Profundidade da análise<br>
            <input type="checkbox" name="item[]" value="Análise: Coerência da análise com os dados coletados"> Coerência da análise com os dados coletados<br>
            <input type="checkbox" name="item[]" value="Análise: Coerência da analise com a fundamentação teorica">Coerência da analise com a fundamentação teorica<br>
            <p> Deseja adicionar mais algum item?</p>
    <textarea name="item[]" id=""></textarea>
        </fieldset>
    <fieldset>
        <legend><h4>Conclusão</h4></legend>
            <input type="checkbox" name="item[]" value="Conclusão: Profundidade das conclusões"> Profundidade das conclusões<br>
            <input type="checkbox" name="item[]" value="Conclusão: Coerência das conclusões com os dados coletados"> Coerência das conclusões com os dados coletados<br>
            <input type="checkbox" name="item[]" value="Conclusão: Coerência da conclusões com a fundamentação teorica">Coerência da conclusões com a fundamentação teorica<br>
            <p> Deseja adicionar mais algum item?</p>
    <textarea name="item[]" id=""></textarea>
        </fieldset>
    
    <fieldset>
        <legend><h4>Referências bibliográficas</h4></legend>
            <input type="checkbox" name="item[]" value="Referências bibliográficas: Relevância e atualidade das referências bibliográficas"> Relevância e atualidade das referências bibliográficas<br>
            <input type="checkbox" name="item[]" value="Referências bibliográficas: Conformidade das referências com as normas da ABNT"> Conformidade das referências com as normas da ABNT<br>
            <p> Deseja adicionar mais algum item?</p>
            <textarea name="item[]" id=""></textarea>
    </fieldset>

    <fieldset>
        <legend><h4>Assinale quais dos itens abaixo se aplicam ao Projeto Acadêmico em avaliação: </h4></legend>
            <input type="checkbox" id="titulo" name="item[]" value="Apresenta título da Produção Acadêmica">
            <label for="titulo">Apresenta título da Produção Acadêmica</label><br>

            <input type="checkbox" id="resumo" name="item[]" value="Apresenta resumo">
            <label for="resumo">Apresenta resumo</label><br>

            <input type="checkbox" id="palavrasChaves" name="item[]" value="Apresenta palavras-chaves">
            <label for="palavrasChaves">Apresenta palavras-chaves</label><br>

            <input type="checkbox" id="resumoEstrangeira" name="item[]" value="Apresenta resumo em língua estrangeira">
            <label for="resumoEstrangeira">Apresenta resumo em língua estrangeira</label><br>

            <input type="checkbox" id="palavrasChavesEstrangeira" name="item[]" value="Apresenta palavras-chaves em língua estrangeira">
            <label for="palavrasChavesEstrangeira">Apresenta palavras-chaves em língua estrangeira</label><br>

            <input type="checkbox" id="introducao" name="item[]" value="Apresenta Introdução e contextualização">
            <label for="introducao">Apresenta Introdução e contextualização</label><br>

            <input type="checkbox" id="objetivos" name="item[]" value="Apresenta objetivos e justificativa">
            <label for="objetivos">Apresenta objetivos e justificativa</label><br>

            <input type="checkbox" id="estadoArte" name="item[]" value="Apresenta estado da arte">
            <label for="estadoArte">Apresenta estado da arte</label><br>

            <input type="checkbox" id="estrutura" name="item[]" value="Apresenta estrutura científico-metodológica">
            <label for="estrutura">Apresenta estrutura científico-metodológica</label><br>

            <input type="checkbox" id="analise" name="item[]" value="Apresenta análise, considerações ou conclusões">
            <label for="analise">Apresenta análise, considerações ou conclusões</label><br>

            <input type="checkbox" id="referencias" name="item[]" value="Apresenta referências bibliográficas">
            <label for="referencias">Apresenta referências bibliográficas</label><br>

            <p> Deseja adicionar mais algum item?</p>
            <textarea name="item[]" id=""></textarea>
        </fieldset>





    <br>
<button type="submit" class="tooltip" aria-label="Salvar e Avançar" title="Salva e finaliza a edição deste Instrumento de Avaliação">
  Salvar e Avançar
</button>

  </form>
 
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