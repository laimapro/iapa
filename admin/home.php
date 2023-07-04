<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
</head>
<body>

<h1>Usuários para aprovação</h1>
<?php
include_once('../conexao.mysqli.php');
include('verifica.php');

// Consulta SQL para selecionar os usuários com aprovação igual a 0
$sql = "SELECT * FROM usuarios WHERE aprovacao = 0  ORDER BY id DESC";
$result = $mysqli->query($sql);


// Verificando se há resultados
if ($result->num_rows > 0) {
    // Exibindo a tabela
    echo "<table>";
    echo "<tr><th>Nome</th><th>Sobrenome</th><th>Email</th><th>Instituição</th><th>Curso</th><th>Pós-Graduação</th><th>Função</th><th>Aprovar</th><th>Rejeitar</th><th>Alterar informação</th></tr>";
    
    // Loop através dos resultados
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        
        // Verificando se há nome social
        $nomeExibicao = !empty($row["nomesocial"]) ? $row["nomesocial"] : $row["nome"];
        echo "<td>" . $nomeExibicao . "</td>";
        echo"<td>". $row["sobrenome"]."</td>";
        
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["instituicao"] . "</td>";
        echo "<td>" . $row["curso"] . "</td>";
        echo "<td>" . $row["programaposgraduacao"] . "</td>";
       
        // Traduzindo a função do usuário
        $funcao = "";
        switch ($row["funcao"]) {
            case 1:
                $funcao = "Editor";
                break;
            case 2:
                $funcao = "Avaliador";
                break;
            case 3:
                $funcao = "Gerente";
                break;
            default:
                $funcao = "Função desconhecida";
                break;
        }
        
        echo "<td>" . $funcao . "</td>";
        echo "<td><a href='aprovacao.php?id=".$row["id"]."'>Aprovar</a></td>";
        echo "<td><a href='rejeitado.php?id=".$row["id"]."'>Rejeitar</a></td>";
        echo "<td><a href='alterar.php?id=".$row["id"]."'>Alterar informação</a></td>";
        echo "</tr>";
    }
    
    echo "</table>";

    echo "<br>";
} else {
    echo "Nenhum usuário encontrado.";
}

$mysqli->close();
?>
<a href="sair.php">Sair</a>
</body>
</html>
