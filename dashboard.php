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
    $_SESSION['nome_completo'] = $nomeUsuario; // Opcional: salvar na sessão para futuras páginas
} else {
    $nomeUsuario = 'Usuário'; // Nome padrão caso não seja encontrado
}

$query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Como Funciona</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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

    <main>
        <section class="video-container">
            <h2>Como Funciona a Plataforma</h2>
            <div class="video">
                <h3>1. Como Funciona a Plataforma</h3>
                <video controls>
                    <source src="videos/como_funciona.mp4" type="video/mp4">
                    Seu navegador não suporta o elemento de vídeo.
                </video>
            </div>
            <div class="video">
                <h3>2. Como Enviar Arquivos</h3>
                <video controls>
                    <source src="videos/enviar_arquivos.mp4" type="video/mp4">
                    Seu navegador não suporta o elemento de vídeo.
                </video>
            </div>
            <div class="video">
                <h3>3. Aula Inaugural: Como Funciona um Computador</h3>
                <video controls>
                    <source src="videos/funciona_computador.mp4" type="video/mp4">
                    Seu navegador não suporta o elemento de vídeo.
                </video>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 - Plataforma Educacional</p>
    </footer>
</body>
</html>
