<?php
require_once '../../src/db.php';
require_once '../../config.php';

// Conecta ao banco de dados
$conn = getConnection();

if (!$conn) {
    die("Erro ao conectar com o banco de dados.");
}

// Lida com a adição de um novo usuário administrativo
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash da senha
    $password_hash = hash(HASH_ALGO, $password);

    // Insere o usuário no banco de dados
    $sqlInsert = "INSERT INTO usuarios_admin (username, password_hash) VALUES (:username, :password_hash)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password_hash', $password_hash);
    $stmt->execute();
    
    // Redireciona para evitar o reenvio do formulário
    echo "<script>window.location.href = 'users.php';</script>";
    exit();
}

// Lida com a remoção de um usuário administrativo
if (isset($_POST['delete_user'])) {
    $idUser = $_POST['id'];
    
    $sqlDelete = "DELETE FROM usuarios_admin WHERE id = :id";
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bindParam(':id', $idUser);
    $stmt->execute();
    
    // Redireciona para evitar reenvio do formulário
    echo "<script>window.location.href = 'users.php';</script>";
    exit();
}

// Consulta usuários administrativos
$sqlUsers = "SELECT * FROM usuarios_admin";
$stmt = $conn->query($sqlUsers);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gerenciamento de Usuários Administrativos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/styleUsersAdmin.css">
</head>
<body>
<div class="container">
    <h1>Painel de Gerenciamento de Usuários Administrativos</h1>

    <!-- Formulário para Adicionar Usuário Administrativo -->
    <h2>Adicionar Novo Usuário</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Digite o nome de usuário" required>
        <input type="password" name="password" placeholder="Digite a senha" required>
        <button type="submit" name="add_user">Adicionar</button>
    </form>

    <hr>

    <h2>Usuários Administrativos</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome de Usuário</th>
                <th>Data de Criação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['created_at'] ?></td>
                        <td>
                            <!-- Botão para Remover Usuário -->
                            <form method="POST" action="" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit" name="delete_user" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja remover este usuário?')">Remover</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum usuário administrativo encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="sidebar">
    <div class="containerSidebar">
        <ul class="menu">
            <li><a href="../admin.php">
                <i class="fas fa-home"></i>
                <span>Menu</span>
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
                <i class="fa-solid fa-clipboard"></i>
                <span>Gerenciar Perguntas</span>
            </a></li>
            <li><a href="answers.php">
                <i class="fa-regular fa-comments"></i>
                <span>Dashboards das Respostas</span>
            </a></li>
        </ul>
    </div>
</div>

<script src="../../public/js/users.js"></script>
</body>
</html>
