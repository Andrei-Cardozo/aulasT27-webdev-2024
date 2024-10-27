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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/styleQuests.css">
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
            right: 10px;
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
    margin-top: -30px;
    margin-right: 10px;
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
    <h1>Painel de Gerenciamento de Perguntas</h1>

    <!-- Formulário para Adicionar Pergunta -->
    <h2>Adicionar Nova Pergunta</h2>
    <form method="POST" action="">
        <input type="text" name="nova_pergunta" placeholder="Digite a nova pergunta" required>
        <button type="submit" name="add_pergunta">Adicionar</button>
    </form>

    <hr>

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
                    <!-- Botão para abrir o modal de edição -->
                    <button onclick="abrirModal('<?= $pergunta['id'] ?>', '<?= $pergunta['texto'] ?>')" class="btn btn-success">Editar</button>

                    <!-- Formulário para Inativar Pergunta -->
                    <form method="POST" action="" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?= $pergunta['id'] ?>">
                        <button type="submit" name="delete_pergunta" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja inativar esta pergunta?')">Inativar</button>
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

<!-- Modal de edição de pergunta -->
<div id="modalEditar" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="fecharModal()">&times;</span>
        <h2>Editar Pergunta</h2>
        <form method="POST" id="formEditarPergunta" action="">
            <input type="hidden" id="idPergunta" name="id" value="">
            <label for="textoPergunta">Pergunta:</label>
            <input type="text" id="textoPergunta" name="texto_editado" required>
            <button type="submit" name="edit_pergunta" class="btn btn-success">Salvar</button>
        </form>
    </div>
</div>

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
                        <button type="submit" name="excluir_pergunta" class="btn btn-danger" onclick="return confirm('Tem certeza de que deseja excluir esta pergunta permanentemente?');">Excluir Permanentemente</button>
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
        <button type="submit" name="inativar_todas_perguntas" class="btn btn-alert" onclick="return confirm('Tem certeza que deseja inativar todas as perguntas ativas?');">Inativar Todas as Perguntas</button>
    </form>

    <form method="POST" action="" style="display: inline;">
        <button type="submit" name="excluir_todas_perguntas" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir permanentemente todas as perguntas inativas?');">Excluir Todas as Perguntas Inativas</button>
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
    
<script src="../../public/js/quests.js"></script>
</body>
</html>