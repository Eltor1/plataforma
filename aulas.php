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
            max-width: 900px;
        }
        .lesson-box {
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            width: 200px;
            height: 200px;
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
    </style>
</head>
<body>

<!-- Cabeçalho -->
<div class="header">
    <h1>Aulas da Plataforma</h1>
    <nav>
        <a href="dashboard.php">Início</a>
        <a href="enviar_arquivos.php">Enviar Arquivos</a>
        <a href="index.php">Sair</a>
    </nav>
</div>

<!-- Conteúdo das Aulas -->
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

<script>
    // Função para abrir o modal com o vídeo da aula
    function openModal(videoUrl, aulaId) {
        // Carrega o vídeo no player
        document.getElementById('videoSource').src = videoUrl;
        document.getElementById('videoPlayer').load();
        document.getElementById('videoModal').style.display = 'block';

        // Marcar a aula como assistida caso já tenha sido completada
        if (localStorage.getItem(aulaId) === 'assistido') {
            document.getElementById(aulaId).classList.add('assistido');
        }

        // Adicionar evento para verificar quando o vídeo terminar
        document.getElementById('videoPlayer').onended = function() {
            // Marcar aula como assistida no localStorage
            localStorage.setItem(aulaId, 'assistido');
            // Atualizar o estilo da aula para 'assistido'
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

    // Verificar se a aula já foi assistida e atualizar a interface
    window.onload = function() {
        ['aula1', 'aula2', 'aula3'].forEach(function(aulaId) {
            if (localStorage.getItem(aulaId) === 'assistido') {
                document.getElementById(aulaId).classList.add('assistido');
            }
        });
    };
</script>

</body>
</html>
