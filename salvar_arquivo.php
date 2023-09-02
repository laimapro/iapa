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

        $aleatorio = rand(1, 99999);

        $categorias = $_POST['categorias'];

        $nome_arquivo = $categorias.'_'.$aleatorio;
        //echo $nome_arquivo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifique se os itens foram enviados através do formulário
            if (isset($_POST['item'])) {
                // Obtenha os itens selecionados
                $itensSelecionados = $_POST['item'];

                // Remova os itens vazios do array
                $itensSelecionados = array_filter($itensSelecionados);

                // Verifique se $itensSelecionados é um array
                if (!is_array($itensSelecionados)) {
                    $itensSelecionados = array($itensSelecionados);
                }

                // Crie um array para armazenar os dados selecionados
                $dadosSelecionados = array();

                // Percorra os itens selecionados
                foreach ($itensSelecionados as $item) {
                    // Verifique se o item contém o caractere ;
                    if (strpos($item, ';') !== false) {
                        // Divida o item em um array usando o caractere ;
                        $subItens = explode(';', $item);

                        // Adicione cada subitem ao array de dados selecionados
                        foreach ($subItens as $subItem) {
                            $dadosSelecionados[] = $subItem;
                        }
                    } else {
                        // Adicione o item ao array de dados selecionados
                        $dadosSelecionados[] = $item;
                    }
                }

                // Converta o array para formato JSON
                $jsonDadosSelecionados = json_encode($dadosSelecionados);

                // Defina o caminho e nome do arquivo JSON
                $caminhoArquivo = 'IAPA.CRIADOS/'.$nome_arquivo.'.json';

                // Salve o JSON no arquivo
                file_put_contents($caminhoArquivo, $jsonDadosSelecionados);

                // Verifique se o arquivo foi salvo com sucesso
                if (file_exists($caminhoArquivo)) {
                    include_once('includes/head.php');
                    echo "<body class='bg-body-secondary'><div class='container px-4 py-5'><div class='p-5 rounded-3 bg-white border shadow-lg'><div class='pb-5 text-center'><a href='index.php' class='link-body-emphasis logo text-decoration-none'>";
                    include_once('includes/logo.php');
                    echo "<?xml version='1.0' encoding='utf-8'?><svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' style='margin: auto; background: none; display: block; shape-rendering: auto;' width='200px' height='200px' viewBox='0 0 100 100' preserveAspectRatio='xMidYMid'><circle cx='50' cy='50' r='0' fill='none' stroke='#85a2b6' stroke-width='2'>  <animate attributeName='r' repeatCount='indefinite' dur='1s' values='0;40' keyTimes='0;1' keySplines='0 0.2 0.8 1' calcMode='spline' begin='0s'></animate><animate attributeName='opacity' repeatCount='indefinite' dur='1s' values='1;0' keyTimes='0;1' keySplines='0.2 0 0.8 1' calcMode='spline' begin='0s'></animate></circle><circle cx='50' cy='50' r='0' fill='none' stroke='#bbcedd' stroke-width='2'>  <animate attributeName='r' repeatCount='indefinite' dur='1s' values='0;40' keyTimes='0;1' keySplines='0 0.2 0.8 1' calcMode='spline' begin='-0.5s'></animate>  <animate attributeName='opacity' repeatCount='indefinite' dur='1s' values='1;0' keyTimes='0;1' keySplines='0.2 0 0.8 1' calcMode='spline' begin='-0.5s'></animate></circle></svg>";
                    echo "<p>O arquivo foi salvo com sucesso na pasta IAPA.CRIADOS.</p>";
                    echo '<script>
                      setTimeout(function(){
                        window.location.href = "home.php";
                      }, 2000); // Tempo em milissegundos (2 segundos)
                    </script>';
                    $stmt = $mysqli->prepare("INSERT INTO tipo_producao (instituicao, curso, nome, categoria, arquivo, producoes, programaposgraduacao) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssss", $instituicao, $curso, $nomeUsuario, $categorias, $nome_arquivo, $jsonDadosSelecionados, $programaposgraduacao);

                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        echo "<p>Dados inseridos com sucesso na tabela tipo_producao.</p>";
                    } else {
                        echo "<p>Erro ao inserir dados na tabela tipo_producao.</p>";
                    }
                    echo "</div></div></div>";

                    // Fecha a declaração
                    $stmt->close();
                } else {
                    echo "<p>Erro ao salvar os dados em um arquivo JSON.</p>";
                }
            } else {
                echo "<p>Nenhum item selecionado.</p>";
            }
        } else {
            echo "Erro ao salvar os dados em um arquivo JSON.";
        }

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