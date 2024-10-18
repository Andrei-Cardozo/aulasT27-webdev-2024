<?php
require_once '../src/db.php'; // Inclui o arquivo de conexão com o banco de dados

// Verifica se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $avaliacao = $_POST['avaliacao'] ?? null;
    $feedback = $_POST['feedback'] ?? null;

    if (!is_null($avaliacao)) {
        try {
            // Insere a resposta no banco de dados
            $sql = "INSERT INTO respostas (id_pergunta, avaliacao, feedback) VALUES (1, :avaliacao, :feedback)"; // id_pergunta definido para 1 por simplicidade, ajuste conforme necessário
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':avaliacao', $avaliacao);
            $stmt->bindParam(':feedback', $feedback);
            $stmt->execute();

            echo "Obrigado por sua avaliação!";
        } catch (PDOException $e) {
            echo "Erro ao salvar a avaliação: " . $e->getMessage();
        }
    } else {
        echo "Por favor, selecione uma avaliação.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obrigado!</title>
    <link rel="stylesheet" href="css/styleThanks.css">
    <script>
        // Função que redireciona para index.php após 2 segundos
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 2500); // 2500 milissegundos = 2,5 segundos
    </script>
</head>
<body>
    <h1>Obrigado pelo seu feedback!</h1>
    <p>Você será redirecionado para a página inicial em alguns segundos...</p>
</body>
</html>
