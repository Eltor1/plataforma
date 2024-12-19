<?php
session_start();
include('db.php'); // Inclua a conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Busca o nome completo no banco de dados
$query = $conn->prepare("SELECT nome_completo FROM usuarios WHERE id = ?");
$query->bind_param("i", $userId);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomeUsuario = $row['nome_completo'];
    $_SESSION['nome_completo'] = $nomeUsuario; // Opcional: salvar na sessão
} else {
    $nomeUsuario = 'Usuário'; // Nome padrão caso não seja encontrado
}

$query->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Como Funciona</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header, footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
        }
        nav ul.menu {
            list-style-type: none;
            padding: 0;
        }
        nav ul.menu li {
            display: inline;
            margin-right: 15px;
        }
        nav ul.menu li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        .video-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }
        .video {
            margin: 15px 0;
            text-align: center;
        }
        video {
            width: 560px;
            height: 315px;
            max-width: 100%;
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
    <header>
        <nav>
            <ul class="menu">
                <li><a href="dashboard.php">Início</a></li>
                <li><a href="aulas.php">Assistir Aulas</a></li>
                <li><a href="enviar_arquivos.php">Enviar Arquivos</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
        <h1>Bem-vindo(a), <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
        <p>Aqui você encontrará explicações sobre como usar o site.</p>
    </header>

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
    <!-- Conteúdo Principal -->
    <main>
        <h1>Como Funciona a Plataforma</h1>
        <section class="video-container">
            <!-- Vídeos locais -->
            <div class="video">
                <h3>1. Como Funciona a Plataforma</h3>
                <video controls controlslist="nodownload" oncontextmenu="return false;">
                    <source src="videos/como-funciona.mp4" type="video/mp4">
                    Seu navegador não suporta vídeos HTML5.
                </video>
            </div>
            <div class="video">
                <h3>2. Como Enviar Arquivos</h3>
                <video controls controlslist="nodownload" oncontextmenu="return false;">
                    <source src="videos/como-enviar-arquivos.mp4" type="video/mp4">
                    Seu navegador não suporta vídeos HTML5.
                </video>
            </div>
            <div class="video">
                <h3>3. Aula Inaugural: Como Funciona um Computador</h3>
                <video controls controlslist="nodownload" oncontextmenu="return false;"> 
                    <source src="videos/como-funciona-computador.mp4" type="video/mp4">
                    Seu navegador não suporta vídeos HTML5.
                </video>
            </div>
        </section>
    </main>



    <!-- Rodapé -->
    <footer>
        <p>&copy; 2024 - Plataforma Educacional</p>
    </footer>
</body>
</html>
