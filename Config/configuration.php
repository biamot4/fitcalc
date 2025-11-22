<?php
$servername = "127.0.0.1";
$username = "root"; // Seu usuário
$password = ""; // Sua senha (vazia)
$dbname = "fitcalc"; // Seu nome do banco de dados
$port = 3306; // Sua porta

// Tenta Conexão
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verifica Conexão
if ($conn->connect_error) {
    die("A conexão falhou. Erro: " . $conn->connect_error);
}
echo "Conexão bem-sucedida! O problema está na classe PDO/Connection.";
$conn->close();
?>