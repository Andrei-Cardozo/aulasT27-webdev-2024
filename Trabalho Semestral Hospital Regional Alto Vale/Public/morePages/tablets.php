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
        echo "<script>alert('Tablets inativos excluídos permanentemente.');</script>";
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
    <link rel="stylesheet" href="../../public/css/styleTablets.css">
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
    <form method="post">
        <button type="submit" name="inativar_todos_tablets">Inativar Todos os Tablets</button>
        <button type="submit" name="excluir_inativos_tablets" <?= empty($tabletsInativos) ? 'disabled' : ''; ?>>Excluir Tablets Inativos</button>
    </form>
</div>
<script src="../../public/js/tablets.js"></script>
</body>
</html>
