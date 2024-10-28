<?php
session_start();
require_once '../../src/funcoes.php';

// Conecta ao banco de dados
$conn = getConnection();

if (!$conn) {
    die("Erro ao conectar com o banco de dados.");
}

// Obter o setor selecionado da sessão
$setorSelecionado = isset($_SESSION['setor_selecionado']) ? $_SESSION['setor_selecionado'] : null;

// Consulta a contagem de respostas por setor
$sqlSetor = "SELECT s.id, s.nome, COUNT(r.id) AS total_respostas 
             FROM setores s 
             LEFT JOIN respostas r ON s.id = r.setor_id 
             GROUP BY s.id, s.nome";
$stmtSetor = $conn->query($sqlSetor);
$respostasPorSetor = $stmtSetor->fetchAll(PDO::FETCH_ASSOC);

// Consulta a contagem de notas
$sqlNota = "SELECT avaliacao, COUNT(*) AS total_nota FROM respostas GROUP BY avaliacao ORDER BY avaliacao";
$stmtNota = $conn->query($sqlNota);
$respostasPorNota = $stmtNota->fetchAll(PDO::FETCH_ASSOC);

// Consulta feedbacks com setor (com junção)
$sqlFeedbacks = "SELECT r.feedback, s.nome AS setor_nome 
                 FROM respostas r 
                 JOIN setores s ON r.setor_id = s.id 
                 WHERE r.feedback IS NOT NULL";
$stmtFeedbacks = $conn->query($sqlFeedbacks);
$feedbacks = $stmtFeedbacks->fetchAll(PDO::FETCH_ASSOC);

// Consulta as avaliações médias por setor
$sqlAvaliacoesSetor = "SELECT setor_id, AVG(avaliacao) AS media_avaliacao 
                       FROM respostas 
                       WHERE setor_id IS NOT NULL 
                       GROUP BY setor_id";
$stmtAvaliacoesSetor = $conn->query($sqlAvaliacoesSetor);
$avaliacoesPorSetor = $stmtAvaliacoesSetor->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Respostas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../../public/css/styleAnswers.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos globais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: auto;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .chart-container {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .chart {
            width: 48%; /* Ajuste para duas colunas */
            margin-bottom: 20px; /* Espaçamento entre linhas */
        }
        .feedback-container {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 20px;
            text-align: left; /* Alinhar texto à esquerda */
        }
        h2 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .sidebar{
            position: fixed;
            right: 8px;
            top: 10px;
            width: 15%;
            height: 550px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            background: linear-gradient(to bottom, #002244, #0056a3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, .25);
            padding: 2rem 0;
            overflow: hidden;
            transition: width .3s ease-in-out;
            border-radius: 12px;
}
.sidebar.active{
    width: 5%;
}

.containerSidebar{
    display: flex;
    flex-direction: column;
    gap: 5rem;
    border-radius: 12px;
    margin-top: -80px;
    padding: 5px;
}
.logo img{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    color: white;
}

.menu{
    list-style: none;
    display: flex;
    flex-direction: column;
    padding: 0 2px;
}

.menu li a{
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: 18px;
    color: white;
    border-radius: 15px;
    padding: 15px;
    text-transform: uppercase;
    transition: all .3s ease-in-out;
    margin-top: 20px
}
.menu li a:hover{
    background: rgba(255, 255, 255, .3);
}
.menu li a i{
    font-size: 25px;
}

.logout{
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: 18px;
    padding: 0 10%;
    color: white;
}
.logout a{
    text-decoration: none;
    list-style: none;
    color: white;
    border-radius: 15px;
    padding: 1rem 10%;
    text-transform: uppercase;
    transition: all .3s ease-in-out;
}
.logout a:hover{
    background-color: rgba(255, 255, 255, .3);
    cursor: pointer;
}
.sidebar.active .menu li a span,
.sidebar.active .logout span{
    display: none;
}

.sidebar.active .menu li a,
.sidebar.active .logout{
    justify-content: center;
}
    </style>
</head>
<body>

<div class="sidebar">
        <div class="containerSidebar">>

        <ul class="menu">
            <li><a href="../admin.php">
                <i class="fas fa-home"></i>
                <span>Menu</span>
                </span>
            </a></li>

            <li><a href="setores.php">
                <i class="fa-solid fa-window-restore"></i>
                <span>Gerenciar Setores</span>
            </a></li>

            <li><a href="tablets.php">
                <i class="fa-solid fa-tablet-screen-button"></i>
                <span>Gerenciar Tablets</span>
            </a></li>
            
            <li><a href="quests.php">
                <i class="fa-solid fa-clipboard-question"></i><i class="fa-solid fa-question"></i>
                <span>Gerenciar Perguntas</span>  
            </a></li>

            <li><a href="answers.php">
                <i class="fa-regular fa-comments"></i>
                <span>Dashboards das Respostas</span>
            </a></li>

        </ul>
    </div>

    </div>
    <div class="container">
        <h1>Dashboard de Respostas</h1>
        <div class="chart-container">
            <div class="chart">
                <h2>Respostas por Setor</h2>
                <canvas id="setorChart"></canvas>
            </div>
            <div class="chart">
                <h2>Notas Totais Recebidas</h2>
                <canvas id="notaChart"></canvas>
            </div>
            <div class="chart">
                <h2>Média de Avaliações por Setor</h2>
                <canvas id="avaliacoesChart"></canvas>
            </div>
        </div>

        <div class="feedback-container">
            <h2>Feedbacks Recebidos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Feedback</th>
                        <th>Setor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($feedbacks) > 0): ?>
                        <?php foreach ($feedbacks as $feedback): ?>
                            <tr>
                                <td><?= htmlspecialchars($feedback['feedback']) ?></td>
                                <td><?= htmlspecialchars($feedback['setor_nome']) ?></td> <!-- Exibindo o nome do setor correspondente -->
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">Nenhum feedback disponível.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Gráfico de Respostas por Setor
        const setorData = {
            labels: <?= json_encode(array_column($respostasPorSetor, 'nome')) ?>, // Nome dos setores
            datasets: [{
                label: 'Total de Respostas',
                data: <?= json_encode(array_column($respostasPorSetor, 'total_respostas')) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };
        
        const setorConfig = {
            type: 'bar',
            data: setorData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Gráfico de Notas Recebidas
        const notaData = {
            labels: <?= json_encode(array_column($respostasPorNota, 'avaliacao')) ?>,
            datasets: [{
                label: 'Total de Notas',
                data: <?= json_encode(array_column($respostasPorNota, 'total_nota')) ?>,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        };

        const notaConfig = {
            type: 'bar',
            data: notaData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Gráfico de Média de Avaliações por Setor
        const avaliacoesData = {
            labels: <?= json_encode(array_column($avaliacoesPorSetor, 'setor_id')) ?>,
            datasets: [{
                label: 'Média de Avaliações',
                data: <?= json_encode(array_column($avaliacoesPorSetor, 'media_avaliacao')) ?>,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        };

        const avaliacoesConfig = {
            type: 'bar',
            data: avaliacoesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Renderiza os gráficos
        const setorChart = new Chart(document.getElementById('setorChart'), setorConfig);
        const notaChart = new Chart(document.getElementById('notaChart'), notaConfig);
        const avaliacoesChart = new Chart(document.getElementById('avaliacoesChart'), avaliacoesConfig);
    </script>
</body>
</html>
