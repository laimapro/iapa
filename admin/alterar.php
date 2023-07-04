<?php
include_once('../conexao.mysqli.php');
include('verifica.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obter os novos dados do formulário
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $nomesocial = $_POST['nomesocial'];
        $email = $_POST['email'];
        $instituicao = $_POST['instituicao'];
        $curso = $_POST['curso'];
        $programaposgraduacao = $_POST['programaposgraduacao'];
        $funcao = $_POST['funcao'];

        // Atualizar os dados do usuário no banco de dados
        $sql = "UPDATE usuarios SET nome = '$nome', sobrenome = '$sobrenome', nomesocial = '$nomesocial', email = '$email', instituicao = '$instituicao', curso = '$curso', programaposgraduacao = '$programaposgraduacao', funcao = $funcao WHERE id = $id";
        $result = $mysqli->query($sql);

        if ($result) {
            echo "Dados do usuário atualizados com sucesso.";
        } else {
            echo "Ocorreu um erro ao atualizar os dados do usuário.";
        }
    }

    // Buscar os dados atuais do usuário
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $sobrenome = $row['sobrenome'];
        $nomesocial = $row['nomesocial'];
        $email = $row['email'];
        $instituicao = $row['instituicao'];
        $curso = $row['curso'];
        $programaposgraduacao = $row['programaposgraduacao'];
        $funcao = $row['funcao'];

        // Exibir o formulário para editar os dados
        echo "<h2>Editar usuário</h2>";
        echo "<form method='post'>";
        echo "Nome: <input type='text' name='nome' title='Nome' value='$nome'><br>";
        echo "Sobrenome: <input type='text' name='sobrenome' title='Sobrenome' value='$sobrenome'><br>";
        echo "Nome Social: <input type='text' name='nomesocial' title='Nome Social' value='$nomesocial'><br>";
        echo "Email: <input type='email' name='email' title='E-mail' value='$email'><br>";
        echo "Instituição: <input type='text' name='instituicao' title='Instituição' value='$instituicao'><br>";
        echo "Curso: <input type='text' name='curso' title='curso' value='$curso'><br>";
        echo "Pós-Graduação: <input type='text' name='programaposgraduacao' title='Programa de pós graduação' value='$programaposgraduacao'><br>";
        echo "Função: ";
        echo "<select name='funcao' title='Função'>";
        echo "<option value='1' " . ($funcao == 1 ? 'selected' : '') . ">Editor</option>";
        echo "<option value='2' " . ($funcao == 2 ? 'selected' : '') . ">Avaliador</option>";
        echo "<option value='3' " . ($funcao == 3 ? 'selected' : '') . ">Gerente</option>";
        echo "</select><br>";
        echo "<input type='submit' value='Salvar'>";
        echo"<br><a href='home.php'>Voltar</a>";
        echo "</form>";
    } else {
        echo "Usuário não encontrado.";
    }
} else {
    echo "ID do usuário não fornecido.";
}

$mysqli->close();
?>
