<?php
// Carregar o Composer e DOMPDF
require 'vendor/autoload.php';


use Dompdf\Dompdf;
// Inicie o buffer de saída
ob_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php $titulo = $_POST["tituloproducaoacademica"];
          echo $titulo; ?> | IAPA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js" integrity="sha512-w3u9q/DeneCSwUDjhiMNibTRh/1i/gScBVp2imNVAMCt6cUHIw6xzhzcPFIaL3Q1EbI2l+nu17q2aLJJLo4ZYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="css/main.css">
  <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
</head>

<body>
  <style>
    .title-producao {
      font-size: 22px;
    }

    .title-avaliacao-secao {
      font-size: 18px;
      margin-top: 3rem;
    }

    .iapa-info {
      color: #777;
      font-size: .825rem;
      text-align: center !important;
      margin-bottom: .5rem;
    }

    a[href^=http]:after {
      content: " <" attr(href) ">";
    }



    ol li:nth-child(even) {
      background-color: #f2f2f2;
    }

    .pdf-grade {
      text-align: right;

    }

    .pdf-grade-final {}
  </style>
  <?php

  // Defina os estilos
  $styles = "
<style>
*{margin: 2pt;padding: 0;}
body {font-size: 14px;font-family: Arial, sans-serif !important;}
.iapa-info {color: #777;font-size: .825rem;margin-bottom: .5rem;text-align: center;}
table {width: 100%;}
.iapa-header {margin-bottom: .5rem;border-collapse: collapse;}
.iapa-header-subtable {margin: 0.5rem 0 .5rem;font-size: .85rem;color: #333;}
.iapa-header-logo {padding-right: .5rem;}
.iapa-title-article {padding-bottom: 0.5rem;font-size: 22px;text-transform: uppercase;font-weight: border;border-bottom: 1px solid #ddd;}
.content-intro p {margin-bottom: .5rem;}
.section-grade-title {font-size: 18px;margin: 2rem 0 .5rem;font-weight: bold;font-family: Arial, sans-serif !important}
.section-grade-list tr td{padding: 0.25rem;}
.section-grade-list tr:nth-child(even) {background-color: #f2f2f2;}
.section-grade-final {border-radius: 0.5rem;padding: 1rem;border: 1px solid #ddd;border-radius: .825rem;}
.section-grade-final strong {display: block;width: 100%;font-size: 2rem;}
.alert{border-radius: 0.5rem;padding: 1rem;}
.alert svg {margin-right: 0.5rem;width: 32px;height: 32px;}
.alert strong{display: block;width: 100%;font-size: 2rem;}
.alert-sucesso{color: #0a3622;background-color: #d1e7dd;border-color: #a3cfbb;}
.alert-restricao{color: #664d03;background-color: #fff3cd;border-color: #ffe69c;}
.alert-reprovado{color: #58151c;background-color: #f8d7da;border-color: #f1aeb5;}
</style>
";

  // Aqui estão seus echos e prints
  echo $styles;

  $texto = $_POST["documento"];

// Separar o texto usando '/' como delimitador
$partes = explode('/', $texto);

// Pegar a última parte (o nome do arquivo) e remover a extensão ".json"
$nome_arquivo = pathinfo(end($partes), PATHINFO_FILENAME);

// Exibir o resultado
//echo $nome_arquivo;






  include('conexao.mysqli.php');


  // Preparar a consulta SQL
$consulta_sql = "SELECT categoria FROM tipo_producao WHERE arquivo = '$nome_arquivo'";

// Executar a consulta e obter o resultado
$resultado = mysqli_query($mysqli, $consulta_sql);

// Verificar se a consulta foi bem-sucedida
if ($resultado) {
    // Extrair o texto da categoria
    $row = mysqli_fetch_assoc($resultado);
    $categoria = $row['categoria'];

} else {
    
    echo "Erro ao executar a consulta: " . mysqli_error($sua_conexao);
}


  session_start();

  if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id'];

    $sql = "SELECT * FROM usuarios WHERE id = $idUsuario";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $nomeUsuario = $row["nome"];
      $sobrenomeUsuario = $row["sobrenome"];
      $pronomeTratamento = $row["pronomeTratamento"];
      $pronomeReferencia = $row["pronomeReferencia"];
      $instituicao = $row["instituicao"];
      $curso = $row["curso"];
      $programaposgraduacao = $row["programaposgraduacao"];
      $titulo = $_POST["tituloproducaoacademica"];


      // Verifica se a chave "regiao" existe no array $row
      if (isset($row["regiao"])) {
        $regiao = $row["regiao"];
      } else {
        $regiao = ""; // Defina um valor padrão se a chave não existir
      }

      // Fusos horários
      $userTimezone = $regiao; // Alterado para usar a variável $regiao

      if ($userTimezone == "Acre") {
        date_default_timezone_set('America/Rio_Branco');
      } elseif ($userTimezone == "Amazonas") {
        date_default_timezone_set('America/Manaus');
      } elseif ($userTimezone == "Fernando de Noronha") {
        date_default_timezone_set('America/Noronha');
      } elseif ($userTimezone == "Mato Grosso do Sul") {
        date_default_timezone_set('America/Campo_Grande');
      } else {
        date_default_timezone_set('America/Sao_Paulo');
      }

      $dataHoraFormatadaRegiao = date('d/m/Y H:i:s');



      echo '<h1 class="iapa-title-article">' . $titulo . '</h1>';
      echo '<table class="iapa-header-subtable">';
      echo '<tr>';
      echo '<td width="33.5%" class="col instituicao">' . $instituicao . '</td>';
      echo '<td width="33.5%" class="col curso">' . $curso . '</td>';
      echo '<td width="33.5%" class="col centro">' . $programaposgraduacao . '</td>';
      echo '</tr>';
      echo '</table>';
      echo '<section class="content">';
      echo '<div class="content-intro">';
      echo '<p class="title-avaliacao-secao"x>Tendo lido e avaliado a produção acadêmica, de acordo com os quesitos formais pré-estabelecidos, apresento meu parecer nestes termos, o trabalho avaliado.</p>';
      echo '</div>';


      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo '<table class="section-grade-list" style="width: 100%; border-collapse:collapse">';
        if (isset($_POST["apresenta"])) {
          $numeracao = 1;

          foreach ($_POST["apresenta"] as $checkbox) {
            echo '<tr>';
            echo '<td width="85%" class="col ms-2 pdf-item flex-fill">' . $numeracao . ". " . $checkbox . "</td>";
            echo '</tr>';
            $numeracao++;

            if (isset($_POST[$checkbox])) {
              echo $_POST[$checkbox];
            } else {
              // nothing
            }
          }
        } else {
          echo "";
        }
        echo '</table>';
      }

      echo "<p class='title-avaliacao-secao'>Considerando os aspectos formais exigidos para a aprovação deste trabalho, julguei os quesitos que abaixo identifico e a eles aferi as seguintes notas:</p><br>";
      echo '<table class="section-grade-list" style="width: 100%; border-collapse:collapse">';
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["label"]) && isset($_POST["nota"])) {
          $labels = $_POST["label"]; // Armazena os textos das labels em uma variável
          $valores = $_POST["nota"]; // Armazena os valores das notas em uma variável

          $soma = 0;
          $cont = 0;

          foreach ($valores as $index => $valor) {
            $valorInt = intval($valor); // Converte o valor para inteiro

           // Verifica se o valor é diferente de zero
              echo '<tr>';
              echo '<td width="85%" class="col ms-2 pdf-item flex-fill">' . $labels[$index] . '</td>';
              echo "<td  width='15%' class='col-1 pdf-grade'>Nota: <strong>" . $valorInt . '</strong></td>';
              echo "</tr>";
              $soma += $valorInt; // Acumula os valores para calcular a média
              $cont++; // Incrementa o contador de valores
            
          }
          echo '</table>';
          if ($cont > 0) {
            $media = $soma / $cont;
            $mediaFormatada = number_format($media, 2); // Formata a média com duas casas decimais
            echo '<table>';
            echo '<tr>';
            echo '<td style="width: 35%"><h2 class="section-grade-title" style="font-family:Arial, sans-serif">Nota Final</h2>';
            echo '<div class="section-grade-final">';
            echo '<span>Média:</span>';
            echo '<strong>' . $mediaFormatada . '</strong>';
            echo '</div></td>';
            echo '<td style="width: 2.5%"></td>';
            echo '<td style="width: 62.5%">';

            echo '<h2 class="section-grade-title" style="font-family:Arial, sans-serif">Situação da produção acadêmica</h2>';

            if ($mediaFormatada < 5.5) {
              echo '<div class="alert alert-reprovado">'.$categoria.'';
              echo '<strong>';
              echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/></svg>';
              echo 'Reprovado';
              echo '</strong>';
              echo '</div>';
            } elseif ($mediaFormatada >= 5.5 && $mediaFormatada < 7) {
              echo '<div class="alert alert-restricao">'.$categoria.'';
              echo '<strong>';
              echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>';
              echo 'Aprovado com restrições';
              echo 'Veja observações do avaliador(a).';
              echo '</strong>';
              echo '</div>';
            } elseif ($mediaFormatada >= 7) {
              echo '<div class="alert alert-sucesso">'.$categoria.'';
              echo '<strong>';
              echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trophy-fill" viewBox="0 0 16 16"><path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935z"/></svg>';
              echo 'Aprovado';
              echo '</strong>';
              echo '</div>';
            }
            
          } else {
            echo "Nenhum valor selecionado ou todos os valores são zero.";
          }
          echo '</td>';
          echo '</tr>';
          echo '</table>';
          echo "<div class='iapa-info'>
  Parecer exarado em " . $dataHoraFormatadaRegiao . " <br> Documento produzido com o IAPA - Instrumento de Avaliação de
  Produção Acadêmica
  </div>";
        } else {
          echo "Nenhum valor selecionado.";
        }
      }

      $observacaoValor = $_POST["observacaoValor"];



      if ($observacaoValor) {
        echo '<div id="observacao" aria-describedby="observacao-desc">Observações do avaliador(a): ' . $observacaoValor . '</div>';
      }



      // Adicione o HTML ao mPDF

      // Nome do arquivo
      $aleatorio = rand(0, 9999);
      $nomeArquivo = $titulo . '_' . $aleatorio . '.pdf';




      $nomeC = "$nomeUsuario $sobrenomeUsuario";

      $sql1 = "INSERT INTO avaliado (avaliador, instituicao, curso, arquivo, tituloproducaoacademica, nota, programaposgraduacao, idUsuario, dataAvaliado)
    VALUES ('$nomeC', '$instituicao', '$curso', '$nomeArquivo', '$titulo', '$mediaFormatada','$programaposgraduacao','$idUsuario', NOW())";

      if ($mysqli->query($sql1) === TRUE) {
        echo '';
      }

      $mysqli->close();
    } else {
      echo "Nenhum usuário encontrado.";
    }
  } else {
    header("Location: index.php");
    exit();
  }

  $htmlContent = ob_get_clean();

  // Crie uma nova instância de Dompdf
  $dompdf = new Dompdf();

  // Carregue o conteúdo HTML
  $dompdf->loadHtml($htmlContent);

  // Defina o tamanho e a orientação da página
  $dompdf->setPaper('A4', 'portrait');

  // Renderiza o PDF
  $dompdf->render();

  $pdfOutput = $dompdf->output();
  $pdfFilePath = 'PRODUCOES.AVALIADAS/' . $nomeArquivo;
  file_put_contents($pdfFilePath, $pdfOutput);

  include_once('includes/head.php');
  echo '<div class="container px-4 py-5"><div class="p-5 rounded-3 bg-white border shadow-lg text-center">';
  include_once('includes/logo.php');
  echo '<p class="fs-4">Parecer salvo com sucesso!</p>';
  echo '<div class="justify-content-center d-flex align-items-center flex-wrap flex-md-row flex-column mb-0 list-unstyled">';
  echo '<a class="m-3 btn btn-outline-secondary" accesskey="4" href="' . $pdfFilePath . '" title="Baixa o parecer e o salva em sua pasta de download"download> <i class="bi bi-download me-3"></i> Download do parecer </a> </li>';
  echo '<a class="m-3 btn btn-outline-info" accesskey="3" href="avaliacao.php" title="Retorna a página de produção acadêmica"> <i class="bi bi-arrow-left-right me-3"></i> Avaliar outra produção acadêmica </a></li>';
  echo '<a class="m-3 btn btn-outline-success" accesskey="2" href="upload.php" title="Leva à página em que se pode visualizar seus pareceres "> <i class="bi bi-journal-text me-3"></i> Meus pareceres </a></li>';
  echo '</div>';
  echo '<div class="btn-action"><a accesskey="1" href="home.php" title="Volta a página inicial do IAPA"><i class="bi bi-arrow-left me-1"></i>Voltar para página inicial</a></li></div>';
  echo '</div>';
  echo '</div>';
  include_once('includes/footer.php');

  ?>



</body>

</html>