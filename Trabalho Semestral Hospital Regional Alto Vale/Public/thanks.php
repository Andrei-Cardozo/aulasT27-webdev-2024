<?php
require_once '../src/funcoes.php'; // Inclui o arquivo de funções

$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $conn) {
    $id_perguntas = $_POST['id_pergunta'];
    $avaliacoes = $_POST['avaliacao'];
    $feedbacks = $_POST['feedback'];

    // Insere as respostas no banco de dados
    for ($i = 0; $i < count($id_perguntas); $i++) {
        $id_pergunta = $id_perguntas[$i];
        $avaliacao = $avaliacoes[$i];
        $feedback = !empty($feedbacks[$i]) ? $feedbacks[$i] : null;

        $sql = 'INSERT INTO respostas (id_pergunta, avaliacao, feedback) VALUES (:id_pergunta, :avaliacao, :feedback)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_pergunta', $id_pergunta);
        $stmt->bindParam(':avaliacao', $avaliacao);
        $stmt->bindParam(':feedback', $feedback);
        $stmt->execute();
    }

    echo 'Respostas enviadas com sucesso!';
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
            window.location.href = 'loading.php';
        }, 2500); // 2500 milissegundos = 2,5 segundos
    </script>
</head>
<body>
    <h1>Obrigado pelo seu feedback!</h1>
    <p>Você será redirecionado para a página inicial em alguns segundos...</p>
</body>
</html>
