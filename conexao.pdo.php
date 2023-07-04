<?php
$hostname = "localhost"; // nome do host
$username = "root"; // nome de usuário do banco de dados
$password = ""; // senha do banco de dados
$dbname = "iapa"; // nome do banco de dados

// tenta se conectar ao banco de dados usando o PDO
try {
  $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
  // define o modo de erro PDO como exceção
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
}
catch(PDOException $e) {
  echo "Conexão falhou: " . $e->getMessage();
}
?>
