<?php
require_once '../src/funcoes.php'; // Conectar com o Banco de Dados pelo funcoes.php

// Obter as perguntas do banco de dados
$perguntas = listarPerguntas();

// Obter os setores do banco de dados
$setores = listarSetores(); // Função para listar setores

// Captura o setor_id da sessão
session_start();
$setor_id = $_SESSION['setor_id'] ?? null;

if ($setor_id === null) {
    // Redirecionar se setor_id não estiver definido
    header("Location: preConfSetTablet.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Avaliação</title>
    <link rel="stylesheet" href="css/styleForms.css">
</head>
<body>
    <h2>Formulário de Avaliação</h2>
    
    <form action="thanks.php" method="post">
        <input type="hidden" name="setor_id" value="<?= $setor_id ?>"> <!-- Campo oculto para setor_id -->

        <?php if (!empty($perguntas)): ?>
            <?php foreach ($perguntas as $pergunta): ?>
                <section>
                    <p><?= htmlspecialchars($pergunta['texto']) ?></p>
                    <input type="hidden" name="id_pergunta[]" value="<?= $pergunta['id'] ?>">
                    <label for="avaliacao_<?= $pergunta['id'] ?>">Avaliação (0-10):</label>
                    <input type="number" name="avaliacao[]" id="avaliacao_<?= $pergunta['id'] ?>" min="0" max="10" required>
                    <br>
                    <label for="feedback_<?= $pergunta['id'] ?>">Feedback (opcional):</label>
                    <textarea name="feedback[]" id="feedback_<?= $pergunta['id'] ?>"></textarea>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma pergunta cadastrada no momento.</p>
        <?php endif; ?>
        <button type="submit">Enviar Avaliação</button>
    </form>

    <footer>
        <p>Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
    </footer>

    <script src="js/scaleAnimation.js"></script>
</body>
</html>
