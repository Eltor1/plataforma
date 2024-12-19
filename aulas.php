<?php
session_start();

include('db.php'); // Inclua a conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aulas - Plataforma</title>
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
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px auto;
            max-width: 1000px;
        }
        .lesson-box {
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .lesson-box:hover {
            transform: scale(1.05);
            background-color: #007bff;
            color: white;
        }
        .lesson-box h3 {
            font-size: 18px;
        }
        .lesson-box.assistido {
            background-color: #28a745;  /* Verde para "assistido" */
            color: white;
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }
        .modal-content {
            margin: 10% auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            text-align: center;
        }
        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: darkred;
        }
        video {
            width: 100%;
            height: 400px;
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
</head>
<body>

<!-- Cabeçalho -->
<div class="header">
    <h1>Aulas da Plataforma</h1>
    <nav>
        <a href="dashboard.php">Início</a>
        <a href="enviar_arquivos.php">Enviar Arquivos</a>
        <a href="logout.php" class="logout-link">Sair</a>
    </nav>
</div>

<!-- Conteúdo das Aulas -->
<h3>Aulas Iniciais</h3>
<div class="container">
    <div id="aula1" class="lesson-box" onclick="openModal('videos/aula1.mp4', 'aula1')">
        <h3>Teclado</h3>
    </div>
    <div id="aula2" class="lesson-box" onclick="openModal('videos/aula2.mp4', 'aula2')">
        <h3>Mouse</h3>
    </div>
    <div id="aula3" class="lesson-box" onclick="openModal('videos/aula3.mp4', 'aula3')">
        <h3>Aula 3</h3>
    </div>
</div>
</div>
<h3>Aulas Word</h3>
<div class="container">
    <!-- Aula 1 -->
   
    <div id="aula1" class="lesson-box" onclick="openModal('videos/aula1.mp4', 'aula1')">
        <h3>Aula 1</h3>
    </div>
    <!-- Aula 2 -->
    <div id="aula2" class="lesson-box" onclick="openModal('videos/aula2.mp4', 'aula2')">
        <h3>Aula 2</h3>
    </div>
    <!-- Aula 3 -->
    <div id="aula3" class="lesson-box" onclick="openModal('videos/aula3.mp4', 'aula3')">
        <h3>Aula 3</h3>
    </div>
   
    </div>
<h3>Aulas Excel</h3>
<div class="container">
    <!-- Aula 1 -->
   
    <div id="aula1" class="lesson-box" onclick="openModal('videos/aula1.mp4', 'aula1')">
        <h3>Aula 1</h3>
    </div>
    <!-- Aula 2 -->
    <div id="aula2" class="lesson-box" onclick="openModal('videos/aula2.mp4', 'aula2')">
        <h3>Aula 2</h3>
    </div>
    <!-- Aula 3 -->
    <div id="aula3" class="lesson-box" onclick="openModal('videos/aula3.mp4', 'aula3')">
        <h3>Aula 3</h3>
    </div>    
</div>

</div>
<h3>Aulas PowerPoint</h3>
<div class="container">
    <!-- Aula 1 -->
   
    <div id="aula1" class="lesson-box" onclick="openModal('videos/aula1.mp4', 'aula1')">
        <h3>Aula 1</h3>
    </div>
    <!-- Aula 2 -->
    <div id="aula2" class="lesson-box" onclick="openModal('videos/aula2.mp4', 'aula2')">
        <h3>Aula 2</h3>
    </div>
    <!-- Aula 3 -->
    <div id="aula3" class="lesson-box" onclick="openModal('videos/aula3.mp4', 'aula3')">
        <h3>Aula 3</h3>
    </div>
    
<!-- Modal para exibir vídeos -->
<div id="videoModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <video id="videoPlayer" controls>
            <source id="videoSource" src="" type="video/mp4">
            Seu navegador não suporta o elemento de vídeo.
        </video>
    </div>
</div>

<!-- Caixa de texto personalizada para saída -->
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

<script>
    // Função para abrir o modal com o vídeo da aula
    function openModal(videoUrl, aulaId) {
        document.getElementById('videoSource').src = videoUrl;
        document.getElementById('videoPlayer').load();
        document.getElementById('videoModal').style.display = 'block';

        if (localStorage.getItem(aulaId) === 'assistido') {
            document.getElementById(aulaId).classList.add('assistido');
        }

        document.getElementById('videoPlayer').onended = function() {
            localStorage.setItem(aulaId, 'assistido');
            document.getElementById(aulaId).classList.add('assistido');
        };
    }

    // Função para fechar o modal e parar o vídeo
    function closeModal() {
        document.getElementById('videoModal').style.display = 'none';
        document.getElementById('videoPlayer').pause();
    }

    // Fechar o modal ao clicar fora do conteúdo
    window.onclick = function(event) {
        const modal = document.getElementById('videoModal');
        if (event.target == modal) {
            closeModal();
        }
    }

    // Verificar se a aula já foi assistida
    window.onload = function() {
        ['aula1', 'aula2', 'aula3'].forEach(function(aulaId) {
            if (localStorage.getItem(aulaId) === 'assistido') {
                document.getElementById(aulaId).classList.add('assistido');
            }
        });

        // Controle da mensagem de saída personalizada
        const logoutLink = document.querySelector('.logout-link');
        const exitMessage = document.getElementById('exit-message');
        const closeMessageButton = document.getElementById('close-exit-message');
        const confirmLogoutLink = document.getElementById('confirm-logout');

        if (logoutLink) {
            logoutLink.addEventListener('click', function (event) {
                event.preventDefault();
                exitMessage.classList.remove('hidden');
            });
        }

        if (closeMessageButton) {
            closeMessageButton.addEventListener('click', function () {
                exitMessage.classList.add('hidden');
            });
        }

        if (confirmLogoutLink) {
            confirmLogoutLink.addEventListener('click', function () {
                exitMessage.classList.add('hidden');
            });
        }
    };
</script>

</body>
</html>
