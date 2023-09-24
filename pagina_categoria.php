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
        $nomesocial = $row["nomesocial"];
        $funcao = $row["funcao"];
        $programaposgraduacao = $row["programaposgraduacao"];
?>


        <div class="container col-xl-10 col-xxl-8 px-4 py-5">
            <div class="row p-5 align-items-start rounded-3 bg-white  border shadow-lg">
                <div class="col-12 col-md-4 text-center text-lg-start">
                    <?php include_once('includes/logo.php') ?>
                    <div class="menu-nav">
                    </div>
                    <h4>Compondo Produções acadêmicas</h4><br>
                    <div id="toc"></div>
                    <li class="px-0 list-group-item"><a class="text-decoration-none d-block" href="IAPA_em_construcao.php" accesskey="4" title="Alt + 4: Permite editar um IAPA em construção">Editar um Instrumento de Avaliação</a></li>
                    
                    

                </div>
                <div class="col-12 col-md-8">

                    <p><span id="saudacao"></span>, <?php echo $pronomeTratamento;
                                                    echo " ";
                                                    if ($nomesocial != null) {
                                                        echo $nomesocial;
                                                    } else {
                                                        echo $nomeUsuario;
                                                        echo " ";
                                                        echo $sobrenomeUsuario;
                                                    }
                                                    ?>. Agora são <span id="horario"></span></p>


                    <!-- <script>
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
                        </script> -->


                    <p>Para iniciarmos a construção de um instrumento de avaliação, escolha uma das produções acadêmicas, pressione o botão Continuar e eu lhe levarei para o próximo passo:</p>


                    <form action="pagina_itens.php" method="get">
                        <label for="categorias" aria-label="Escolha o tipo de produção acadêmica" role="tooltip" class="anchor" >Criar um instrumento de avaliação:</label>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="categorias" name="categorias">
                                <option value="PreProjeto">Pré-projeto</option>
                                <option value="Projeto">Projeto</option>
                                <option value="TCC">TCC</option>
                                <option value="Monografia">Monografia</option>
                                <option value="Dissertacao">Dissertação</option>
                                <option value="Tese">Tese</option>
                                <option value="ArtigoCientifico">Artigo Científico</option>
                                <option value="ArtigoOpiniao">Artigo de Opinião</option>
                                <option value="AudioDescricao">Áudio-descrição</option>
                                <option value="Comunicacao">Comunicação</option>
                                <option value="Ensaio">Ensaio</option>
                                <option value="Entrevista">Entrevista</option>
                                <option value="Resenha">Resenha</option>
                                <option value="Resumo">Resumo</option>
                                <option value="ResumoEstendido">Resumo estendido</option>
                                <option value="Relato de caso">Relato de caso</option>
                                <option value="Série de casos">Série de casos</option>
                                <option value="RelatoExperiencia">Relato de Experiência</option>
                                <option value="Relatorio">Relatório</option>
                                <option value="Traducao">Tradução</option>
                                <?php
                                // Consulta na tabela categoria para obter os campos
                                $sql = "SELECT * FROM categoria WHERE instituicao = '$instituicao' AND curso = '$curso' AND posgraduacao = '$programaposgraduacao'";

                                $result = $mysqli->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['categoria'] . '">' . $row['categoria'] . '</option>';
                                    }
                                }

                                ?>
                            </select>
                           
                        </div>

                        <div class="text-end my-3">


                            <input type="submit" class="btn btn-primary" Value="Inicia a Construção do IAPA Escolhido" title="Segue para a página de critérios de avaliação" accesskey="2" aria-label="continuar" role="button">
                        </div>




                    </form>
                    <div class="d-flex justify-content-between mt-5 px-0">
                        <button class="btn btn-link " onclick="window.location.href='home.php'" accesskey="1" title="Volta para a página inicial do IAPA">
                            <i class="bi bi-arrow-left me-1"></i>Voltar
                        </button>

                        <?php if ($funcao == 0 || $funcao == 2 || $funcao == 3) { ?>
                            <button onclick="window.location.href='cria_categoria.php'" class="btn px-0 btn-link" accesskey="3">
                                Não encontrou a categoria pretendida, Crie-a aqui
                            </button>
                        <?php } ?>
                    </div>

                    <script>
                        document.getElementById("categorias").addEventListener("change", function() {
                            document.getElementById("categoriasHidden").value = this.value;
                        });
                    </script>

            <?php
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