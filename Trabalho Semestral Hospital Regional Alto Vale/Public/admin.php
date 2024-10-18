<?php
require_once '../src/db.php';
require_once '../src/perguntas.php';

// Obtém a conexão com o banco de dados
$conn = getConnection();

// Instancia o objeto da classe Perguntas
$perguntasObj = new Perguntas($conn);

// Lida com adição de nova pergunta
if (isset($_POST['add_pergunta'])) {
    $novaPergunta = $_POST['nova_pergunta'];
    $perguntasObj->adicionarPergunta($novaPergunta);
}

// Lida com edição de uma pergunta
if (isset($_POST['edit_pergunta'])) {
    $id = $_POST['id'];
    $textoEditado = $_POST['texto_editado'];
    $perguntasObj->editarPergunta($id, $textoEditado);
}

// Lida com exclusão de uma pergunta
if (isset($_POST['delete_pergunta'])) {
    $id = $_POST['id'];
    $perguntasObj->deletarPergunta($id);
}

// Obtém a lista de perguntas
$perguntas = $perguntasObj->listarPerguntas();

// Busca todas as respostas no banco de dados
$sql = "SELECT * FROM respostas";
$stmt = $conn->prepare($sql);
$stmt->execute();
$respostas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="../Public/css/styleAdmin.css">
</head>
<body>

    <div class="container">
        <h1>Painel de Administração</h1>

        <!-- Formulário para Adicionar Pergunta -->
        <h2>Adicionar Nova Pergunta</h2>
        <form method="POST" action="">
            <input type="text" name="nova_pergunta" placeholder="Digite a nova pergunta" required>
            <button type="submit" name="add_pergunta">Adicionar</button>
        </form>

        <hr>

        <!-- Tabela de Perguntas -->
        <h2>Gerenciar Perguntas</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pergunta</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($perguntas) && is_array($perguntas)) : ?>
                    <?php foreach ($perguntas as $pergunta): ?>
                    <tr>
                        <td><?= $pergunta['id'] ?></td>
                        <td><?= $pergunta['texto'] ?></td>
                        <td>
                            <!-- Formulário para Editar Pergunta -->
                            <form method="POST" action="" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?= $pergunta['id'] ?>">
                                <input type="text" name="texto_editado" value="<?= $pergunta['texto'] ?>" required>
                                <button type="submit" name="edit_pergunta">Editar</button>
                            </form>

                            <!-- Formulário para Excluir Pergunta -->
                            <form method="POST" action="" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?= $pergunta['id'] ?>">
                                <button type="submit" name="delete_pergunta" onclick="return confirm('Tem certeza que deseja excluir esta pergunta?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Nenhuma pergunta encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <hr>

        <!-- Tabela de Respostas -->
        <h2>Respostas das Avaliações</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Pergunta</th>
                    <th>Avaliação</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($respostas)): ?>
                    <?php foreach ($respostas as $resposta): ?>
                        <tr>
                            <td><?= htmlspecialchars($resposta['id']) ?></td>
                            <td><?= htmlspecialchars($resposta['id_pergunta']) ?></td>
                            <td><?= htmlspecialchars($resposta['avaliacao']) ?></td>
                            <td><?= htmlspecialchars($resposta['feedback']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Nenhuma resposta encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
