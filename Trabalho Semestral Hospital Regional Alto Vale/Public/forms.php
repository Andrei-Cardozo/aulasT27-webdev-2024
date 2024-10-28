<?php
session_start(); // Certifique-se de que isso está aqui antes de qualquer outra coisa
require_once '../src/funcoes.php'; // Conectar com o Banco de Dados pelo funcoes.php

// Conectar ao banco de dados
$conn = getConnection(); // Certifique-se de que esta função existe em funcoes.php para retornar a conexão

// Captura o setor_id da sessão
$setor_id = $_SESSION['setor_id'] ?? null; // Tenta obter o setor_id

if ($setor_id === null) {
    // Redirecionar se setor_id não estiver definido
    header("Location: preConfSetTablet.php");
    exit;
}

// Obter as perguntas ativas
$perguntasAtivas = obterPerguntasAtivas($conn, $setor_id); // Chama a função que retorna as perguntas ativas
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Avaliação</title>
    <link rel="stylesheet" href="css/styleForms.css">
    <style>
        /* Seu CSS existente */
        .rating-buttons {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .rating-button {
            margin: 0 5px;
            padding: 10px 15px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: transform 0.3s, filter 0.3s;
        }
        .rating-button:hover {
            transform: scale(1.1);
        }
        .rating-button.selected {
            border: 2px solid #34495e;
            transform: scale(1.3);
        }
        .rating-button.blurred {
            filter: blur(2px);
            opacity: 0.6;
        }
        button[type="submit"] {
            background: linear-gradient(to right, #002244, #0056a3);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
    </style>
</head>
<body>
    <h2>Formulário de Avaliação</h2>
    
    <form action="thanks.php" method="post" onsubmit="return validateForm()">
        <input type="hidden" name="setor_id" value="<?= $setor_id ?>">

        <?php if (!empty($perguntasAtivas)): ?>
            <?php foreach ($perguntasAtivas as $pergunta): ?>
                <section>
                    <p><?= htmlspecialchars($pergunta['texto']) ?></p>
                    <input type="hidden" name="id_pergunta[]" value="<?= $pergunta['id'] ?>">
                    
                    <div class="rating-buttons">
                        <?php
                        // Cores do degradê do vermelho ao verde
                        $cores = [
                            '#7A0000', '#9F1919', '#B23232', '#C64C4C',
                            '#D66B1B', '#D6A51B', '#B3C32B', '#66C32B',
                            '#33C32B', '#007A00', '#007A00',
                        ];
                        ?>
                        <?php for ($i = 0; $i <= 10; $i++): ?>
                            <button type="button" class="rating-button" style="background-color: <?= $cores[$i] ?>;" data-value="<?= $i ?>" onclick="selectRating(this, <?= $pergunta['id'] ?>)"><?= $i ?></button>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="avaliacao[]" id="avaliacao_<?= $pergunta['id'] ?>" required>
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
    <script>
    function selectRating(button, perguntaId) {
        const buttons = document.querySelectorAll(`.rating-button`);
        const isSelected = button.classList.contains('selected');

        if (isSelected) {
            button.classList.remove('selected');
            button.classList.add('blurred');
            button.style.transform = 'scale(1)';
            button.style.border = 'none';

            document.getElementById(`avaliacao_${perguntaId}`).value = '';

            const anySelected = Array.from(buttons).some(btn => btn.classList.contains('selected'));
            if (!anySelected) {
                buttons.forEach(btn => {
                    btn.classList.remove('blurred');
                });
            }
        } else {
            buttons.forEach(btn => {
                btn.classList.remove('selected');
                btn.classList.add('blurred');
                btn.style.transform = 'scale(1)';
                btn.style.border = 'none';
            });

            button.classList.add('selected');
            button.classList.remove('blurred');
            button.style.transform = 'scale(1.3)';
            button.style.border = '2px solid #ffc107';

            const ratingValue = button.getAttribute('data-value');
            document.getElementById(`avaliacao_${perguntaId}`).value = ratingValue;
        }
    }

    function validateForm() {
        const avaliacaoFields = document.querySelectorAll('input[name="avaliacao[]"]');
        for (let field of avaliacaoFields) {
            if (!field.value) {
                alert("Por favor, selecione uma nota para todas as perguntas.");
                return false;
            }
        }
        return true;
    }
    </script>
</body>
</html>
