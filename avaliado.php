<?php
include('conexao.mysqli.php');
require 'vendor/autoload.php';
use Dompdf\Dompdf;

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
    $html = '<h1>'.$instituicao.', '.$curso.', '.$programaposgraduacao.'<br> <hr> Título da produção acadêmica: '. $titulo.'</h1><br><h3>Tendo lido e avaliado a produção acadêmica, de acordo com os quesitos formais pré-estabelecidos, apresento meu parecer nestes termos: O trabalho avaliado</h3>';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST["item"])) {
        $numeracao = 1;

        foreach ($_POST["item"] as $checkbox) {
          $html .= "<h2>".$numeracao.". ".$checkbox."</h2>";
          $numeracao++;

          if (isset($_POST[$checkbox])) {
            $html .= $_POST[$checkbox];
          } else {
            // nothing
          }

          $html .= "<br>";
        }
      } else {
        $html .= "";
      }
    }

    $html .= "<h3>Considerando os aspectos formais exigidos para a aprovação deste trabalho, julguei os quesitos que abaixo identifico e a eles aferi as seguintes notas:</h3>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST["label"]) && isset($_POST["nota"])) {
        $labels = $_POST["label"]; // Armazena os textos das labels em uma variável
        $valores = $_POST["nota"]; // Armazena os valores das notas em uma variável

        $soma = 0;
        $cont = 0;

        foreach ($valores as $index => $valor) {
          $valorInt = intval($valor); // Converte o valor para inteiro

          if ($valorInt !== 0) { // Verifica se o valor é diferente de zero
            $html .= '<h2 aria-label="Avaliação: '.$labels[$index].'">'.$labels[$index].'</h2>';
            $html .= "Nota: " . $valorInt . "<br>";
            $soma += $valorInt; // Acumula os valores para calcular a média
            $cont++; // Incrementa o contador de valores
          }
        }

        if ($cont > 0) {
          $media = $soma / $cont;
          $mediaFormatada = number_format($media, 2); // Formata a média com duas casas decimais
          $html .= "Média: " . $mediaFormatada . "<br>"; // Exibe a média formatada no documento PDF

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

          if ($mediaFormatada < 5.5) {
            $html .= "<p>Produção reprovada. Parecer exarado em " . $dataHoraFormatadaRegiao . ".</p>";
        } elseif ($mediaFormatada >= 5.5 && $mediaFormatada < 7) {
            $html .= "<p>Produção aprovada com restrições. Parecer exarado em " . $dataHoraFormatadaRegiao . ": veja observações do avaliador(a).</p>";
        } elseif ($mediaFormatada >= 7) {
            $html .= "<p>Trabalho aprovado. Parecer exarado em " . $dataHoraFormatadaRegiao . ".</p>";
        }
        } else {
          $html .= "Nenhum valor selecionado ou todos os valores são zero.";
        }
      } else {
        $html .= "Nenhum valor selecionado.";
      }
    }

    $observacaoValor = $_POST["observacaoValor"];

    if ($observacaoValor) {
      $html .= '<div id="observacao" aria-describedby="observacao-desc">Observações do avaliador(a): '.$observacaoValor.'</div>';
    }

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // Estilos CSS para tornar o PDF mais visualmente agradável e acessível
    $css = '
      body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.5;
      }
      h1, h2, h3 {
        color: #333;
        margin-bottom: 10px;
      }
      p {
        margin: 0;
      }
      #observacao {
        margin-top: 20px;
        padding: 10px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 4px;
      }
      img {
        max-width: 200px;
        margin-top: 20px;
      }
    ';
    $dompdf->getOptions()->setIsRemoteEnabled(true); // Permite o carregamento de imagens remotas
    $dompdf->setBasePath(__DIR__); // Define o diretório base para o carregamento de imagens locais
    $dompdf->loadHtml('<style>' . $css . '</style>' . $html); // Aplica os estilos CSS ao HTML
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Caminho completo da imagem
    $imagem = 'img/cropped-logo.png';

    // Carrega a imagem
    $image = file_get_contents($imagem);

    // Converte a imagem para base64
    $base64 = base64_encode($image);

    // Insere a imagem no HTML
    $html .= '<img src="data:image/png;base64,' . $base64 . '" aria-label="Logo" />';

    // Caminho da pasta onde deseja salvar o PDF
    $pastaDestino = 'PRODUCOES.AVALIADAS/';

    $aleatorio = rand(0, 9999);

    // Nome do arquivo
    $nomeArquivo = $titulo . '_' . $aleatorio . '.pdf';

    // Caminho completo do arquivo
    $caminhoCompleto = $pastaDestino . $nomeArquivo;

    // Salva o conteúdo do PDF no arquivo
    file_put_contents($caminhoCompleto, $dompdf->output());

    // Exibe uma mensagem informando que o arquivo foi salvo com sucesso
    echo "Parecer salvo com sucesso! <br>";
    echo '<a href="' . $caminhoCompleto . '" download><button title="Baixa o parecer e o salva em sua pasta de download">Visualizar parecer </button></a> <br>'; // Adiciona botão para baixar o PDF
    echo '<a href="avaliacao.php"><button title="Retorna a página de produção acadêmica">Avaliar outro projeto </button></a><br>';
    echo '<a href="home.php"><button title="Volta a página inicial do IAPA">Voltar para página inicial</button></a><br>';

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
?>
