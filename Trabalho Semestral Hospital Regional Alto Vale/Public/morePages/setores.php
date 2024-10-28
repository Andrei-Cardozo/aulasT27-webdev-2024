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

    try {
        // Tenta executar a inserção
        if ($stmt->execute()) {
            
        }
    } catch (PDOException $e) {
        // Verifica se o erro é de violação de unicidade
        if ($e->getCode() === '23505') { // Código de erro para violação de unicidade
            $_SESSION['mensagem'] = 'Não foi possível criar o setor, pois já existe um com o mesmo nome.';
        } else {
            $_SESSION['mensagem'] = 'Erro ao cadastrar setor: ' . $e->getMessage();
        }
    }

    // Redireciona para a mesma página para evitar que o usuário veja o alerta novamente ao recarregar
    header("Location: setores.php");
    exit();
}
// Inativar todos os setores
if (isset($_POST['inativar_todos_setores'])) {
    $stmt = $conn->prepare("UPDATE setores SET ativo = false WHERE ativo = true");
    if ($stmt->execute()) {
        $_SESSION['mensagem'];
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
        $_SESSION['mensagem'];
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir setores inativos.";
    }
    header("Location: setores.php");
    exit();

        // Verificar quantas perguntas estão associadas ao setor
        $sqlVerificarPerguntas = "SELECT COUNT(*) FROM perguntas WHERE setor_id = ?";
        $stmtVerificar = $db->prepare($sqlVerificarPerguntas);
        $stmtVerificar->bindValue(1, $setor_id, PDO::PARAM_INT); // Usando bindValue
        $stmtVerificar->execute();
        $countPerguntas = $stmtVerificar->fetchColumn();
    
        if ($countPerguntas > 0) {
            die("Não é possível excluir este setor, pois ele possui perguntas associadas.");
        }
    
        // Se não houver perguntas, prosseguir com a exclusão do setor
        $sqlExcluirSetor = "DELETE FROM setores WHERE id = ?";
        $stmtExcluir = $db->prepare($sqlExcluirSetor);
        $stmtExcluir->bindValue(1, $setor_id, PDO::PARAM_INT); // Usando bindValue
        $stmtExcluir->execute();
    
        echo "Setor excluído com sucesso!";
        

// Lista de setores ativos
$setoresAtivos = $setoresObj->listarSetoresAtivos();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_setor'])) {
    $setor_id = $_POST['id']; // Use 'id' aqui, não 'setor_id'

    if ($setor_id) {
        try {
            // Prepara a query para inativar o setor
            $sqlInativar = "UPDATE setores SET ativo = false WHERE id = :setor_id";
            $stmt = $conn->prepare($sqlInativar);
            $stmt->bindParam(':setor_id', $setor_id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['mensagem'];
        } catch (PDOException $e) {
            $_SESSION['mensagem'] = "Erro ao inativar setor: " . $e->getMessage();
        }
    } else {
        $_SESSION['mensagem'] = "ID do setor não encontrado.";
    }

    // Redireciona para a mesma página para evitar que o usuário veja o alerta novamente ao recarregar
    header("Location: setores.php");
    exit();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <table class="tabela-setores">
    <thead>
        <tr>
            <th>Nome do Setor</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($setores_ativos as $setor): ?>
            <tr>
                <td><?php echo htmlspecialchars($setor['nome']); ?></td>
                <td>
                    <!-- Botão para Inativar Setor -->
                    <form action="setores.php" method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $setor['id']; ?>">
                        <button type="submit" name="delete_setor" onclick="return confirm('Tem certeza que deseja inativar este setor?');">Inativar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        <hr>

        <!-- Setores Inativos -->
        <h2>Setores Inativos</h2>
        <table class="tabela-setores">
    <thead>
        <tr>
            <th>Nome do Setor Inativo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($setores_inativos as $setor): ?>
            <tr>
                <td><?php echo htmlspecialchars($setor['nome']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

                <!-- Botões de Ações em Massa -->
                <form method="post">
            <button type="submit" name="inativar_todos_setores">Inativar Todos os Setores</button>
            <button type="submit" name="excluir_inativos_setores" <?php echo empty($setores_inativos) ? 'disabled' : ''; ?>>Excluir Setores Inativos</button>
        </form>

        
    </div>

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

</body>
</html>