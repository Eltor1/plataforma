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
            $_SESSION['user_email'] = $email_recuperado;
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
                unset($_SESSION['user_email']);
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #4682B4; /* Fundo azul claro */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Adicione aqui a logo da empresa -->
        <img src="logo.png" alt="Logo da Empresa" class="logo"> <!-- Substitua 'logo.png' pelo caminho correto -->

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
    </div>
</body>
</html>
