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
            <div id="toc"></div>

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
                <!-- Aspectos Gerais -->
                <fieldset class="mt-4">
                    <legend id="aspectosGerais"><h3 class="anchor">Aspectos Gerais</h3></legend>

                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto1" value="Aspectos Gerais: Completude da Produção Acadêmica">                               <label class="d-inline form-check-label" for="aspecto1">Completude da Produção Acadêmica</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto2" value="Aspectos Gerais: Organização das seções da Produção Acadêmica">      <label class="d-inline form-check-label" for="aspecto2">Organização das seções da Produção Acadêmica</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto3" value="Aspectos Gerais: Uso de vocabulário acadêmico/científico adequado">                        <label class="d-inline form-check-label" for="aspecto3">Uso de vocabulário acadêmico/científico adequado</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto4" value="Aspectos Gerais: Originalidade e relevância da Produção Acadêmica">               <label class="d-inline form-check-label" for="aspecto4">Originalidade e relevância da Produção Acadêmica</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto5" value="Aspectos Gerais: Contribuição para a prática profissional na área">               <label class="d-inline form-check-label" for="aspecto5">Contribuição para a prática profissional na área</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="aspecto6" value="Aspectos Gerais: Abrangência geográfica do estudo">                               <label class="d-inline form-check-label" for="aspecto6">Abrangência geográfica do estudo</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens aos 'Aspectos Gerais'" id="aspectoAdicional" style="height: 100px"></textarea>
                        <label for="aspectoAdicional">Adicionar itens aos 'Aspectos Gerais'</label>
                    </div>

                </fieldset>
                <!-- Aspectos Gerais -->

                <!-- Resumo -->
                <fieldset>
                    <legend id="resumo-trabalho"><h3 class="anchor">Resumo</h3></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resumo1" value="Resumo: Adequação científica do Resumo">               <label class="d-inline form-check-label" for="resumo1">Adequação científica do Resumo</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resumo3" value="Resumo: Qualidade do resumo em língua estrangeira">    <label class="d-inline form-check-label" for="resumo3">Qualidade do resumo em língua estrangeira</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens ao 'Resumo'" id="resumoAdicional" style="height: 100px"></textarea>
                        <label for="resumoAdicional">Adicionar itens ao 'Resumo'</label>
                    </div>
                </fieldset>
                <!-- Resumo -->

                <!-- Palavra-chave -->
                <fieldset>
                    <legend id="palavrachave"><h3 class="anchor">Palavra-chave</h3></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="palavrachave1" value="Palavra-chave: Adequação das palavras-chaves para o tema da Produção Acadêmica">   <label class="d-inline form-check-label" for="palavrachave1">Adequação das palavras-chaves para o tema da Produção Acadêmica</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens as 'Palavras-chaves'" id="palavrachaveAdicional" style="height: 100px"></textarea>
                        <label for="palavrachaveAdicional">Adicionar itens as 'Palavras-chaves'</label>
                    </div>
                </fieldset>
                <!-- Palavra-chave -->

                <h3 class="anchor">Introdução</h3>
                
                <!-- Introdução - Problema de pesquisa -->
                <fieldset>
                    <legend id="problemapesquisa"><h4>Problema de Pesquisa</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="problemapesquisa3" value="Introdução - Problema de pesquisa: Contextualização do problema da pesquisa">         <label class="d-inline form-check-label" for="problemapesquisa3">Contextualização do problema da pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="problemapesquisa1" value="Introdução - Problema de pesquisa: Formulação do problema de pesquisa">               <label class="d-inline form-check-label" for="problemapesquisa1">Formulação do problema de pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="problemapesquisa2" value="Introdução - Problema de pesquisa: Delimitação do tema da pesquisa">                  <label class="d-inline form-check-label" for="problemapesquisa2">Delimitação do tema da pesquisa</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control"  name="item[]" placeholder="Adicionar itens ao 'Problema de Pesquisa'" id="palavrachaveAdicional" style="height: 100px"></textarea>
                        <label for="palavrachaveAdicional">Adicionar itens ao 'Problema de Pesquisa'</label>
                    </div>
                </fieldset>
                <!-- Introdução - Problema de pesquisa -->
                
                <!-- Objetivo Gerais e especificos -->
                <fieldset>
                    <legend id="objetivos"><h4>Objetivo Gerais e especificos</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="objetivo1" value="Introdução - Objetivo Gerais e especificos: Adequação dos objetivos">              <label class="d-inline form-check-label" for="objetivo1">Adequação dos objetivos</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="objetivo2" value="Introdução - Objetivo Gerais e especificos: Relevancia dos objetivos">             <label class="d-inline form-check-label" for="objetivo2">Relevancia dos objetivos</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="objetivo3" value="Introdução - Objetivo Gerais e especificos: Completude dos objetivos especificos"> <label class="d-inline form-check-label" for="objetivo3">Completude dos objetivos especificos</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens aos 'Objetivos Gerais e Especificos'" id="objetivoAdicional" style="height: 100px"></textarea>
                        <label for="objetivoAdicional">Adicionar itens aos 'Objetivos Gerais e Especificos'</label>
                    </div>
                </fieldset>
                <!-- Objetivo Gerais e especificos -->

                <!-- Introdução - Hipótese -->
                <fieldset>
                    <legend id="hipotese"><h4>Hipótese</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="hipotese1" value="Introdução - Hipótese: Adequação da hipótese">                                                <label class="d-inline form-check-label" for="hipotese1">Adequação da hipótese</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="hipotese2" value="Introdução - Hipótese: Relevância da hipótese">                                               <label class="d-inline form-check-label" for="hipotese2">Relevância da hipótese</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea name="item[]" class="form-control" placeholder="Adicionar itens aos 'Objetivos Gerais e Especificos'" id="hipoteseAdicional" style="height: 100px"></textarea>
                        <label for="hipoteseAdicional">Adicionar itens aos 'Objetivos Gerais e Especificos'</label>
                    </div>
                </fieldset>
                <!-- Introdução - Hipótese -->

                 <!-- Justificativa -->
                 <fieldset>
                    <legend id="justificativa"><h3 class="anchor">Justificativa</h3></legend>
                    <ul class="list-group list-group-flush">
                         <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="justificativa2" value="Justificativa: Relevancia da justificativa">     <label class="d-inline form-check-label" for="justificativa2">Relevancia da justificativa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="justificativa1" value="Justificativa: Completude da justificativa">  <label class="d-inline form-check-label" for="justificativa1">Completude da justificativa</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens a 'Justificativa'" id="justificativaAdicional" style="height: 100px"></textarea>
                        <label for="justificativaAdicional">Adicionar itens a 'Justificativa'</label>
                    </div>
                </fieldset>
                <!-- Justificativa --> 

                <!-- Introdução - Estado da arte -->
                <fieldset>
                    <legend id="estadoarte"><h4 class="anchor">Estado da arte</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="estadoarte3" value="Introdução - Estado da arte: Completude / Profundidade do estado da arte">            <label class="d-inline form-check-label" for="estadoarte3">Completude / Profundidade do estado da arte</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="estadoarte4" value="Introdução - Estado da arte: Relevancia / Qualidade do estado da arte">             <label class="d-inline form-check-label" for="estadoarte4">Relevancia / Qualidade do estado da arte</label></li>
                        </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens a 'Estado da arte'" id="justificativaAdicional" style="height: 100px"></textarea>
                        <label for="justificativaAdicional">Adicionar itens a 'Estado da arte'</label>
                    </div>
                </fieldset>  
                <!-- Introdução - Estado da arte -->
                       
                
                <h3 class="anchor">Metodologia</h3>

                <!-- Metodologia - Sujeitos -->
                <fieldset>
                    <legend id="sujeitos"><h4>Sujeitos</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos1" value="Metodologia - Sujeitos: Adequação do Sujeito / População do estudo">              <label class="d-inline form-check-label" for="sujeitos1">Adequação do Sujeito / População do estudo</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos2" value="Metodologia - Sujeitos: Adequação do tamanho da Amostra">                       <label class="d-inline form-check-label" for="sujeitos2">Adequação do Tamanho da Amostra</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos9" value="Metodologia - Sujeitos: Adequação do cálculo amostral">                            <label class="d-inline form-check-label" for="sujeitos9">Adequação do cálculo amostral</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos3" value="Metodologia - Sujeitos: Adequação do Recrutamento da amostra">                     <label class="d-inline form-check-label" for="sujeitos3">Adequação do Recrutamento da amostra</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos4" value="Metodologia - Sujeitos: Adequação da Caracterização da amostra">                                <label class="d-inline form-check-label" for="sujeitos4">Adequação da Caracterização da amostra</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos10" value="Metodologia - Sujeitos: A população / Sujeitos do estudo responde a natureza da pesquisa">   <label class="d-inline form-check-label" for="sujeitos10">A população / Sujeitos do estudo responde a natureza da pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="sujeitos11" value="Metodologia - Sujeitos: O número de sujeitos contempla a natureza da pesquisa">   <label class="d-inline form-check-label" for="sujeitos11">O número de sujeitos contempla a natureza da pesquisa</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens a 'Sujeitos'" id="justificativaAdicional" style="height: 100px"></textarea>
                        <label for="justificativaAdicional">Adicionar itens a 'Sujeitos'</label>
                    </div>
                </fieldset>
                <!-- Método - Sujeitos -->

                <!-- Método - Materiais e procedimentos -->
                <fieldset>
                    <legend id="sujeitos"><h4>Materiais e procedimentos</h4></legend>
                    <ul class="list-group list-group-flush">

                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="materiais1" value="Método - Materiais e procedimentos: A descrição apresentada dos laboratórios, instrumentos e equipamentos empregados no estudo permite dizer que respondem aos pré-requisitos da pesquisa">   <label class="d-inline form-check-label" for="materiais1">A descrição apresentada dos laboratórios, instrumentos e equipamentos empregados no estudo permite dizer que respondem aos pré-requisitos da pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="materiais2" value="Método - Materiais e procedimentos: A descrição das técnicas e dos tratamentos empregados na obtenção dos dados permitem deduzir que os procedimentos respondem à necessidade da pesquisa">   <label class="d-inline form-check-label" for="materiais2">A descrição das técnicas e dos tratamentos empregados na obtenção dos dados permitem deduzir que os procedimentos respondem à necessidade da pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="materiais3" value="Método - Materiais e procedimentos: Estrutura científico-metodológica utilizada">                                                                                                             <label class="d-inline form-check-label" for="materiais3">Estrutura científico-metodológica utilizada</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="materiais4" value="Método - Materiais e procedimentos: Os instrumentos, equipamentos e tratamentos empregados no estudo para a obtenção dos dados respondem à necessidade da pesquisa">                          <label class="d-inline form-check-label" for="materiais4">Os instrumentos, equipamentos e tratamentos empregados no estudo para a obtenção dos dados respondem à necessidade da pesquisa</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens a 'Justificava'" id="materiaisAdicional" style="height: 100px"></textarea>
                        <label for="materiaisaAdicional">Adicionar itens a 'Justificava'</label>
                    </div>
                </fieldset>
                <!-- Método - Materiais e procedimentos -->

                <!-- Método - Coleta de dados -->
                <fieldset>
                    <legend id="metodos"><h4>Coleta de dados</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="coleta1" value="Método - Coleta de dados: A coleta dos dados foi conduzida em local e tempo adequados">                                              <label class="d-inline form-check-label" for="coleta1">A coleta dos dados foi conduzida em local e tempo adequados</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="coleta2" value="Método - Coleta de dados: Os instrumentos de coleta (questionários, entrevistas etc.estão coerentes com a natureza da pesquisa)">    <label class="d-inline form-check-label" for="coleta2">Os instrumentos de coleta (questionários, entrevistas etc.estão coerentes com a natureza da pesquisa)</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="coleta3" value="Método - Coleta de dados: Os Materiais: equipamentos e experimentos permitiram a coleta de dados requerida pelo estudo">             <label class="d-inline form-check-label" for="coleta3">Os Materiais: equipamentos e experimentos permitiram a coleta de dados requerida pelo estudo</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens a 'Coleta de dados'" id="coletaAdicional" style="height: 100px"></textarea>
                        <label for="coletaAdicional">Adicionar itens a 'Coleta de dados'</label>
                    </div>
                </fieldset>
                <!-- Método - Coleta de dados -->
                
                <!-- Método - Resultados -->
                <fieldset>
                    <legend id="resultados"><h4>Resultados</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resultados1" value="Método - Resultados: Coerência dos resultados com o método utilizado">                                              <label class="d-inline form-check-label" for="resultados1">Coerência dos resultados com o método utilizado</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resultados2" value="Método - Resultados: Precisão dos dados coletados">                                                                 <label class="d-inline form-check-label" for="resultados2">Precisão dos dados coletados</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resultados3" value="Método - Resultados: Concisão dos dados coletados">                                                                 <label class="d-inline form-check-label" for="resultados3">Concisão dos dados coletados</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resultados4" value="Método - Resultados: Clareza dos dados coletados">                                                                  <label class="d-inline form-check-label" for="resultados4">Clareza dos dados coletados</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resultados5" value="Método - Resultados: Reprodutibilidade dos resultados obtidos">                                                     <label class="d-inline form-check-label" for="resultados5">Reprodutibilidade dos resultados obtidos</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resultados6" value="Método - Resultados: Confiabilidade e fidedignidade dos dados obtidos">                                             <label class="d-inline form-check-label" for="resultados6">Confiabilidade e fidedignidade dos dados obtidos</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resultados7" value="Método - Resultados: A qualidade das figuras, gráficos, tabelas ou esquemas usados expressão os dados obtidos">     <label class="d-inline form-check-label" for="resultados7">A qualidade das figuras, gráficos, tabelas ou esquemas usados expressão os dados obtidos</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens aos 'Resultados'" id="coletaAdicional" style="height: 100px"></textarea>
                        <label for="coletaAdicional">Adicionar itens aos 'Resultados'</label>
                    </div>
                </fieldset>
                <!-- Método - Resultados -->
                
                <!-- Método - Cronograma -->
                <fieldset>
                    <legend id="resultados"><h4 class="anchor">Cronograma</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="cronograma1" value="Método - Cronograma: O cronograma é viável no tempo disponível para a pesquisa">                      <label class="d-inline form-check-label" for="cronograma1">O cronograma é viável no tempo disponível para a pesquisa</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="cronograma2" value="Método - Cronograma: A organização do cronograma é claraa">                                           <label class="d-inline form-check-label" for="cronograma2">A organização do cronograma é clara</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens a 'Cronograma'" id="cronogramaAdicional" style="height: 100px"></textarea>
                        <label for="cronogramaAdicional">Adicionar itens ao 'Cronograma'</label>
                    </div>
                </fieldset>
                <!-- Método - Cronograma -->

                <!-- Orçamento -->
                <fieldset>
                    <legend id="resultados"><h3 class="anchor">Orçamento</h3></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="orcamento1" value="Orçamento: Adequação do Custeio">                               <label class="d-inline form-check-label" for="orcamento1">Adequação do Custeio</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="orcamento2" value="Orçamento: Adequação do Capital">                               <label class="d-inline form-check-label" for="orcamento2">Adequação do Capital</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="orcamento3" value="Orçamento: Relevância da contrapartida">                        <label class="d-inline form-check-label" for="orcamento3">Relevância da contrapartida</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="orcamento4" value="Orçamento: Descrição dos materiais permanentes">                <label class="d-inline form-check-label" for="orcamento4">Descrição dos materiais permanentes</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="orcamento5" value="Orçamento: Adequação do material de consumo">                   <label class="d-inline form-check-label" for="orcamento5">Adequação do material de consumo</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="orcamento6" value="Orçamento: Relevância/necessidade dos serviços de terceiros">   <label class="d-inline form-check-label" for="orcamento6">Relevância/necessidade dos serviços de terceiros</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="orcamento7" value="Orçamento: Solicitação dos recursos humanos">                   <label class="d-inline form-check-label" for="orcamento7">Solicitação dos recursos humanos</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens ao 'Orçamento'" id="orcamentoAdicional" style="height: 100px"></textarea>
                        <label for="orcamentoAdicional">Adicionar itens ao 'Orçamento'</label>
                    </div>
                </fieldset>
                <!-- Orçamento -->

                <!-- Análise -->
                <fieldset>
                    <legend id="resultados"><h3 class="anchor">Análise dos Dados</h3></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="analiseDados1" value="Análise: Profundidade da análise">                                                                     <label class="d-inline form-check-label" for="analiseDados1">Profundidade da análise</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="analiseDados2" value="Análise: Coerência da análise com os dados coletados">                                                 <label class="d-inline form-check-label" for="analiseDados2">Coerência da análise com os dados coletados</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="analiseDados3" value="Análise: Coerência da analise com a fundamentação teorica">                                            <label class="d-inline form-check-label" for="analiseDados3">Coerência da analise com a fundamentação teorica</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="analiseDados4" value="Análise: A análise apresentada não mostra vieses científicos">                                         <label class="d-inline form-check-label" for="analiseDados4">A análise apresentada não mostra vieses científicos</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="analiseDados5" value="Análise: A análise produzida está coerente com a Discriminação/definição das variáveis estudadas">     <label class="d-inline form-check-label" for="analiseDados5">A análise produzida está coerente com a Discriminação/definição das variáveis estudadas</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="analiseDados6" value="Análise: A análise condiz com a Organização e tabulação dos dados">                                    <label class="d-inline form-check-label" for="analiseDados6">A análise condiz com a Organização e tabulação dos dados</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="analiseDados7" value="Análise: A análise feita condiz com o Tratamento e testes estatísticos utilizados">                    <label class="d-inline form-check-label" for="analiseDados7">A análise feita condiz com o Tratamento e testes estatísticos utilizados</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="analiseDados8" value="Análise: O(s) Programa(s) utilizados para tabulação e análise deram conta dos resultados obtidos">     <label class="d-inline form-check-label" for="analiseDados8">O(s) Programa(s) utilizados para tabulação e análise deram conta dos resultados obtidos </label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens a 'Análise dos Dados'" id="coletaAdicional" style="height: 100px"></textarea>
                        <label for="coletaAdicional">Adicionar itens a 'Análise dos Dados'</label>
                    </div>
                </fieldset>
                <!-- Análise -->
                
                <!-- Discursão -->
                <fieldset>
                    <legend id="discursao"><h3>Discursão</h3></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="discursao1" value="Discursão: Profundidade da discursão">                               <label class="d-inline form-check-label" for="discursao1">Profundidade da discursão</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="discursao2" value="Discursão: Coerência da discursão com os dados coletados">           <label class="d-inline form-check-label" for="discursao2">Coerência da discursão com os dados coletados</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="discursao3" value="Discursão: Coerência da discursão com a fundamentação teorica">      <label class="d-inline form-check-label" for="discursao3">Coerência da discursão com a fundamentação teorica</label></li>
                    </ul>

                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens ao 'Discursão'" id="discursaoAdicional" style="height: 100px"></textarea>
                        <label for="discursaoAdicional">Adicionar itens a 'Discursão'</label>
                    </div>
                </fieldset>
                <!-- Discursão -->

                <!-- Conclusão -->
                <fieldset>
                    <legend id="conclusao"><h3 class="anchor">Conclusão</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="conclusao1" value="Conclusão: Profundidade das conclusões">                               <label class="d-inline form-check-label" for="conclusao1">Profundidade das conclusões</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="conclusao2" value="Conclusão: Coerência das conclusões com os dados coletados">           <label class="d-inline form-check-label" for="conclusao2">Coerência das conclusões com os dados coletados</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="conclusao3" value="Conclusão: Coerência das conclusões com a fundamentação teorica">      <label class="d-inline form-check-label" for="conclusao3">Coerência das conclusões com a fundamentação teorica</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens a 'Conclusão'" id="conclusaoAdicional" style="height: 100px"></textarea>
                        <label for="conclusaoAdicional">Adicionar itens a 'Conclusão'</label>
                    </div>
                </fieldset>
                <!-- Conclusão -->


                <fieldset>
                    <legend id="conclusao"><h3 class="anchor">Referências bibliográficas</h4></legend>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="referencia1" value="Referências bibliográficas: Relevância e atualidade das referências bibliográficas">                               <label class="d-inline form-check-label" for="referencia1">Relevância e atualidade das referências bibliográficas</label></li>
                        <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="referencia2" value="Referências bibliográficas: Conformidade das referências com as normas da ABNT">                                   <label class="d-inline form-check-label" for="referencia2">Conformidade das referências com as normas da ABNT</label></li>
                    </ul>
                    <div class="form-floating my-4">
                        <textarea class="form-control" name="item[]" placeholder="Adicionar itens as 'Referências bibliográficas'" id="conclusaoAdicional" style="height: 100px"></textarea>
                        <label for="conclusaoAdicional">Adicionar itens as 'Referências bibliográficas'</label>
                    </div>
                </fieldset>
                <!-- Conclusão -->

                <fieldset>
                    <legend><h2>Definição dos itens aplicados</h2></legend>
                        <p>Assinale quais dos itens abaixo se aplicam ao Projeto Acadêmico em avaliação:</p>
                        <ul class="list-group list-group-flush">
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="titulo" value="Apresenta título da Produção Acadêmica">                             <label class="d-inline form-check-label" for="titulo">Apresenta título da Produção Acadêmica</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resumo" value="Apresenta resumo">                                                   <label class="d-inline form-check-label" for="resumo">Apresenta resumo</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="palavrasChaves" value="Apresenta palavras-chaves">                                  <label class="d-inline form-check-label" for="palavrasChaves">Apresenta palavras-chaves</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="resumoEstrangeira" value="Apresenta resumo em língua estrangeira">                  <label class="d-inline form-check-label" for="resumoEstrangeira">Apresenta resumo em língua estrangeira</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="palavrasChavesEstrangeira" value="Apresenta palavras-chaves em língua estrangeira"> <label class="d-inline form-check-label" for="palavrasChavesEstrangeira">Apresenta palavras-chaves em língua estrangeira</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="introducao" value="Apresenta Introdução e contextualização">                        <label class="d-inline form-check-label" for="introducao">Apresenta Introdução e contextualização</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="objetivos" value="Apresenta objetivos e justificativa">                             <label class="d-inline form-check-label" for="objetivos">Apresenta objetivos e justificativa</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="estadoArte" value="Apresenta estado da arte">                                       <label class="d-inline form-check-label" for="estadoArte">Apresenta estado da arte</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="estrutura" value="Apresenta estrutura científico-metodológica">                     <label class="d-inline form-check-label" for="estrutura">Apresenta estrutura científico-metodológica</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="analise" value="Apresenta análise, considerações ou conclusões">                    <label class="d-inline form-check-label" for="analise">Apresenta análise, considerações ou conclusões</label></li>
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" id="referencias" value="Apresenta referências bibliográficas">                          <label class="d-inline form-check-label" for="referencias">Apresenta referências bibliográficas</label></li>                      
                            <li class="px-0 list-group-item"><input type="checkbox" name="item[]" class="form-check-input me-1" type="checkbox" value="Apresenta Aprovação do Comitê de Ética em Pesquisa">                             <label class="d-inline form-check-label" for="aprovacaoComite">Apresenta Aprovação do Comitê de Ética em Pesquisa</label><br>
                            <div class="form-floating my-4">
                        </ul>
                        <div class="form-floating my-4">
                            <textarea class="form-control" name="item[]" placeholder="Adicionar itens as 'Definição dos itens aplicados'" id="aplicacaoAdicional" style="height: 100px"></textarea>
                            <label for="aplicacaoAdicional">Adicionar itens as 'Referências bibliográficas'</label>
                        </div>
                </fieldset>
                
                
                <div class="text-end my-4">
                    <button class="btn btn-primary" type="submit" aria-label="Salvar e Avançar" title="Salva e finaliza a edição deste Instrumento de Avaliação">
                    Salvar e Avançar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
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
