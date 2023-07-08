<?php include_once('includes/head.php') ?>

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
        </div>
        <div class="col-12 mx-auto col-md-8">
            <p>Excelente! Estamos prontos para começar nosso trabalho. Quero dizer, o seu.</p>
            <p>Selecione em cada tópico, os itens que você quer que eu adicione no IAPA que você está construindo. Se nenhum item de um tópico for aplicável, apenas pule-o, e eu não o incluirei no IAPA. Não se esqueça de pressionar o botão Avançar e salvar, para eu lhe levar ao próximo passo.</p>
            <p> Está pronto, <?php echo $pronomeTratamento;?> <strong><?php echo $nomeUsuario; ?></strong>, Então vamos trabalhar!</p>
            
            <form id="formItens" class="mt-5" action="salvar_arquivo.php" method="POST">
            
                <input type="hidden" name="categorias" value="<?php echo $categorias;?>">
                <!-- Aspectos Gerais -->
                <fieldset class="mb-5">
                    <legend><h2>Aspectos Gerais</h2></legend>
                    <ul class="list-group  list-group-flush">
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="aspectos1" value="Aspectos Gerais: Completude da Produção Acadêmica"><label class="form-check-label" for="aspectos1">Completude da Produção Acadêmica</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="aspectos2" value="Aspectos Gerais: Completude e organização das seções da Produção Acadêmica"><label class="form-check-label" for="aspectos2">Completude e organização das seções da Produção Acadêmica</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="aspectos3" value="Aspectos Gerais: Uso de vocabulário acadêmico/científico"><label class="form-check-label" for="aspectos3">Uso de vocabulário acadêmico/científico</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="aspectos4" value="Aspectos Gerais: Originalidade e relevância da Produção Acadêmica"><label class="form-check-label" for="aspectos4">Originalidade e relevância da Produção Acadêmica</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="aspectos5" value="Aspectos Gerais: Contribuição para a prática profissional na área"><label class="form-check-label" for="aspectos5">Contribuição para a prática profissional na área</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="aspectos6" value="Aspectos Gerais: Abrangência geográfica do estudo"><label class="form-check-label" for="aspectos6">Abrangência geográfica do estudo</label></li>
                    </ul>
                    
                    <div class="mt-3 form-floating">
                        <textarea class="form-control" id="aspectosAdicional" name="item[]" placeholder="Adicione neste espaço itens adicionais associados aos 'Aspectos Gerais' na avaliação" style="height: 100px"></textarea>
                        <label for="aspectosAdicional">Adicione neste espaço itens adicionais associados aos 'Aspectos Gerais' na avaliação</label>
                    </div>

                    <!--
                        <input type="checkbox" name="item[]" value="Resumo: Adequação científica do Resumo"> Adequação científica do Resumo<br>
                        <input type="checkbox" name="item[]" value="Resumo: Qualidade do resumo"> Qualidade do resumo<br>
                        <input type="checkbox" name="item[]" value="Resumo: Qualidade do resumo em língua estrangeira"> Qualidade do resumo em língua estrangeira<br>
                        <p> Deseja adicionar mais algum item?</p>
                        <textarea name="item[]" id=""></textarea>
                    -->

                </fieldset>

                <!-- Resumo -->
                <fieldset class="mb-5">
                    <legend><h2>Resumo</h2></legend>

                    <ul class="list-group  list-group-flush">
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="resumo1" value="Aspectos Gerais: Adequação científica do Resumo"><label class="form-check-label" for="resumo1">Adequação científica do Resumo</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="resumo2" value="Aspectos Gerais: Qualidade do resumo"><label class="form-check-label" for="resumo2">Qualidade do resumo</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="resumo3" value="Aspectos Gerais: Qualidade do resumo em língua estrangeira"><label class="form-check-label" for="resumo3">Qualidade do resumo em língua estrangeira</label></li>
                    </ul>
                    
                    <div class="mt-3 form-floating">
                        <textarea class="form-control" id="resumoAdicional" name="item[]" placeholder="Adicione neste espaço itens adicionais associados ao 'Resumo' na avaliação" style="height: 100px"></textarea>
                        <label for="resumoAdicional">Adicione neste espaço itens adicionais associados ao 'Resumo' na avaliação</label>
                    </div>
                    <!-- <input type="checkbox" id="" name="item[]" value="Resumo: Adequação científica do Resumo"> Adequação científica do Resumo<br>
                        <input type="checkbox" id="" name="item[]" value="Resumo: Qualidade do resumo"> Qualidade do resumo<br>
                        <input type="checkbox" id="" name="item[]" value="Resumo: Qualidade do resumo em língua estrangeira"> Qualidade do resumo em língua estrangeira<br>
                        <p> Deseja adicionar mais algum item?</p>
                        <textarea name="item[]" id=""></textarea> -->
                </fieldset>

                <!-- Palavra-chave -->
                <fieldset class="mb-5">
                    <legend><h2>Palavra-chave</h2></legend>
                    <ul class="list-group  list-group-flush">
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="palavrachave1" value="Palavra-chave: Adequação das palavras-chaves apresentadas ao tema da Produção Acadêmica"><label class="form-check-label" for="palavrachave1">Adequação das palavras-chaves apresentadas ao tema da Produção Acadêmica</label></li>
                    </ul>
                    <div class="mt-3 form-floating">
                        <textarea class="form-control" id="palavrachaveAdicional" name="item[]" placeholder="Adicione neste espaço itens adicionais associados a 'Palavra-Chave' na avaliação" style="height: 100px"></textarea>
                        <label for="palavrachaveAdicional">Adicione neste espaço itens adicionais associados a 'Palavra-Chave' na avaliação</label>
                    </div>
                        <!-- <input type="checkbox" id="" name="item[]" value="Palavra-chave: Adequação das palavras-chaves apresentadas ao tema da Produção Acadêmica"> Adequação das palavras-chaves apresentadas ao tema da Produção Acadêmica<br>
                        <p> Deseja adicionar mais algum item?</p>
                        <textarea name="item[]" id=""></textarea> -->
                </fieldset>
                <h2>Introdução</h2>
                <fieldset class="mb-5">
                    <legend><h3>Problema de Pesquisa</h3></legend>

                    <ul class="list-group  list-group-flush">
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="problema-pesquisa1" value="Introdução: Formulação do problema de pesquisa"><label class="form-check-label" for="problema-pesquisa1">Formulação do problema de pesquisa</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="problema-pesquisa2" value="Introdução: Delimitação do tema da pesquisa"><label class="form-check-label" for="problema-pesquisa2">Delimitação do tema da pesquisa</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="problema-pesquisa3" value="Introdução: Contextualização do problema da pesquisa"><label class="form-check-label" for="problema-pesquisa3">Contextualização do problema da pesquisa</label></li>
                    </ul>
                    <div class="mt-3 form-floating">
                        <textarea class="form-control" id="problema-pesquisaAdicional" name="item[]" placeholder="Adicione neste espaço itens adicionais associados a 'Palavra-Chave' na avaliação" style="height: 100px"></textarea>
                        <label for="problema-pesquisaAdicional">Adicione neste espaço itens adicionais associados a 'Introdução' na avaliação</label>
                    </div>

                    <!--
                        <input type="checkbox" id="" name="item[]" value="Introdução - Problema de pesquisa: Formulação do problema de pesquisa"> Formulação do problema de pesquisa<br>
                        <input type="checkbox" id="" name="item[]" value="Introdução - Problema de pesquisa: Delimitação do tema da pesquisa"> Delimitação do tema da pesquisa<br>
                        <input type="checkbox" id="" name="item[]" value="Introdução - Problema de pesquisa: Contextualização do problema da pesquisa"> Contextualização do problema da pesquisa<br>
                        <p> Deseja adicionar mais algum item?</p>
                        <textarea name="item[]" id=""></textarea> -->
                </fieldset>

                <fieldset class="mb-5">
                    <legend><h3>Estado da arte</h3></legend>

                    <ul class="list-group  list-group-flush">
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="estado-arte1" value="Introdução - Estado da arte: Revisão da literatura"><label class="form-check-label" for="estado-arte1">Revisão da literatura</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="estado-arte2" value="Introdução - Estado da arte: Profundidade da revisão da literatura"><label class="form-check-label" for="estado-arte2">Profundidade da revisão da literatura</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="estado-arte3" value="Introdução - Estado da arte: Completude do estado da arte"><label class="form-check-label" for="estado-arte3">Completude do estado da arte</label></li>
                        <li class="px-0 list-group-item"><input class="form-check-input me-1" type="checkbox" name="item[]" id="estado-arte4" value="Introdução - Estado da arte: Qualidade do estado da arte"><label class="form-check-label" for="estado-arte4">Qualidade do estado da arte</label></li>
                    </ul>
                    <div class="mt-3 form-floating">
                        <textarea class="form-control" id="problema-pesquisaAdicional" name="item[]" placeholder="Adicione neste espaço itens adicionais associados ao 'Estado da Arte' na avaliação" style="height: 100px"></textarea>
                        <label for="problema-pesquisaAdicional">Adicione neste espaço itens adicionais associados ao 'Estado da Arte' na avaliação</label>
                    </div>
                    <!--
                        <input type="checkbox" id="" name="item[]" value="Introdução - Estado da arte: Revisão da literatura"> Revisão da literatura<br>
                        <input type="checkbox" id="" name="item[]" value="Introdução - Estado da arte: Profundidade da revisão da literatura"> Profundidade da revisão da literatura<br>
                        <input type="checkbox" id="" name="item[]" value="Introdução - Estado da arte: Completude do estado da arte"> Completude do estado da arte<br>
                        <input type="checkbox" id="" name="item[]" value="Introdução - Estado da arte: Qualidade do estado da arte"> Qualidade do estado da arte<br>
                        <p> Deseja adicionar mais algum item?</p>
                        <textarea name="item[]" id=""></textarea>
                        -->
                </fieldset>

                    <fieldset class="mb-5">
                        <legend><h3>Objetivo Gerais e especificos</h3></legend>
                            <input type="checkbox" id="" name="item[]" value="Introdução - Objetivo Gerais e especificos: Adequação dos objetivos"> Adequação dos objetivos <br>
                            <input type="checkbox" id="" name="item[]" value="Introdução - Objetivo Gerais e especificos: Relevancia dos objetivos"> Relevancia dos objetivos <br>
                            <input type="checkbox" id="" name="item[]" value="Introdução - Objetivo Gerais e especificos: Completude dos objetivos especificos"> Completude dos objetivos especificos<br>
                            <input type="checkbox" id="" name="item[]" value="Introdução - Objetivo Gerais e especificos: Qualidade dos objetivos"> Qualidade dos objetivos<br>
                            <p> Deseja adicionar mais algum item?</p>
                            <textarea name="item[]" id=""></textarea>
                        </fieldset>

                    <fieldset class="mb-5">
                        <legend><h2>Hipótese</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Introdução - Hipótese: Adequação da hipótese"> Adequação da hipótese<br>
                        <input type="checkbox" id="" name="item[]" value="Introdução - Hipótese: Relevância da hipótese"> Relevância da hipótese<br>
                        <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                    </fieldset>
                    
                    <br>
                    <input type="checkbox" id="" name="item[]" value="Introdução: Completude da Introdução e da contextualização da Produção Acadêmica"> Completude da Introdução e da contextualização da Produção Acadêmica<br>
                    <input type="checkbox" id="" name="item[]" value="Introdução: Qualidade da Introdução e da contextualização da Produção Acadêmica"> Qualidade da Introdução e da contextualização da Produção Acadêmica<br>
                    <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                </fieldset>

                <fieldset class="mb-5">
                    <legend><h2>Justificativa</h2></legend>
                    <input type="checkbox" id="" name="item[]" value="justificativa: Fundamentação da justificativa"> Fundamentação da justificativa <br>
                    <input type="checkbox" id="" name="item[]" value="justificativa: Relevancia da justificativa"> Relevancia da justificativa <br>
                    <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                </fieldset>
                
                <fieldset class="mb-5">
                    <legend><h2>Método</h2></legend>

                    <fieldset class="mb-5">
                        <legend><h2>Sujeitos</h2></legend>

                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: Adequação da escolha da População do estudo">Adequação da escolha da População do estudo<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: Adequação da quantidade da Amostra">Adequação da quantidade da Amostra<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: Adequação do Recrutamento da amostra">Adequação do Recrutamento da amostra<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: Caracterização da amostra">Caracterização da amostra<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: Caracterização da população do estudo">Caracterização da população do estudo<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: Adequação dos critérios de inclusão">Adequação dos critérios de inclusão<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: Adequação dos Critério de exclusão">Adequação dos Critério de exclusão<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: Adequação do Tamanho da amostra"> Adequação do Tamanho da amostra<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: Adequação do cálculo amostral">Adequação do cálculo amostral<br>
                        



                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: A população do estudo responde a natureza da pesquisa">A população do estudo responde a natureza da pesquisa<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Sujeitos: O número de sujeitos contempla a natureza da pesquisa">O número de sujeitos contempla a natureza da pesquisa<br>
                        <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                    </fieldset>

                    <fieldset class="mb-5">
                        <legend><h2>Materiais e procedimentos</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Método - Materiais e procedimentos: A descrição apresentada dos laboratórios, instrumentos e equipamentos empregados no estudo permite dizer que respondem aos pré-requisitos da pesquisa">A descrição apresentada dos laboratórios, instrumentos e equipamentos empregados no estudo permite dizer que respondem aos pré-requisitos da pesquisa<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Materiais e procedimentos: A descrição das técnicas e dos tratamentos empregados na obtenção dos dados permitem deduzir que os procedimentos respondem à necessidade da pesquisa">A descrição das técnicas e dos tratamentos empregados na obtenção dos dados permitem deduzir que os procedimentos respondem à necessidade da pesquisa<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Materiais e procedimentos: Estrutura científico-metodológica utilizada"> Estrutura científico-metodológica utilizada<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Materiais e procedimentos: Os instrumentos, equipamentos e tratamentos empregados no estudo para a obtenção dos dados respondem à necessidade da pesquisa">Os instrumentos, equipamentos e tratamentos empregados no estudo para a obtenção dos dados respondem à necessidade da pesquisa<br>
                        
                        <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                    </fieldset>

                    <fieldset class="mb-5">
                        <legend><h2>Coleta de dados</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Método - Coleta de dados: A coleta dos dados foi conduzida em local e tempo adequados">A coleta dos dados foi conduzida em local e tempo adequados<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Coleta de dados: Os instrumentos de coleta (questionários, entrevistas etc.estão coerentes com a natureza da pesquisa)">Os instrumentos de coleta (questionários, entrevistas etc.estão coerentes com a natureza da pesquisa)<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Coleta de dados: Os Materiais: equipamentos e experimentos permitiram a coleta de dados requerida pelo estudo">Os Materiais: equipamentos e experimentos permitiram a coleta de dados requerida pelo estudo<br>
                        <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                    </fieldset>



                
                    <fieldset class="mb-5">
                        <legend><h2>Resultados</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Método - Resultados: Coerência dos resultados com o método utilizado">Coerência dos resultados com o método utilizado<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Resultados: Precisão dos dados coletados">Precisão dos dados coletados<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Resultados: Concisão dos dados coletados">Concisão dos dados coletados<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Resultados: Clareza dos dados coletados">Clareza dos dados coletados<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Resultados: Reprodutibilidade dos resultados obtidos">Reprodutibilidade dos resultados obtidos<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Resultados: Confiabilidade e fidedignidade dos dados obtidos">Confiabilidade e fidedignidade dos dados obtidos<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Resultados: A qualidade das figuras, gráficos, tabelas ou esquemas usados expressão os dados obtidos"> A qualidade das figuras, gráficos, tabelas ou esquemas usados expressão os dados obtidos<br>
                        
                        <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                    </fieldset>

                    <fieldset class="mb-5">
                        <legend><h2>Análise dos dados</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Análise: Profundidade da análise"> Profundidade da análise<br>
                        <input type="checkbox" id="" name="item[]" value="Análise: Coerência da análise com os dados coletados"> Coerência da análise com os dados coletados<br>
                        <input type="checkbox" id="" name="item[]" value="Análise: Coerência da analise com a fundamentação teorica">Coerência da analise com a fundamentação teorica<br>
                        <input type="checkbox" id="" name="item[]" value="Análise: A análise apresentada não mostra vieses científicos"> A análise apresentada não mostra vieses científicos<br>
                        <input type="checkbox" id="" name="item[]" value="Análise: A análise produzida está coerente com a Discriminação/definição das variáveis estudadas"> A análise produzida está coerente com a Discriminação/definição das variáveis estudadas<br>
                        <input type="checkbox" id="" name="item[]" value="Análise: A análise condiz com a Organização e tabulação dos dados"> A análise condiz com a Organização e tabulação dos dados<br>
                        <input type="checkbox" id="" name="item[]" value="Análise: A análise feita condiz com o Tratamento e testes estatísticos utilizados">A análise feita condiz com o Tratamento e testes estatísticos utilizados<br>
                        <input type="checkbox" id="" name="item[]" value="Análise: O(s) Programa(s) utilizados para tabulação e análise deram conta dos resultados obtidos">O(s) Programa(s) utilizados para tabulação e análise deram conta dos resultados obtidos <br>
                        <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                    </fieldset>
                    <br>
                </fieldset>

                <fieldset class="mb-5">
                        <legend><h2>Cronograma</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Método - Cronograma: O cronograma é viável no tempo disponível para a pesquisa">O cronograma é viável no tempo disponível para a pesquisa<br>
                        <input type="checkbox" id="" name="item[]" value="Método - Cronograma: A organização do cronograma é clara">A organização do cronograma é clara<br>
                        <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                
                </fieldset>

                <fieldset class="mb-5">
                    <legend><h2>Orçamento</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Orçamento: Adequação do Custeio"> Adequação do Custeio<br>
                        <input type="checkbox" id="" name="item[]" value="Orçamento: Adequação do Capital"> Adequação do Capital<br>
                        <input type="checkbox" id="" name="item[]" value="Orçamento: Relevância da contrapartida">Relevância da contrapartida<br>
                        <input type="checkbox" id="" name="item[]" value="Orçamento: Descrição dos materiais permanentes">Descrição dos materiais permanentes<br>
                        <input type="checkbox" id="" name="item[]" value="Orçamento: Adequação do material de consumo">Adequação do material de consumo<br>
                        <input type="checkbox" id="" name="item[]" value="Orçamento: Relevância/necessidade dos serviços de terceiros">Relevância/necessidade dos serviços de terceiros<br>
                        <input type="checkbox" id="" name="item[]" value="Orçamento: Solicitação dos recursos humanos">Solicitação dos recursos humanos<br>
                        <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                </fieldset>

                <fieldset class="mb-5">
                    <legend><h2>Discursão</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Discursão: Profundidade da discursão"> Profundidade da discursão<br>
                        <input type="checkbox" id="" name="item[]" value="Discursão: Coerência da discursão com os dados coletados"> Coerência da discursão com os dados coletados<br>
                        <input type="checkbox" id="" name="item[]" value="Discursão: Coerência da discursão com a fundamentação teorica">Coerência da discursão com a fundamentação teorica<br>
                        <p> Deseja adicionar mais algum item?</p>
                    <textarea name="item[]" id=""></textarea>
                </fieldset>    
                <fieldset class="mb-5">
                    <legend><h2>Conclusão</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Conclusão: Profundidade das conclusões"> Profundidade das conclusões<br>
                        <input type="checkbox" id="" name="item[]" value="Conclusão: Coerência das conclusões com os dados coletados"> Coerência das conclusões com os dados coletados<br>
                        <input type="checkbox" id="" name="item[]" value="Conclusão: Coerência das conclusões com a fundamentação teorica">Coerência das conclusões com a fundamentação teorica<br>
                        <p> Deseja adicionar mais algum item?</p>
                <textarea name="item[]" id=""></textarea>
                    </fieldset>
                
                <fieldset class="mb-5">
                    <legend><h2>Referências bibliográficas</h2></legend>
                        <input type="checkbox" id="" name="item[]" value="Referências bibliográficas: Relevância e atualidade das referências bibliográficas"> Relevância e atualidade das referências bibliográficas<br>
                        <input type="checkbox" id="" name="item[]" value="Referências bibliográficas: Conformidade das referências com as normas da ABNT"> Conformidade das referências com as normas da ABNT<br>
                        <p> Deseja adicionar mais algum item?</p>
                        <textarea name="item[]" id=""></textarea>
                </fieldset>

                <fieldset class="mb-5">
                    <legend><h2>Assinale quais dos itens abaixo se aplicam ao Projeto Acadêmico em avaliação: </h2></legend>
                        <input type="checkbox" id="" id="titulo" name="item[]" value="Apresenta título da Produção Acadêmica">
                        <label for="titulo">Apresenta título da Produção Acadêmica</label><br>

                        <input type="checkbox" id="" id="resumo" name="item[]" value="Apresenta resumo">
                        <label for="resumo">Apresenta resumo</label><br>

                        <input type="checkbox" id="" id="palavrasChaves" name="item[]" value="Apresenta palavras-chaves">
                        <label for="palavrasChaves">Apresenta palavras-chaves</label><br>

                        <input type="checkbox" id="" id="resumoEstrangeira" name="item[]" value="Apresenta resumo em língua estrangeira">
                        <label for="resumoEstrangeira">Apresenta resumo em língua estrangeira</label><br>

                        <input type="checkbox" id="" id="palavrasChavesEstrangeira" name="item[]" value="Apresenta palavras-chaves em língua estrangeira">
                        <label for="palavrasChavesEstrangeira">Apresenta palavras-chaves em língua estrangeira</label><br>

                        <input type="checkbox" id="" id="introducao" name="item[]" value="Apresenta Introdução e contextualização">
                        <label for="introducao">Apresenta Introdução e contextualização</label><br>

                        <input type="checkbox" id="" id="objetivos" name="item[]" value="Apresenta objetivos e justificativa">
                        <label for="objetivos">Apresenta objetivos e justificativa</label><br>

                        <input type="checkbox" id="" id="estadoArte" name="item[]" value="Apresenta estado da arte">
                        <label for="estadoArte">Apresenta estado da arte</label><br>

                        <input type="checkbox" id="" id="estrutura" name="item[]" value="Apresenta estrutura científico-metodológica">
                        <label for="estrutura">Apresenta estrutura científico-metodológica</label><br>

                        <input type="checkbox" id="" id="analise" name="item[]" value="Apresenta análise, considerações ou conclusões">
                        <label for="analise">Apresenta análise, considerações ou conclusões</label><br>

                        <input type="checkbox" id="" id="referencias" name="item[]" value="Apresenta referências bibliográficas">
                        <label for="referencias">Apresenta referências bibliográficas</label><br>

                        
                        <input type="checkbox" id="" id="aprovacaoComite" name="item[]" value="Apresenta Aprovação do Comitê de Ética em Pesquisa">
                        <label for="aprovacaoComite">Apresenta Aprovação do Comitê de Ética em Pesquisa</label><br>

                        <p> Deseja adicionar mais algum item?</p>
                        <textarea name="item[]" id=""></textarea>

                    </fieldset>





                <button type="submit" class="tooltip" aria-label="Salvar e Avançar" title="Salva e finaliza a edição deste Instrumento de Avaliação">
                Salvar e Avançar
                </button>

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
<?php include_once('includes/footer.php') ?>
