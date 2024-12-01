<?php
session_start();
include('db.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$usernome_completo = $_SESSION['user_id'];
$diretorioBase = "uploads/"; // Diretório base para os uploads
$diretorioUsuario = $diretorioBase . $usernome_completo . "/"; // Diretório específico do usuário

// Verifica se a pasta do usuário existe, caso contrário, cria
if (!is_dir($diretorioUsuario)) {
    mkdir($diretorioUsuario, 0777, true); // Cria a pasta com permissões adequadas
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['arquivo'])) {
    $arquivoDestino = $diretorioUsuario . basename($_FILES['arquivo']['name']);
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivoDestino)) {
        echo "<p style='color: green;'>Arquivo enviado com sucesso!</p>";
    } else {
        echo "<p style='color: red;'>Erro ao enviar o arquivo. Verifique as permissões da pasta.</p>";
    }
}

// Remove um arquivo do usuário quando solicitado
if (isset($_GET['remover'])) {
    $arquivoParaRemover = $diretorioUsuario . basename($_GET['remover']);
    if (file_exists($arquivoParaRemover)) {
        unlink($arquivoParaRemover);
        echo "<p style='color: green;'>Arquivo removido com sucesso!</p>";
    } else {
        echo "<p style='color: red;'>Erro: O arquivo não existe.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Arquivos - Plataforma</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 10px;
        }
        .header nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
        .header nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
        }
        .button {
            padding: 10px 20px;
            margin: 5px;
            color: white;
            background-color: #007bff;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>Plataforma - Enviar Arquivos</h1>
        <nav>
            <a href="dashboard.php">Início</a>
            <a href="aulas.php">Assistir Aulas</a>
            <a href="enviar_arquivos.php">Enviar Arquivos</a>
            <a href="logout.php">Sair</a>
        </nav>
    </div>

    <h1>Enviar Atividades</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="arquivo">Escolha o arquivo:</label>
        <input type="file" name="arquivo" id="arquivo" required>
        <button type="submit">Enviar</button>
    </form>

    <?php
    // Lista os arquivos do diretório do usuário
    $arquivos = scandir($diretorioUsuario);
    if (count($arquivos) > 2) { // Exclui '.' e '..'
        echo "<h3>Seus Arquivos Enviados:</h3>";
        echo "<ul>";
        foreach ($arquivos as $arquivo) {
            if ($arquivo != "." && $arquivo != "..") {
                echo "<li>";
                echo "<a href='$diretorioUsuario$arquivo' target='_blank'>$arquivo</a>";
                echo " <a href='?remover=$arquivo' style='color: red;'>[Remover]</a>";
                echo "</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>Você ainda não enviou nenhum arquivo.</p>";
    }
    ?>
</body>
</html>
