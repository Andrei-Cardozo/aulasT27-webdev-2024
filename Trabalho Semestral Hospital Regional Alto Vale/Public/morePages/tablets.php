<?php
require_once '../../src/funcoes.php';

// Conecta ao banco de dados
$conn = getConnection();

if (!$conn) {
    die("Erro ao conectar com o banco de dados.");
}

// Lida com a adição de um novo tablet
if (isset($_POST['add_tablet'])) {
    $nomeTablet = $_POST['nome_tablet'];
    $localTablet = $_POST['setor_id'];
    
    // Insere o tablet no banco de dados
    $sqlInsert = "INSERT INTO tablets (nome, local, setor_id) VALUES (:nome, :local, :setor_id)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bindParam(':nome', $nomeTablet);
    $stmt->bindParam(':local', $localTablet);
    $stmt->bindParam(':setor_id', $localTablet);
    $stmt->execute();
    
    // Redireciona para evitar o reenvio do formulário
    echo "<script>window.location.href = 'tablets.php';</script>";
    exit();
}

// Lida com a inativação de um tablet
if (isset($_POST['delete_tablet'])) {
    $idTablet = $_POST['id'];
    
    $sqlDelete = "UPDATE tablets SET status = 'inativo' WHERE id = :id";
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bindParam(':id', $idTablet);
    $stmt->execute();
    
    // Redireciona para evitar reenvio do formulário
    echo "<script>window.location.href = 'tablets.php';</script>";
    exit();
}

// Inativar todos os tablets
if (isset($_POST['inativar_todos_tablets'])) {
    $sqlInativarTodos = "UPDATE tablets SET status = 'inativo' WHERE status = 'ativo'";
    if ($conn->query($sqlInativarTodos)) {
        echo "<script>alert('Todos os tablets foram inativados.');</script>";
    } else {
        echo "<script>alert('Erro ao inativar tablets.');</script>";
    }
    echo "<script>window.location.href = 'tablets.php';</script>";
    exit();
}

// Excluir permanentemente tablets inativos
if (isset($_POST['excluir_inativos_tablets'])) {
    $sqlExcluirInativos = "DELETE FROM tablets WHERE status = 'inativo'";
    if ($conn->query($sqlExcluirInativos)) {
        // Redefine o ID para começar novamente em 1
        $sqlResetId = "ALTER SEQUENCE tablets_id_seq RESTART WITH 1";
        $conn->query($sqlResetId);

        echo "<script>alert('Tablets inativos excluídos permanentemente e IDs redefinidos.');</script>";
    } else {
        echo "<script>alert('Erro ao excluir tablets inativos.');</script>";
    }
    echo "<script>window.location.href = 'tablets.php';</script>";
    exit();
}


// Consulta tablets ativos e inativos
$sqlAtivos = "SELECT tablets.*, setores.nome AS setor_nome FROM tablets 
              LEFT JOIN setores ON tablets.setor_id = setores.id 
              WHERE status = 'ativo'";
$stmt = $conn->query($sqlAtivos);
$tabletsAtivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlInativos = "SELECT tablets.*, setores.nome AS setor_nome FROM tablets 
                LEFT JOIN setores ON tablets.setor_id = setores.id 
                WHERE status = 'inativo'";
$stmt = $conn->query($sqlInativos);
$tabletsInativos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtém setores para o dropdown
$sqlSetores = "SELECT id, nome FROM setores";
$stmt = $conn->query($sqlSetores);
$setores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gerenciamento de Tablets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/styleTablets.css">
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
            width: 100%;
            height: auto;
            max-width: 900px;
            margin-right: 130px;
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
            right: 10px;
            top: 10px;
            width: 15%;
            height: 600px;
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
    padding: 0;
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
<div class="container">
    <h1>Painel de Gerenciamento de Tablets</h1>

    <!-- Formulário para Adicionar Tablet -->
    <h2>Adicionar Novo Tablet</h2>
    <form method="POST" action="">
        <input type="text" name="nome_tablet" placeholder="Digite o nome do tablet" required>
        
        <!-- Dropdown para escolher o setor -->
        <select name="setor_id" required>
            <option value="">Selecione o Setor</option>
            <?php foreach ($setores as $setor): ?>
                <option value="<?= $setor['id'] ?>"><?= $setor['nome'] ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="add_tablet">Adicionar</button>
    </form>

    <hr>

    <h2>Tablets Ativos</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Setor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tabletsAtivos)): ?>
                <?php foreach ($tabletsAtivos as $tablet): ?>
                    <tr>
                        <td><?= $tablet['id'] ?></td>
                        <td><?= $tablet['nome'] ?></td>
                        <td><?= $tablet['setor_nome'] ?></td>
                        <td>
                            <!-- Botão para Inativar Tablet -->
                            <form method="POST" action="" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?= $tablet['id'] ?>">
                                <button type="submit" name="delete_tablet" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja inativar este tablet?')">Inativar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum tablet ativo encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <hr>

    <h2>Tablets Inativos</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Setor</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tabletsInativos)): ?>
                <?php foreach ($tabletsInativos as $tablet): ?>
                    <tr>
                        <td><?= $tablet['id'] ?></td>
                        <td><?= $tablet['nome'] ?></td>
                        <td><?= $tablet['setor_nome'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Nenhum tablet inativo encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Botões de Ações em Massa -->
    <h2>Ações em Massa</h2>
    <form method="POST" action="" style="display: inline;">
        <button type="submit" name="inativar_todos_tablets" class="btn btn-alert" onclick="return confirm('Tem certeza que deseja inativar todas as perguntas ativas?');">Inativar Todos Os Tablets</button>
    </form>

    <form method="POST" action="" style="display: inline;">
        <button type="submit" name="excluir_inativos_tablets" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir permanentemente todas as perguntas inativas?');">Excluir Todos Os Tablets Inativos</button>
    </form>
</div>

            <!-- Codigos em css não estão sendo carregados -->

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
<script src="../../public/js/tablets.js"></script>
</body>
</html>
