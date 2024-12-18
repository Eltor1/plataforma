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
    </style>
        <script>
        // Bloqueia o menu de contexto (clique com botão direito) em todo o site
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
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
