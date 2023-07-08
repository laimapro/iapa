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

<p><span id="saudacao"></span>!<br><i class="mx-2 bi bi-clock"></i>Agora são <span id="horario"></span>: <span id="horario"></span> <span id="saudacao"></span></p>

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
        <input type="checkbox" name="item[]" value="Aspectos Gerais: Contribuição para a prática profissional na área"> Contribuição para a prática profissional na área<br>
        <input type="checkbox" name="item[]" value="Aspectos Gerais: Abrangência geográfica do estudo"> Abrangência geográfica do estudo<br>
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
        
        <fieldset>
            <legend><h5>Problema de Pesquisa</h5></legend>
            <input type="checkbox" name="item[]" value="Introdução - Problema de pesquisa: Formulação do problema de pesquisa"> Formulação do problema de pesquisa<br>
            <input type="checkbox" name="item[]" value="Introdução - Problema de pesquisa: Delimitação do tema da pesquisa"> Delimitação do tema da pesquisa<br>
            <input type="checkbox" name="item[]" value="Introdução - Problema de pesquisa: Contextualização do problema da pesquisa"> Contextualização do problema da pesquisa<br>
            <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
        </fieldset>


        <fieldset>
            <legend><h4>Objetivo Gerais e especificos</h4></legend>
                <input type="checkbox" name="item[]" value="Introdução - Objetivo Gerais e especificos: Adequação dos objetivos"> Adequação dos objetivos <br>
                <input type="checkbox" name="item[]" value="Introdução - Objetivo Gerais e especificos: Relevancia dos objetivos"> Relevancia dos objetivos <br>
                <input type="checkbox" name="item[]" value="Introdução - Objetivo Gerais e especificos: Completude dos objetivos especificos"> Completude dos objetivos especificos<br>
                <input type="checkbox" name="item[]" value="Introdução - Objetivo Gerais e especificos: Qualidade dos objetivos"> Qualidade dos objetivos<br>
                <p> Deseja adicionar mais algum item?</p>
                <textarea name="item[]" id=""></textarea>
            </fieldset>

        <fieldset>
            <legend><h4>Hipótese</h4></legend>
            <input type="checkbox" name="item[]" value="Introdução - Hipótese: Adequação da hipótese"> Adequação da hipótese<br>
            <input type="checkbox" name="item[]" value="Introdução - Hipótese: Relevância da hipótese"> Relevância da hipótese<br>
            <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
        </fieldset>
        
        <br>
        <input type="checkbox" name="item[]" value="Introdução: Completude da Introdução e da contextualização da Produção Acadêmica"> Completude da Introdução e da contextualização da Produção Acadêmica<br>
        <input type="checkbox" name="item[]" value="Introdução: Qualidade da Introdução e da contextualização da Produção Acadêmica"> Qualidade da Introdução e da contextualização da Produção Acadêmica<br>
        <p> Deseja adicionar mais algum item?</p>
        <textarea name="item[]" id=""></textarea>
      </fieldset>

    <fieldset>
        <legend><h4>Justificativa</h4></legend>
        <input type="checkbox" name="item[]" value="justificativa: Fundamentação da justificativa"> Fundamentação da justificativa <br>
        <input type="checkbox" name="item[]" value="justificativa: Relevancia da justificativa"> Relevancia da justificativa <br>
        <p> Deseja adicionar mais algum item?</p>
        <textarea name="item[]" id=""></textarea>
    </fieldset>

    <fieldset>
            <legend><h4>Estado da arte</h4></legend>
                <input type="checkbox" name="item[]" value="Introdução - Estado da arte: Revisão da literatura"> Revisão da literatura<br>
                <input type="checkbox" name="item[]" value="Introdução - Estado da arte: Profundidade da revisão da literatura"> Profundidade da revisão da literatura<br>
                <input type="checkbox" name="item[]" value="Introdução - Estado da arte: Completude do estado da arte"> Completude do estado da arte<br>
                <input type="checkbox" name="item[]" value="Introdução - Estado da arte: Qualidade do estado da arte"> Qualidade do estado da arte<br>
                <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
            </fieldset>
    
    <fieldset>
        <legend><h4>Método</h4></legend>

        <fieldset>
            <legend><h4>Sujeitos</h4></legend>

            <input type="checkbox" name="item[]" value="Método - Sujeitos: Adequação da escolha da População do estudo">Adequação da escolha da População do estudo<br>
            <input type="checkbox" name="item[]" value="Método - Sujeitos: Adequação da quantidade da Amostra">Adequação da quantidade da Amostra<br>
            <input type="checkbox" name="item[]" value="Método - Sujeitos: Adequação do Recrutamento da amostra">Adequação do Recrutamento da amostra<br>
            <input type="checkbox" name="item[]" value="Método - Sujeitos: Caracterização da amostra">Caracterização da amostra<br>
            <input type="checkbox" name="item[]" value="Método - Sujeitos: Caracterização da população do estudo">Caracterização da população do estudo<br>
            <input type="checkbox" name="item[]" value="Método - Sujeitos: Adequação dos critérios de inclusão">Adequação dos critérios de inclusão<br>
            <input type="checkbox" name="item[]" value="Método - Sujeitos: Adequação dos Critério de exclusão">Adequação dos Critério de exclusão<br>
            <input type="checkbox" name="item[]" value="Método - Sujeitos: Adequação do Tamanho da amostra"> Adequação do Tamanho da amostra<br>
            <input type="checkbox" name="item[]" value="Método - Sujeitos: Adequação do cálculo amostral">Adequação do cálculo amostral<br>
            



            <input type="checkbox" name="item[]" value="Método - Sujeitos: A população do estudo responde a natureza da pesquisa">A população do estudo responde a natureza da pesquisa<br>
            <input type="checkbox" name="item[]" value="Método - Sujeitos: O número de sujeitos contempla a natureza da pesquisa">O número de sujeitos contempla a natureza da pesquisa<br>
            <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
        </fieldset>

        <fieldset>
            <legend><h4>Materiais e procedimentos</h4></legend>
            <input type="checkbox" name="item[]" value="Método - Materiais e procedimentos: A descrição apresentada dos laboratórios, instrumentos e equipamentos empregados no estudo permite dizer que respondem aos pré-requisitos da pesquisa">A descrição apresentada dos laboratórios, instrumentos e equipamentos empregados no estudo permite dizer que respondem aos pré-requisitos da pesquisa<br>
            <input type="checkbox" name="item[]" value="Método - Materiais e procedimentos: A descrição das técnicas e dos tratamentos empregados na obtenção dos dados permitem deduzir que os procedimentos respondem à necessidade da pesquisa">A descrição das técnicas e dos tratamentos empregados na obtenção dos dados permitem deduzir que os procedimentos respondem à necessidade da pesquisa<br>
            <input type="checkbox" name="item[]" value="Método - Materiais e procedimentos: Estrutura científico-metodológica utilizada"> Estrutura científico-metodológica utilizada<br>
            <input type="checkbox" name="item[]" value="Método - Materiais e procedimentos: Os instrumentos, equipamentos e tratamentos empregados no estudo para a obtenção dos dados respondem à necessidade da pesquisa">Os instrumentos, equipamentos e tratamentos empregados no estudo para a obtenção dos dados respondem à necessidade da pesquisa<br>
            
            <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
        </fieldset>

        <fieldset>
            <legend><h4>Coleta de dados</h4></legend>
            <input type="checkbox" name="item[]" value="Método - Coleta de dados: A coleta dos dados foi conduzida em local e tempo adequados">A coleta dos dados foi conduzida em local e tempo adequados<br>
            <input type="checkbox" name="item[]" value="Método - Coleta de dados: Os instrumentos de coleta (questionários, entrevistas etc.estão coerentes com a natureza da pesquisa)">Os instrumentos de coleta (questionários, entrevistas etc.estão coerentes com a natureza da pesquisa)<br>
            <input type="checkbox" name="item[]" value="Método - Coleta de dados: Os Materiais: equipamentos e experimentos permitiram a coleta de dados requerida pelo estudo">Os Materiais: equipamentos e experimentos permitiram a coleta de dados requerida pelo estudo<br>
            <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
        </fieldset>



       
        <fieldset>
            <legend><h4>Resultados</h4></legend>
            <input type="checkbox" name="item[]" value="Método - Resultados: Coerência dos resultados com o método utilizado">Coerência dos resultados com o método utilizado<br>
            <input type="checkbox" name="item[]" value="Método - Resultados: Precisão dos dados coletados">Precisão dos dados coletados<br>
            <input type="checkbox" name="item[]" value="Método - Resultados: Concisão dos dados coletados">Concisão dos dados coletados<br>
            <input type="checkbox" name="item[]" value="Método - Resultados: Clareza dos dados coletados">Clareza dos dados coletados<br>
            <input type="checkbox" name="item[]" value="Método - Resultados: Reprodutibilidade dos resultados obtidos">Reprodutibilidade dos resultados obtidos<br>
            <input type="checkbox" name="item[]" value="Método - Resultados: Confiabilidade e fidedignidade dos dados obtidos">Confiabilidade e fidedignidade dos dados obtidos<br>
            <input type="checkbox" name="item[]" value="Método - Resultados: A qualidade das figuras, gráficos, tabelas ou esquemas usados expressão os dados obtidos"> A qualidade das figuras, gráficos, tabelas ou esquemas usados expressão os dados obtidos<br>
            
            <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
        </fieldset>

        <fieldset>
            <legend><h4>Análise dos dados</h4></legend>
            <input type="checkbox" name="item[]" value="Análise: Profundidade da análise"> Profundidade da análise<br>
            <input type="checkbox" name="item[]" value="Análise: Coerência da análise com os dados coletados"> Coerência da análise com os dados coletados<br>
            <input type="checkbox" name="item[]" value="Análise: Coerência da analise com a fundamentação teorica">Coerência da analise com a fundamentação teorica<br>
            <input type="checkbox" name="item[]" value="Análise: A análise apresentada não mostra vieses científicos"> A análise apresentada não mostra vieses científicos<br>
            <input type="checkbox" name="item[]" value="Análise: A análise produzida está coerente com a Discriminação/definição das variáveis estudadas"> A análise produzida está coerente com a Discriminação/definição das variáveis estudadas<br>
            <input type="checkbox" name="item[]" value="Análise: A análise condiz com a Organização e tabulação dos dados"> A análise condiz com a Organização e tabulação dos dados<br>
            <input type="checkbox" name="item[]" value="Análise: A análise feita condiz com o Tratamento e testes estatísticos utilizados">A análise feita condiz com o Tratamento e testes estatísticos utilizados<br>
            <input type="checkbox" name="item[]" value="Análise: O(s) Programa(s) utilizados para tabulação e análise deram conta dos resultados obtidos">O(s) Programa(s) utilizados para tabulação e análise deram conta dos resultados obtidos <br>
            <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
        </fieldset>
        <br>
    </fieldset>

    <fieldset>
            <legend><h4>Cronograma</h4></legend>
            <input type="checkbox" name="item[]" value="Método - Cronograma: O cronograma é viável no tempo disponível para a pesquisa">O cronograma é viável no tempo disponível para a pesquisa<br>
             <input type="checkbox" name="item[]" value="Método - Cronograma: A organização do cronograma é clara">A organização do cronograma é clara<br>
             <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
    
    </fieldset>

    <fieldset>
        <legend><h4>Orçamento</h4></legend>
            <input type="checkbox" name="item[]" value="Orçamento: Adequação do Custeio"> Adequação do Custeio<br>
            <input type="checkbox" name="item[]" value="Orçamento: Adequação do Capital"> Adequação do Capital<br>
            <input type="checkbox" name="item[]" value="Orçamento: Relevância da contrapartida">Relevância da contrapartida<br>
            <input type="checkbox" name="item[]" value="Orçamento: Descrição dos materiais permanentes">Descrição dos materiais permanentes<br>
            <input type="checkbox" name="item[]" value="Orçamento: Adequação do material de consumo">Adequação do material de consumo<br>
            <input type="checkbox" name="item[]" value="Orçamento: Relevância/necessidade dos serviços de terceiros">Relevância/necessidade dos serviços de terceiros<br>
            <input type="checkbox" name="item[]" value="Orçamento: Solicitação dos recursos humanos">Solicitação dos recursos humanos<br>
            <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
    </fieldset>

    <fieldset>
        <legend><h4>Discursão</h4></legend>
            <input type="checkbox" name="item[]" value="Discursão: Profundidade da discursão"> Profundidade da discursão<br>
            <input type="checkbox" name="item[]" value="Discursão: Coerência da discursão com os dados coletados"> Coerência da discursão com os dados coletados<br>
            <input type="checkbox" name="item[]" value="Discursão: Coerência da discursão com a fundamentação teorica">Coerência da discursão com a fundamentação teorica<br>
            <p> Deseja adicionar mais algum item?</p>
           <textarea name="item[]" id=""></textarea>
    </fieldset>




        
    <fieldset>
        <legend><h4>Conclusão</h4></legend>
            <input type="checkbox" name="item[]" value="Conclusão: Profundidade das conclusões"> Profundidade das conclusões<br>
            <input type="checkbox" name="item[]" value="Conclusão: Coerência das conclusões com os dados coletados"> Coerência das conclusões com os dados coletados<br>
            <input type="checkbox" name="item[]" value="Conclusão: Coerência das conclusões com a fundamentação teorica">Coerência das conclusões com a fundamentação teorica<br>
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

             
            <input type="checkbox" id="aprovacaoComite" name="item[]" value="Apresenta Aprovação do Comitê de Ética em Pesquisa">
            <label for="aprovacaoComite">Apresenta Aprovação do Comitê de Ética em Pesquisa</label><br>

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
<?php include_once('includes/footer.php') ?>
