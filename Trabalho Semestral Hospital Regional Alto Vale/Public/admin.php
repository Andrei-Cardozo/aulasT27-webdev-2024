<?php
require_once '../src/db.php';
require_once '../src/perguntas.php';
require_once '../src/funcoes.php';
session_start(); 

// Definir o tempo de timeout (em segundos)
$tempo_timeout = 600; // 10 minutos

// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>
            alert('Você deve fazer o login primeiro!');
            window.location.href = '../public/login.php';
          </script>";
    exit();
}

// Verificar o tempo da última atividade
if (isset($_SESSION['last_activity'])) {
    // Calcular o tempo desde a última atividade
    $tempo_inativo = time() - $_SESSION['last_activity'];

    // Se o tempo inativo exceder o tempo permitido
    if ($tempo_inativo > $tempo_timeout) {
        // Destruir a sessão e redirecionar para a página de login
        session_unset();
        session_destroy();
        echo "<script>
                alert('Sessão expirada! Faça login novamente.');
                window.location.href = '../public/login.php';
              </script>";
        exit();
    }
}

// Atualizar o tempo da última atividade para o tempo atual
$_SESSION['last_activity'] = time();

// Conecta ao banco de dados
$conn = getConnection();

if (!$conn) {
    die("Erro ao conectar com o banco de dados.");

    
}

// Consulta os 3 últimos feedbacks
$sqlFeedbacksRecentes = "SELECT r.feedback, s.nome AS setor_nome 
                         FROM respostas r 
                         JOIN setores s ON r.setor_id = s.id 
                         WHERE r.feedback IS NOT NULL 
                         ORDER BY r.id DESC 
                         LIMIT 3";
$stmtFeedbacksRecentes = $conn->query($sqlFeedbacksRecentes);
$feedbacksRecentes = $stmtFeedbacksRecentes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../public/css/styleAdmin.css">
    <script>
        // Definir o tempo de timeout no lado do cliente (em milissegundos)
        var timeout = 600000; // 10 minutos
        var timeoutId;

        // Função para redirecionar após o timeout
        function redirecionarParaLogin() {
            alert('Sessão expirada! Faça login novamente.');
            window.location.href = '../public/login.php';
        }

        // Função para resetar o timer de inatividade
        function resetarTimer() {
            // Limpar o timeout existente
            clearTimeout(timeoutId);
            // Reiniciar o timeout
            timeoutId = setTimeout(redirecionarParaLogin, timeout);
        }

        // Monitorar eventos de interação do usuário
        window.onload = resetarTimer; // Reseta quando a página carrega
        document.onmousemove = resetarTimer; // Reseta ao mover o mouse
        document.onkeypress = resetarTimer; // Reseta ao pressionar qualquer tecla
        document.onclick = resetarTimer; // Reseta ao clicar
        document.ontouchstart = resetarTimer; // Reseta ao tocar em dispositivos móveis
    </script>
</head>
<body>
<!--    Salvar esse código para reutilizar logo mais. Alterar o código daqui para baixo     -->

<div class="navbar">
    <div class="container">
        <div class="logo">
            <img src="images/logoHRAV.png" alt="Logo do Hospital Regional do Alto Vale" class="logoHRAV">
        </div>

        <ul class="menu">
            <li><a href="">
                <i class="fas fa-home"></i>
                <span>Menu</span>
            </a></li>
            <li><a href="">
                <i class="fa-solid fa-bell"></i>
                <span>Notificações</span>
            </a></li>
            <li><a href="">
                <i class="fa-solid fa-gear"></i>
                <span>Configurações</span>
            </a></li>
            <li><a href="https://www.hrav.com.br/">
                <i class="fas fa-globe"></i>
                <span>Site HRAV</span>  
            </a></li>
        </ul>

        <div class="logout">
            <a href="../src/logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span class="link-text">Sair</span>
            </a>
        </div>
    </div>

    <div class="menu-btn">
        <i class="fa-solid fa-bars"></i>
    </div>
</div>

<div class="container-box-btns">
    <div class="box-localmap">
        <a href="morePages/setores.php" class="localmap-btn">
            <button>Cadastramento de Setores</button>
        </a>
    </div>

    <div class="box-tablet">
        <a href="morePages/tablets.php" class="tablet-btn"> 
            <button>Gerenciar Tablets</button>
        </a>
    </div>

    <div class="box-quest">
        <a href="morePages/quests.php" class="quest-btn"> 
            <button>Gerenciar Perguntas</button>
        </a>
    </div>

    <div class="box-answers">
        <a href="morePages/answers.php" class="answer-btn">
            <button>Dashboards das Respostas</button>
        </a>
    </div>
</div>

<div class="sidebar">
        <div class="feedback-container">
            <h2>Últimos Feedbacks Recebidos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Feedback</th>
                        <th>Setor</th>
                        <hr>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($feedbacksRecentes) > 0): ?>
                        <?php foreach ($feedbacksRecentes as $feedback): ?>
                            <tr>
                                <td><?= htmlspecialchars($feedback['feedback']) ?></td>
                                <td><?= htmlspecialchars($feedback['setor_nome']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" style="text-align: center;">Nenhum feedback disponível.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<script src="js/admin.js"></script>

</body>
</html>
