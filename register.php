<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_completo = $_POST['nome_completo'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $query = "INSERT INTO usuarios (nome_completo, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $nome_completo, $email, $senha);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit();
    } else {
        $error = "Erro ao registrar. Email pode já estar em uso.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Cadastro</h1>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="nome_completo" placeholder="Nome completo" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Cadastrar</button>
    </form>
    <p>Já tem uma conta? <a href="index.php">Faça login</a></p>
</body>
</html>
