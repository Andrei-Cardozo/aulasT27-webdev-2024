<?php
require_once '../src/funcoes.php'; // Inclui o arquivo de funções
require_once '../src/db.php'; 

$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn) {
    // Inicializa arrays para os dados processados
    $id_perguntas = filter_input(INPUT_POST, 'id_pergunta', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?? [];
    $avaliacoes = filter_input(INPUT_POST, 'avaliacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?? [];
    $feedbacks = filter_input(INPUT_POST, 'feedback', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?? [];
    $setor_id = filter_input(INPUT_POST, 'setor_id', FILTER_VALIDATE_INT);

    // Verifica se o setor_id é válido
    if (!$setor_id || $setor_id <= 0) {
        die("Setor ID inválido.");
    }

    // Valida as respostas antes de inserir no banco
    for ($i = 0; $i < count($id_perguntas); $i++) {
        $id_pergunta = filter_var($id_perguntas[$i], FILTER_VALIDATE_INT);
        $avaliacao = filter_var($avaliacoes[$i], FILTER_VALIDATE_INT);
        $feedback = filter_var($feedbacks[$i] ?? null, FILTER_SANITIZE_STRING);

        // Ignora entradas inválidas
        if (!$id_pergunta || $avaliacao === false || $avaliacao < 0 || $avaliacao > 10) {
            continue;
        }

        // Insere as respostas no banco de dados
        $sql = 'INSERT INTO respostas (id_pergunta, avaliacao, feedback, setor_id) 
                VALUES (:id_pergunta, :avaliacao, :feedback, :setor_id)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_pergunta', $id_pergunta, PDO::PARAM_INT);
        $stmt->bindParam(':avaliacao', $avaliacao, PDO::PARAM_INT);
        $stmt->bindParam(':feedback', $feedback, PDO::PARAM_STR);
        $stmt->bindParam(':setor_id', $setor_id, PDO::PARAM_INT);
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
        // Função que redireciona para loading.php após 2,5 segundos
        setTimeout(function() {
            window.location.href = 'loading.php';
        }, 2500);
    </script>
</head>
<body>
    <h1>Obrigado pelo seu feedback!</h1>
    <p>Você será redirecionado para a página inicial em alguns segundos...</p>
</body>
</html>
