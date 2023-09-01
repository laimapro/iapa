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
      margin-bottom: 1rem;
    }

    a[href^=http]:after {
      content: " <" attr(href) ">";
    }

    .pdf-grade,
    .pdf-item {
      padding: 0 .5rem;
    }

    ol li:nth-child(even) {
      background-color: #f2f2f2;
    }

    .pdf-grade {
      text-align: center;
    }

    .pdf-grade-final {}
  </style>
  <?php

  // Defina os estilos
  $styles = "
<style>
  *{font-family:sans-serif}  
  .iapa-info {
    color: #777;
    font-size: .825rem;
    text-align: center!important;
    margin-bottom: 1rem;
  }
.header-print{
  display: flex;
  align-items:flex-start;
  width: 100%;
  margin-bottom:1rem;
  
}
</style>
";

  // Aqui estão seus echos e prints
  echo $styles;


  include('conexao.mysqli.php');

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

      echo "<div class='iapa-info mb-3 text-center'>
  Parecer exarado em " . $dataHoraFormatadaRegiao . " <br> Documento gerado com ajuda do IAPA - Instrumento de Avaliação de
  Produção Acadêmica
  </div>";

      echo ' <div class="container-fluid py-3">
          <header class="header-print">
            <img src="img/icon-158x158.png" width="75px" class="icone-pdf me-3">
            <div class=" flex-fill"><h1 class="m-0 title-producao text-uppercase fw-bold border-bottom">' . $titulo . '</h1>
            <span class="mt-1 fs-6 row text-secondary">
              <span class="col instituicao">' . $instituicao . '</span>
              <span class="col curso">' . $curso . '</span>
              <span class="col centro">' . $programaposgraduacao . '</span>
            </span>
        <h2 class="title-avaliacao-secao">Tendo lido e avaliado a produção acadêmica, de acordo com os quesitos formais pré-estabelecidos, apresento meu parecer nestes termos: O trabalho avaliado</h2> ';

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["apresenta"])) {
          $numeracao = 1;

          foreach ($_POST["apresenta"] as $checkbox) {
            echo "<li class='px-0 list-group-item d-flex justify-content-between align-items-start'>" . $numeracao . ". " . $checkbox . "</li>";
            $numeracao++;

            if (isset($_POST[$checkbox])) {
              echo $_POST[$checkbox];
            } else {
              // nothing
            }

            echo "<br>";
          }
        } else {
          echo "";
        }
      }

      echo "<h2 class='title-avaliacao-secao'>Considerando os aspectos formais exigidos para a aprovação deste trabalho, julguei os quesitos que abaixo identifico e a eles aferi as seguintes notas:</h2>";
      echo '<ol class="list-group list-group-flush list-group-numbered">';
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["label"]) && isset($_POST["nota"])) {
          $labels = $_POST["label"]; // Armazena os textos das labels em uma variável
          $valores = $_POST["nota"]; // Armazena os valores das notas em uma variável

          $soma = 0;
          $cont = 0;

          foreach ($valores as $index => $valor) {
            $valorInt = intval($valor); // Converte o valor para inteiro

            if ($valorInt !== 0) { // Verifica se o valor é diferente de zero
              echo '<li  class="px-0 list-group-item d-flex justify-content-between align-items-start"><div class="col ms-2 pdf-item flex-fill">' . $labels[$index] . '</div>';
              echo "<div class='col-1 pdf-grade'>Nota: " . $valorInt . "</div></li>";
              $soma += $valorInt; // Acumula os valores para calcular a média
              $cont++; // Incrementa o contador de valores
            }
          }
          echo '</ol>';
          if ($cont > 0) {
            $media = $soma / $cont;
            $mediaFormatada = number_format($media, 2); // Formata a média com duas casas decimais
            echo "<h2 class='title-avaliacao-secao'>Nota Final</h2>
          <div class='pdf-grade-final px-0 align-items-center d-flex justify-content-between align-items-start'>
              <div class='col pdf-item text-end'> Média da avaliação da produção acadêmica</div>
              <div class='col-1 fs-2 border rounded fw-bold pdf-grade'>" . $mediaFormatada . "</div>
          </div>";

            echo '<h2 class="title-avaliacao-secao">Situação da produção acadêmica</h2>';

            if ($mediaFormatada < 5.5) {
              echo '<div class="alert alert-danger">Produção Acadêmica<strong class="fs-2 d-block"><i class="bi bi-x-circle-fill me-2"></i>Reprovada</strong></div>';
            } elseif ($mediaFormatada >= 5.5 && $mediaFormatada < 7) {
              echo '<div class="alert alert-warning">Produção Acadêmica<strong class="fs-2 d-block"><i class="bi bi-exclamation-triangle-fill me-2"></i>Aprovada com restrições</strong>Veja observações do avaliador(a).</div>';
            } elseif ($mediaFormatada >= 7) {
              echo '<div class="alert alert-success">Produção Acadêmica<strong class="fs-2 d-block"><i class="bi bi-trophy-fill me-2"></i>Aprovada</strong></div>';
            }
          } else {
            echo "Nenhum valor selecionado ou todos os valores são zero.";
          }
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