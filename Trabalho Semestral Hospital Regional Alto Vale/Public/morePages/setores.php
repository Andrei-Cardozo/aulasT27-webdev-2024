<?php
require_once '../../src/db.php';
require_once '../../src/funcoes.php';

// Obtém a conexão com o banco de dados
$conn = getConnection();
session_start();

// Lida com adição de novo setor
if (isset($_POST['add_setor'])) {
    $nomeSetor = $_POST['nome_setor'];

    // Prepara a declaração SQL para evitar injeção de SQL
    $stmt = $conn->prepare("INSERT INTO setores (nome, ativo) VALUES (:nome, true)");
    $stmt->bindParam(':nome', $nomeSetor);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'Setor cadastrado com sucesso!';
    } else {
        $_SESSION['mensagem'] = 'Erro ao cadastrar setor.';
    }

    // Redireciona para a mesma página para evitar que o usuário veja o alerta novamente ao recarregar
    header("Location: setores.php");
    exit();
}

// Inativar todos os setores
if (isset($_POST['inativar_todos_setores'])) {
    $stmt = $conn->prepare("UPDATE setores SET ativo = false WHERE ativo = true");
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Todos os setores foram inativados.";
    } else {
        $_SESSION['mensagem'] = "Erro ao inativar setores.";
    }
    header("Location: setores.php");
    exit();
}

// Excluir permanentemente setores inativos
if (isset($_POST['excluir_inativos_setores'])) {
    $stmt = $conn->prepare("DELETE FROM setores WHERE ativo = false");
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Setores inativos excluídos permanentemente.";
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir setores inativos.";
    }
    header("Location: setores.php");
    exit();

    // Lida com a inativação de um setor específico
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_setor'])) {
    $id = $_POST['id']; // Obtém o ID do setor do formulário
    $setoresObj->inativarSetor($id); // Função para inativar o setor
    
    // Redireciona após a inativação
    header("Location: setores.php");
    exit();
}

// Lista de setores ativos
$setoresAtivos = $setoresObj->listarSetoresAtivos();
}

// Consulta setores ativos e inativos
$setores_ativos = $conn->query("SELECT * FROM setores WHERE ativo = true")->fetchAll(PDO::FETCH_ASSOC);
$setores_inativos = $conn->query("SELECT * FROM setores WHERE ativo = false")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Setores</title>
    <link rel="stylesheet" href="../../public/css/styleSetores.css"> 
</head>
<body>

    <div class="container">
        <h1>Cadastrar Setores</h1>

        <!-- Exibir mensagens de sucesso ou erro -->
        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert">
                <?= $_SESSION['mensagem']; ?>
                <?php unset($_SESSION['mensagem']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulário para Adicionar Setores -->
        <form action="setores.php" method="post">
            <label for="nome_setor">Nome do Setor:</label>
            <input type="text" name="nome_setor" required>
            <button type="submit" name="add_setor">Adicionar Setor</button>
        </form>

        <hr>

        <!-- Setores Ativos -->
        <h2>Setores Ativos</h2>
        <ul>
            <?php foreach ($setores_ativos as $setor): ?>
                <li>
                    <?php echo htmlspecialchars($setor['nome']); ?>
                    <!-- Botão para Inativar Setor -->
                    <form action="setores.php" method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $setor['id']; ?>">
                        <button type="submit" name="delete_setor" onclick="return confirm('Tem certeza que deseja inativar este setor?');">Inativar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
        <hr>

        <!-- Setores Inativos -->
        <h2>Setores Inativos</h2>
        <ul>
            <?php foreach ($setores_inativos as $setor): ?>
                <li><?php echo htmlspecialchars($setor['nome']); ?></li>
            <?php endforeach; ?>
        </ul>

                <!-- Botões de Ações em Massa -->
                <form method="post">
            <button type="submit" name="inativar_todos_setores">Inativar Todos os Setores</button>
            <button type="submit" name="excluir_inativos_setores" <?php echo empty($setores_inativos) ? 'disabled' : ''; ?>>Excluir Setores Inativos</button>
        </form>

        
    </div>

    <div class="sidebar">
        <div class="containerSidebar">
            <div class="logo">
                <!-- Colocar admin aqui --> <!-- alterar icones -->
            </div>

        <ul class="menu">
            <li><a href="../admin.php">
                <i class="fas fa-home"></i>
                <span>Menu</span>
                </span>
            </a></li>

            <li><a href="">
                <i class="fa-solid fa-bell"></i>
                <span>Gerenciar Setores</span>
            </a></li>

            <li><a href="">
                <i class="fa-solid fa-gear"></i>
                <span>Gerenciar Tablets</span>
            </a></li>
            
            <li><a href="">
                <i class="fas fa-globe"></i>
                <span>Gerenciar Perguntas</span>  
            </a></li>

            <li><a href="">
                <i class=""></i>
                <span>Dashboards das Respostas</span>
            </a></li>

        </ul>
    </div>

</body>
</html>