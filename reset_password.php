<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'nome_do_banco');

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obter os dados enviados pelo formulário
$email = $_POST['email'];
$new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

// Atualizar a senha no banco de dados
$query = "UPDATE usuarios SET senha = ? WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $new_password, $email);

if ($stmt->execute()) {
    echo "<p>Senha redefinida com sucesso! Você já pode fazer login com sua nova senha.</p>";
} else {
    echo "<p>Erro ao redefinir a senha. Tente novamente mais tarde.</p>";
}

$conn->close();
?>
