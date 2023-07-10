<?php include_once('includes/head.php');?>

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

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row p-5 align-items-start rounded-3 bg-white  border shadow-lg">
        <div class="col-12 col-md-4 text-center text-lg-start">
            <?php include_once('includes/logo.php') ?>
            <h2>Menu</h2>
            <div class="menu-nav">
                <ul>
                    <li><a href="#aspectosGerais">aspectosGerais</a></li>
                    <li><a href="#resumo">resumo</a></li>
                    <li><a href="#palavrachave">palavrachave</a></li>
                    <li><a href="#problemapesquisa">problemapesquisa</a></li>
                    <li><a href="#objetivos">objetivos</a></li>
                    <li><a href="#hipotese">hipotese</a></li>
                    <li><a href="#justificativa">justificativa</a></li>
                    <li><a href="#estadoarte">estado arte</a></li>
                    <li><a href="#sujeitos">sujeitos</a></li>
                </ul>
            </div>
        </div>
        <div class="col-12 mx-auto col-md-8">
            <h2 class="visually-hidden-focusable">Mensagem de boas-vindas</h2>
            <p><span id="saudacao"></span>, <?php echo $pronomeTratamento; echo " "; if ($nomesocial != null){echo $nomesocial;}else{echo $nomeUsuario; echo " "; echo $sobrenomeUsuario;} ?></p>
            <p>Excelente! Estamos prontos para começar nosso trabalho. Quero dizer, o seu.</p>
            <p>Selecione em cada tópico, os itens que você quer que eu adicione no <strong>IAPA</strong> que você está construindo. Se nenhum item de um tópico for aplicável, apenas pule-o, e eu não o incluirei no <strong>IAPA</strong>. Não se esqueça de pressionar o botão Avançar e salvar, para eu lhe levar ao próximo passo.</p>
            <p>Está pronto, <strong><?php echo $pronomeTratamento; echo " ";  echo $nomeUsuario; ?></strong>, Então vamos trabalhar!</p>
            
            <h2 class="visually-hidden-focusable">Itens avaliados</h2>

            <form id="formItens" action="salvar_arquivo.php" method="POST">
                <input type="hidden" name="categorias" value="<?php echo $categorias;?>">
            
                <fieldset class="mt-4">
                    <legend id="aspectosGerais"><h3>Aspectos Gerais</h3></legend>

                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto1" value="Aspectos Gerais: Completude da Produção Acadêmica">                               <label class="d-inline form-check-label" for="aspecto1">Aspectos Gerais: Completude da Produção Acadêmica</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto2" value="Aspectos Gerais: Completude e organização das seções da Produção Acadêmica">      <label class="d-inline form-check-label" for="aspecto2">Aspectos Gerais: Completude e organização das seções da Produção Acadêmica</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto3" value="Aspectos Gerais: Uso de vocabulário acadêmico/científico">                        <label class="d-inline form-check-label" for="aspecto3">Aspectos Gerais: Uso de vocabulário acadêmico/científico</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto4" value="Aspectos Gerais: Originalidade e relevância da Produção Acadêmica">               <label class="d-inline form-check-label" for="aspecto4">Aspectos Gerais: Originalidade e relevância da Produção Acadêmica</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto5" value="Aspectos Gerais: Contribuição para a prática profissional na área">               <label class="d-inline form-check-label" for="aspecto5">Aspectos Gerais: Contribuição para a prática profissional na área</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto6" value="Aspectos Gerais: Abrangência geográfica do estudo">                               <label class="d-inline form-check-label" for="aspecto6">Aspectos Gerais: Abrangência geográfica do estudo</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais aos 'Aspectos Gerais'" id="aspectoAdicional" style="height: 100px"></textarea>
                        <label for="aspectoAdicional">Adicione itens adicionais aos 'Aspectos Gerais'</label>
                    </div>

                </fieldset>
    
                <fieldset>
                    <legend id="resumo"><h3>Resumo</h3></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resumo1" value="Resumo: Adequação científica do Resumo">               <label class="d-inline form-check-label" for="resumo1">Adequação científica do Resumo</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resumo2" value="Resumo: Qualidade do resumo">                          <label class="d-inline form-check-label" for="resumo2">Qualidade do resumo</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resumo3" value="Resumo: Qualidade do resumo em língua estrangeira">    <label class="d-inline form-check-label" for="resumo3">Qualidade do resumo em língua estrangeira</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais ao 'Resumo'" id="resumoAdicional" style="height: 100px"></textarea>
                        <label for="resumoAdicional">Adicione itens adicionais ao 'Resumo'</label>
                    </div>
                </fieldset>
                
                <fieldset>
                    <legend id="palavrachave"><h3>Palavra-chave</h3></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="palavrachave1" value="Palavra-chave: Adequação das palavras-chaves apresentadas ao tema da Produção Acadêmica">   <label class="d-inline form-check-label" for="palavrachave1">Adequação das palavras-chaves apresentadas ao tema da Produção Acadêmica</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais as 'Palavras-chaves'" id="palavrachaveAdicional" style="height: 100px"></textarea>
                        <label for="palavrachaveAdicional">Adicione itens adicionais as 'Palavras-chaves'</label>
                    </div>
                </fieldset>
                
                <h3>Introdução</h3>
        
                <fieldset>
                    <legend id="problemapesquisa"><h4>Problema de Pesquisa</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="problemapesquisa1" value="Introdução - Problema de pesquisa: Formulação do problema de pesquisa">               <label class="d-inline form-check-label" for="problemapesquisa1">Formulação do problema de pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="problemapesquisa2" value="Introdução - Problema de pesquisa: Delimitação do tema da pesquisa">                  <label class="d-inline form-check-label" for="problemapesquisa2">Delimitação do tema da pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="problemapesquisa3" value="Introdução - Problema de pesquisa: Contextualização do problema da pesquisa">         <label class="d-inline form-check-label" for="problemapesquisa3">Contextualização do problema da pesquisa</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais ao 'Problema de Pesquisa'" id="palavrachaveAdicional" style="height: 100px"></textarea>
                        <label for="palavrachaveAdicional">Adicione itens adicionais ao 'Problema de Pesquisa'</label>
                    </div>
                </fieldset>

                <fieldset>
                    <legend id="objetivos"><h4>Objetivo Gerais e especificos</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="objetivo1" value="Introdução - Objetivo Gerais e especificos: Adequação dos objetivos">              <label class="d-inline form-check-label" for="objetivo1">Adequação dos objetivos</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="objetivo2" value="Introdução - Objetivo Gerais e especificos: Relevancia dos objetivos">             <label class="d-inline form-check-label" for="objetivo2">Relevancia dos objetivos</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="objetivo3" value="Introdução - Objetivo Gerais e especificos: Completude dos objetivos especificos"> <label class="d-inline form-check-label" for="objetivo3">Completude dos objetivos especificos</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="objetivo4" value="Introdução - Objetivo Gerais e especificos: Qualidade dos objetivos">              <label class="d-inline form-check-label" for="objetivo4">Qualidade dos objetivos</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais aos 'Objetivos Gerais e Especificos'" id="objetivoAdicional" style="height: 100px"></textarea>
                        <label for="objetivoAdicional">Adicione itens adicionais aos 'Objetivos Gerais e Especificos'</label>
                    </div>
                </fieldset>

                <fieldset>
                    <legend id="hipotese"><h4>Hipótese</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="hipotese1" value="Introdução - Hipótese: Adequação da hipótese">              <label class="d-inline form-check-label" for="hipotese1">Adequação da hipótese</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="hipotese2" value="Introdução - Hipótese: Relevância da hipótese">             <label class="d-inline form-check-label" for="hipotese2">Relevância da hipótese</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais aos 'Objetivos Gerais e Especificos'" id="hipoteseAdicional" style="height: 100px"></textarea>
                        <label for="hipoteseAdicional">Adicione itens adicionais aos 'Objetivos Gerais e Especificos'</label>
                    </div>
                </fieldset>

                <!-- rever esses itens -->
                <input type="checkbox" name="item[]" value="Introdução: Completude da Introdução e da contextualização da Produção Acadêmica"> Completude da Introdução e da contextualização da Produção Acadêmica<br>
                <input type="checkbox" name="item[]" value="Introdução: Qualidade da Introdução e da contextualização da Produção Acadêmica"> Qualidade da Introdução e da contextualização da Produção Acadêmica<br>
                <p> Deseja adicionar mais algum item?</p>
                <textarea name="item[]" id=""></textarea>
                <!-- rever esses itens -->

                <fieldset>
                    <legend id="justificativa"><h4>Justificativa</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="justificativa1" value="Justificativa: Fundamentação da justificativa">  <label class="d-inline form-check-label" for="justificativa1">Fundamentação da justificativa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="justificativa2" value="Justificativa: Relevancia da justificativa">     <label class="d-inline form-check-label" for="justificativa2">Relevancia da justificativa</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais a 'Justificava'" id="justificativaAdicional" style="height: 100px"></textarea>
                        <label for="justificativaAdicional">Adicione itens adicionais a 'Justificava'</label>
                    </div>
                </fieldset>


                <fieldset>
                    <legend id="estadoarte"><h4>Estado da arte</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="estadoarte1" value="Introdução - Estado da arte: Revisão da literatura">                   <label class="d-inline form-check-label" for="estadoarte1">Revisão da literatura</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="estadoarte2" value="Introdução - Estado da arte: Profundidade da revisão da literatura">   <label class="d-inline form-check-label" for="estadoarte2">Profundidade da revisão da literatura</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="estadoarte3" value="Introdução - Estado da arte: Completude do estado da arte">            <label class="d-inline form-check-label" for="estadoarte3">Completude do estado da arte</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="estadoarte4" value="Introdução - Estado da arte: Qualidade do estado da arte">             <label class="d-inline form-check-label" for="estadoarte4">Qualidade do estado da arte</label></li>
                        </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais a 'Justificava'" id="justificativaAdicional" style="height: 100px"></textarea>
                        <label for="justificativaAdicional">Adicione itens adicionais a 'Justificava'</label>
                    </div>
                </fieldset>
    
                <h3>Método</h3>

                <fieldset>
                    <legend id="sujeitos"><h4>Sujeitos</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos1" value="Método - Sujeitos: Adequação da escolha da População do estudo">              <label class="d-inline form-check-label" for="sujeitos1">Adequação da escolha da População do estudo</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos2" value="Método - Sujeitos: Adequação da quantidade da Amostra">                       <label class="d-inline form-check-label" for="sujeitos2">Adequação da quantidade da Amostra</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos3" value="Método - Sujeitos: Adequação do Recrutamento da amostra">                     <label class="d-inline form-check-label" for="sujeitos3">Adequação do Recrutamento da amostra</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos4" value="Método - Sujeitos: Caracterização da amostra">                                <label class="d-inline form-check-label" for="sujeitos4">Caracterização da amostra</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos5" value="Método - Sujeitos: Caracterização da população do estudo">                    <label class="d-inline form-check-label" for="sujeitos5">Caracterização da população do estudo</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos6" value="Método - Sujeitos: Adequação dos critérios de inclusão">                      <label class="d-inline form-check-label" for="sujeitos6">Adequação dos critérios de inclusão</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos7" value="Método - Sujeitos: Adequação dos Critério de exclusão">                       <label class="d-inline form-check-label" for="sujeitos7">Adequação dos Critério de exclusão</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos8" value="Método - Sujeitos: Adequação do Tamanho da amostra">                          <label class="d-inline form-check-label" for="sujeitos8">Adequação do Tamanho da amostra</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos9" value="Método - Sujeitos: Adequação do cálculo amostral">                            <label class="d-inline form-check-label" for="sujeitos9">Adequação do cálculo amostral</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos10" value="Método - Sujeitos: A população do estudo responde a natureza da pesquisa">   <label class="d-inline form-check-label" for="sujeitos10">A população do estudo responde a natureza da pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos11" value="Método - Sujeitos: O número de sujeitos contempla a natureza da pesquisa">   <label class="d-inline form-check-label" for="sujeitos11">O número de sujeitos contempla a natureza da pesquisa</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais a 'Justificava'" id="justificativaAdicional" style="height: 100px"></textarea>
                        <label for="justificativaAdicional">Adicione itens adicionais a 'Justificava'</label>
                    </div>
                </fieldset>

                <fieldset>
                    <legend id="sujeitos"><h4>Materiais e procedimentos</h4></legend>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos1" value="Método - Materiais e procedimentos: A descrição apresentada dos laboratórios, instrumentos e equipamentos empregados no estudo permite dizer que respondem aos pré-requisitos da pesquisa">   <label class="d-inline form-check-label" for="sujeitos1">A descrição apresentada dos laboratórios, instrumentos e equipamentos empregados no estudo permite dizer que respondem aos pré-requisitos da pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos2" value="Método - Materiais e procedimentos: A descrição das técnicas e dos tratamentos empregados na obtenção dos dados permitem deduzir que os procedimentos respondem à necessidade da pesquisa">   <label class="d-inline form-check-label" for="sujeitos2">A descrição das técnicas e dos tratamentos empregados na obtenção dos dados permitem deduzir que os procedimentos respondem à necessidade da pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos3" value="Método - Materiais e procedimentos: Estrutura científico-metodológica utilizada">                                                                                                             <label class="d-inline form-check-label" for="sujeitos3">Estrutura científico-metodológica utilizada</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos4" value="Método - Materiais e procedimentos: Os instrumentos, equipamentos e tratamentos empregados no estudo para a obtenção dos dados respondem à necessidade da pesquisa">                          <label class="d-inline form-check-label" for="sujeitos4">Os instrumentos, equipamentos e tratamentos empregados no estudo para a obtenção dos dados respondem à necessidade da pesquisa</label></li>
                        </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" placeholder=">Adicione itens adicionais a 'Justificava'" id="justificativaAdicional" style="height: 100px"></textarea>
                        <label for="justificativaAdicional">Adicione itens adicionais a 'Justificava'</label>
                    </div>
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
        </div>
    </div>
</div>



<?php include_once('includes/footer.php') ?>
