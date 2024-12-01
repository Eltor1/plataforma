<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Login
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: dashboard.php');
                exit();
            } else {
                $error = "Senha incorreta.";
            }
        } else {
            $error = "Usuário não encontrado.";
        }
    }

    // Recuperação de senha - Encontrar email pelo nome
    if (isset($_POST['nome_completo'])) {
        $nome_completo = $_POST['nome_completo'];

        $query = "SELECT email FROM usuarios WHERE nome_completo = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $nome_completo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $email_recuperado = $user['email'];
            $_SESSION['user_email'] = $email_recuperado; // Salva o e-mail para redefinir a senha
            $success = "E-mail encontrado: $email_recuperado. Insira uma nova senha abaixo.";
        } else {
            $error = "Usuário não encontrado.";
        }
    }

    // Redefinir senha
    if (isset($_POST['nova_senha'])) {
        if (!empty($_SESSION['user_email'])) {
            $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
            $email = $_SESSION['user_email'];

            $query = "UPDATE usuarios SET senha = ? WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss', $nova_senha, $email);
            if ($stmt->execute()) {
                $success = "Senha redefinida com sucesso!";
                unset($_SESSION['user_email']); // Limpa a sessão após redefinição
            } else {
                $error = "Erro ao redefinir a senha.";
            }
        } else {
            $error = "Sessão inválida. Por favor, inicie o processo novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Login</h1>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p style='color: green;'>$success</p>"; ?>

    <!-- Formulário de Login -->
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>

    <p>Não tem uma conta? <a href="register.php">Cadastre-se</a></p>

    <!-- Formulário de recuperação de senha -->
    <h2>Esqueceu sua senha ou e-mail?</h2>
    <form method="POST">
        <input type="text" name="nome_completo" placeholder="Digite seu nome completo" required>
        <button type="submit">Recuperar E-mail</button>
    </form>

    <?php if (!empty($_SESSION['user_email'])): ?>
        <!-- Formulário para redefinir a senha -->
        <h3>Redefinir Senha</h3>
        <form method="POST">
            <input type="password" name="nova_senha" placeholder="Digite sua nova senha" required>
            <button type="submit">Redefinir Senha</button>
        </form>
    <?php endif; ?>
</body>
</html>
