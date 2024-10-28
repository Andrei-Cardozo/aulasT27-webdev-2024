<?php
session_start(); // Inicia a sessão
require_once '../src/funcoes.php'; 

$db = getConnection(); 

if (!$db) {
    die("Erro ao conectar com o banco de dados.");
}

try {
    $setores = $db->query("SELECT * FROM setores")->fetchAll(PDO::FETCH_ASSOC);
    
    // Alteração: apenas tablets ativos
    $sqlTabletsAtivos = "SELECT * FROM tablets WHERE status = 'ativo'";
    $stmt = $db->query($sqlTabletsAtivos);
    $tabletsAtivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
}

// Inicializa as variáveis como nulas
$tablet_id = null;
$setor_id = null;

// Captura de dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tablet_id = $_POST['tablet'] ?? null; // Capture o ID do tablet
    $setor_id = $_POST['setor_id'] ?? null; // Capture o ID do setor

    if ($tablet_id === null || $setor_id === null) {
        die("Dados incompletos, por favor selecione um tablet e um setor.");
    }

    // Armazena o setor_id na sessão
    $_SESSION['setor_id'] = $setor_id; // Certifique-se de que setor_id é um número válido

    // Redireciona para a página de loading após a confirmação
    header("Location: loading.php?tablet_id={$tablet_id}&setor_id={$setor_id}");
    exit();
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
    // Abre o modal de confirmação e centraliza o conteúdo
    function abrirModal(tabletNome, setorNome) {
        document.getElementById('modal-tablet').innerText = tabletNome;
        document.getElementById('modal-setor').innerText = setorNome;
        const modal = document.getElementById('modal-confirmacao');
        modal.style.display = 'flex';  // Modal visível e centralizado
    }

    // Fecha o modal de confirmação
    function fecharModal() {
        document.getElementById('modal-confirmacao').style.display = 'none';
    }

    // Redireciona para a página de carregamento com confirmação de escolha
    function confirmarEscolha() {
        fecharModal();  // Garante que o modal está fechado
        document.getElementById('formId').submit(); // Submete o formulário
    }

    // Garante que o modal esteja oculto no carregamento da página
    document.addEventListener("DOMContentLoaded", function() {
        fecharModal();
    });
    </script>
</head>
<body>
    <div class="container">
        <h1>Configurar o Setor para o Tablet</h1>

        <!-- Formulário para selecionar Tablet e Setor -->
        <form method="POST" id="formId">
            <label for="tablet">Escolha o Tablet:</label>
            <select name="tablet" id="tablet" required>
                <?php foreach ($tabletsAtivos as $tablet): ?>
                    <option value="<?= $tablet['id'] ?>"><?= htmlspecialchars($tablet['nome']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="setor_id">Escolha o Setor:</label>
            <select name="setor_id" id="setor_id" required>
                <?php foreach ($setores as $setor): ?>
                    <option value="<?= $setor['id'] ?>"><?= htmlspecialchars($setor['nome']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" onclick="abrirModal(document.getElementById('tablet').options[document.getElementById('tablet').selectedIndex].text, document.getElementById('setor_id').options[document.getElementById('setor_id').selectedIndex].text)">Confirmar Setor</button>
        </form>

    </div>

    <!-- Modal de confirmação -->
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
