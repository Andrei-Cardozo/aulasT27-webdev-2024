<?php
// public/admin.php
include_once '../src/db.php';
include_once '../src/perguntas.php';

$db = new Database();
$conn = $db->getConnection();

$perguntas = new Perguntas($conn);
$todasPerguntas = $perguntas->listarPerguntas();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Painel Administrativo</h1>
    <a href="adicionar.php">Adicionar Nova Pergunta</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pergunta</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todasPerguntas as $pergunta): ?>
                <tr>
                    <td><?= $pergunta['id']; ?></td>
                    <td><?= $pergunta['texto']; ?></td>
                    <td>
                        <a href="editar.php?id=<?= $pergunta['id']; ?>">Editar</a> |
                        <a href="deletar.php?id=<?= $pergunta['id']; ?>">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
