<?php
session_start();
include('db.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Obtém o ID do usuário logado
$userId = $_SESSION['user_id'];

// Recupera o nome completo do usuário no banco de dados
$query = $conn->prepare("SELECT nome_completo FROM usuarios WHERE id = ?");
$query->bind_param("i", $userId);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $usernome_completo = $row['nome_completo']; // Atribui o nome completo
} else {
    $usernome_completo = 'UsuarioDesconhecido'; // Nome padrão se não encontrado
}

$query->close();

// Diretório base e diretório específico do usuário (com nome completo)
$diretorioBase = "uploads/";
$diretorioUsuario = $diretorioBase . $usernome_completo . "/"; // Usando nome completo

// Verifica se a pasta do usuário existe, caso contrário, cria
if (!is_dir($diretorioUsuario)) {
    mkdir($diretorioUsuario, 0777, true); // Cria a pasta com permissões adequadas
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['arquivo'])) {
    $arquivoDestino = $diretorioUsuario . basename($_FILES['arquivo']['name']);
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivoDestino)) {
        echo "<h2 style='color: green;'>Arquivo enviado com sucesso!</h2>";
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
                /* Caixa de texto personalizada */
                #exit-message {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fundo semitransparente */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        #exit-message.hidden {
            display: none; /* Esconde a mensagem */
        }
        .exit-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        .exit-box p {
            margin: 0 0 20px 0;
            font-size: 16px;
            color: #333;
        }
        .exit-box button,
        .exit-box a {
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .exit-box button:hover,
        .exit-box a:hover {
            background-color: #0056b3;
        }
    </style>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Seleciona o link "Sair" no menu
            const logoutLink = document.querySelector('a[href="logout.php"]');
            const exitMessage = document.getElementById('exit-message');
            const closeMessageButton = document.getElementById('close-exit-message');
            const confirmLogoutLink = document.getElementById('confirm-logout');

            if (logoutLink) {
                // Previne o comportamento padrão e mostra a mensagem ao clicar no link "Sair"
                logoutLink.addEventListener('click', function (event) {
                    event.preventDefault();
                    exitMessage.classList.remove('hidden');
                });
            }

            // Fecha a mensagem personalizada ao clicar no botão "Fechar"
            if (closeMessageButton) {
                closeMessageButton.addEventListener('click', function () {
                    exitMessage.classList.add('hidden');
                });
            }

            // Continua para o logout ao clicar em "Confirmar Logout"
            if (confirmLogoutLink) {
                confirmLogoutLink.addEventListener('click', function () {
                    exitMessage.classList.add('hidden');
                });
            }
        });
    </script>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>Plataforma - Enviar Arquivos</h1>
        <nav>
            <a href="dashboard.php">Início</a>
            <a href="aulas.php">Assistir Aulas</a>
            <a href="logout.php">Sair</a>
        </nav>
    </div>
    <!-- Caixa de texto personalizada -->
    <div id="exit-message" class="hidden">
        <div class="exit-box">
            <p>
                Antes de sair:
                <br><br>
                1. Salve sua atividade na pasta de alunos.<br>
                2. Desligue o computador após encerrar.<br><br>
                Clique em "Fechar" para continuar.
            </p>
            <button id="close-exit-message">Fechar</button>
            <a href="logout.php" id="confirm-logout">Confirmar Logout</a>
        </div>
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
