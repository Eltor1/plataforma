<?php
$host = 'localhost';
$user = 'root'; // Usuário padrão do XAMPP
$password = ''; // Senha padrão
$dbname = 'plataforma';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
