<?php
require_once '../../src/funcoes.php';
require_once '../../src/perguntas.php';

// Obtém a conexão com o banco de dados
$conn = getConnection();

// Instancia o objeto da classe Perguntas
$perguntasObj = new Perguntas($conn);

// Lida com adição de nova pergunta
if (isset($_POST['add_pergunta'])) {
    $novaPergunta = $_POST['nova_pergunta'];
    $perguntasObj->adicionarPergunta($novaPergunta);
    // Redireciona para a mesma página para evitar que o usuário veja o alerta novamente ao recarregar
    echo "<script>window.location.href = 'quests.php';</script>";
    exit();
}

// Lida com edição de uma pergunta
if (isset($_POST['edit_pergunta'])) {
    $id = $_POST['id'];
    $textoEditado = $_POST['texto_editado'];
    $perguntasObj->editarPergunta($id, $textoEditado);
    // Redireciona após edição
    echo "<script>window.location.href = 'quests.php';</script>";
    exit();
}

// Lida com a inativação de uma pergunta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_pergunta'])) {
    $id = $_POST['id']; // Obtém o ID da pergunta do formulário
    if ($perguntasObj->deletarPergunta($id)) {
        // Exibe uma mensagem de sucesso usando uma variável de sessão
        session_start();
        $_SESSION['mensagem'] = 'Pergunta marcada como inativa!';
    } else {
        // Exibe uma mensagem de erro usando uma variável de sessão
        session_start();
        $_SESSION['mensagem'] = 'Erro ao marcar a pergunta como inativa.';
    }
    
    // Redireciona para evitar a reenvio do formulário
    header("Location: quests.php");
    exit();
}

// Lida com reativação de uma pergunta
if (isset($_POST['reativar_pergunta'])) {
    $id = $_POST['id'];
    $perguntasObj->reativarPergunta($id);
    // Redireciona após reativação
    echo "<script>window.location.href = 'quests.php';</script>";
    exit();
}

// Lida com exclusão permanente de uma pergunta
if (isset($_POST['excluir_pergunta'])) {
    $id = $_POST['id'];
    $perguntasObj->excluirPerguntaPermanente($id);
    // Redireciona após exclusão permanente
    echo "<script>window.location.href = 'quests.php';</script>";
    exit();
}

// Obtém a lista de perguntas ativas
$perguntasAtivas = $perguntasObj->listarPerguntas();

// Obtém a lista de perguntas inativas
$perguntasInativas = $perguntasObj->listarPerguntasInativas();

// Verifica se existem perguntas inativas
if (empty($perguntasInativas)) {
    // Se não houver perguntas inativas, verifica se a tabela perguntas está vazia
    $sqlCheckEmpty = "SELECT COUNT(*) FROM perguntas;";
    $stmt = $conn->query($sqlCheckEmpty);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Se a tabela estiver vazia, reinicia o contador de IDs
        $sqlReset = "ALTER SEQUENCE perguntas_id_seq RESTART WITH 1;";
        $conn->exec($sqlReset); // Executa a instrução SQL para reiniciar a sequência
    }
}
    // Lida com a inativação de todas as perguntas ativas
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['inativar_todas_perguntas'])) {
            $perguntasObj->inativarTodasPerguntas();
            header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para a mesma página
            exit; // Encerra o script após o redirecionamento
        }

    // Lida com a exclusão permanente de todas as perguntas inativas
    if (isset($_POST['excluir_todas_perguntas'])) {
        $perguntasObj->excluirTodasPerguntasInativas();
        header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para a mesma página
        exit; // Encerra o script após o redirecionamento
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gerenciamento de Perguntas</title>
    <link rel="stylesheet" href="../../public/css/styleQuests.css">
</head>
<body>
<div class="container">
    <h1>Painel de Gerenciamento de Perguntas</h1>

    <!-- Formulário para Adicionar Pergunta -->
    <h2>Adicionar Nova Pergunta</h2>
    <form method="POST" action="">
        <input type="text" name="nova_pergunta" placeholder="Digite a nova pergunta" required>
        <button type="submit" name="add_pergunta">Adicionar</button>
    </form>

    <hr>

    <!-- Tabela de Perguntas -->
    <h2>Perguntas Ativas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pergunta</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($perguntasAtivas) && is_array($perguntasAtivas)) : ?>
                <?php foreach ($perguntasAtivas as $pergunta): ?>
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
                            <button type="submit" name="delete_pergunta" onclick="return confirm('Tem certeza que deseja inativar esta pergunta?')">Inativar</button>
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

    <h2>Perguntas Inativas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Pergunta</th>
            <th>Ações</th>
        </tr>
        <?php if (!empty($perguntasInativas)) : ?>
            <?php foreach ($perguntasInativas as $pergunta): ?>
            <tr>
                <td><?php echo $pergunta['id']; ?></td>
                <td><?php echo $pergunta['texto']; ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $pergunta['id']; ?>">
                        <button type="submit" name="reativar_pergunta">Reativar</button>
                    </form>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $pergunta['id']; ?>">
                        <button type="submit" name="excluir_pergunta" onclick="return confirm('Tem certeza de que deseja excluir esta pergunta permanentemente?');">Excluir Permanentemente</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Nenhuma pergunta inativa encontrada.</td>
            </tr>
        <?php endif; ?>
    </table>

        <!-- Adicionar Botões para Ações em Massa -->
    <h2>Ações em Massa</h2>
    <form method="POST" action="" style="display: inline;">
        <button type="submit" name="inativar_todas_perguntas" onclick="return confirm('Tem certeza que deseja inativar todas as perguntas ativas?');">Inativar Todas as Perguntas</button>
    </form>

    <form method="POST" action="" style="display: inline;">
        <button type="submit" name="excluir_todas_perguntas" onclick="return confirm('Tem certeza que deseja excluir permanentemente todas as perguntas inativas?');">Excluir Todas as Perguntas Inativas</button>
    </form>
</div>

</body>
</html>