<?php
session_start(); // Inicia a sessão
require_once '../src/funcoes.php'; 

$db = getConnection(); 

if (!$db) {
    die("Erro ao conectar com o banco de dados.");
}

try {
    // Busca todos os setores
    $setores = $db->query("SELECT * FROM setores")->fetchAll(PDO::FETCH_ASSOC);
    
    // Busca apenas tablets ativos
    $sqlTabletsAtivos = "SELECT * FROM tablets WHERE status = 'ativo'";
    $stmt = $db->query($sqlTabletsAtivos);
    $tabletsAtivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
}

// Inicializa as variáveis como nulas
$tablet_id = null;
$setor_id = null;
$perguntas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura de dados do formulário
    $tablet_id = $_POST['tablet'] ?? null;
    $setor_id = $_POST['setor_id'] ?? null;

    if ($tablet_id === null || $setor_id === null) {
        die("Dados incompletos, por favor selecione um tablet e um setor.");
    }

    // Armazena o setor_id na sessão
    $_SESSION['setor_id'] = $setor_id;

    // Redireciona para a página de loading após a confirmação
    header("Location: loading.php?tablet_id={$tablet_id}&setor_id={$setor_id}");
    exit();
}

// Consulta para obter as perguntas do setor, se o setor_id estiver definido
if ($setor_id) {
    $perguntasDoSetor = $db->prepare("SELECT * FROM perguntas WHERE setor_id = :setor_id AND ativo = 1");
    $perguntasDoSetor->bindParam(':setor_id', $setor_id, PDO::PARAM_INT);
    $perguntasDoSetor->execute();
    $perguntas = $perguntasDoSetor->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Tablet no Setor</title>
    <link rel="stylesheet" href="../public/css/stylepreConfSetTablet.css">
    <script>
    function abrirModal(tabletNome, setorNome) {
        document.getElementById('modal-tablet').innerText = tabletNome;
        document.getElementById('modal-setor').innerText = setorNome;
        document.getElementById('modal-confirmacao').style.display = 'flex';
    }

    function fecharModal() {
        document.getElementById('modal-confirmacao').style.display = 'none';
    }

    function confirmarEscolha() {
        fecharModal();
        document.getElementById('formId').submit();
    }

    document.addEventListener("DOMContentLoaded", function() {
        fecharModal();
    });
    </script>
</head>
<body>
    <div class="container">
        <h1>Configurar o Setor para o Tablet</h1>
        
        <?php if (empty($tabletsAtivos) && empty($setores)): ?>
            <p>Não há tablets ou setores cadastrados. Por favor, aguarde o cadastramento.</p>
        <?php elseif (empty($tabletsAtivos)): ?>
            <p>Não há tablets cadastrados. Por favor, aguarde o cadastramento.</p>
        <?php elseif (empty($setores)): ?>
            <p>Não há setores cadastrados. Por favor, aguarde o cadastramento.</p>
        <?php else: ?>
            <form method="POST" id="formId">
                <label for="tablet">Escolha o Tablet:</label>
                <select name="tablet" id="tablet" required>
                    <?php foreach ($tabletsAtivos as $tablet): ?>
                        <option value="<?= htmlspecialchars($tablet['id']) ?>"><?= htmlspecialchars($tablet['nome']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="setor_id">Escolha o Setor:</label>
                <select name="setor_id" id="setor_id" required>
                    <?php foreach ($setores as $setor): ?>
                        <option value="<?= htmlspecialchars($setor['id']) ?>"><?= htmlspecialchars($setor['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" onclick="abrirModal(document.getElementById('tablet').options[document.getElementById('tablet').selectedIndex].text, document.getElementById('setor_id').options[document.getElementById('setor_id').selectedIndex].text)">Confirmar Setor</button>
            </form>
        <?php endif; ?>
    </div>

    <div id="modal-confirmacao" class="modal">
        <div class="modal-content">
            <p>Você selecionou o setor: <strong id="modal-setor"></strong> para o tablet: <strong id="modal-tablet"></strong>.</p>
            <p>Confirma esta escolha?</p>
            <button onclick="confirmarEscolha()" class="btn">Sim</button>
            <button onclick="fecharModal()" class="btn-danger">Não</button>
        </div>
    </div>
</body>
</html>
