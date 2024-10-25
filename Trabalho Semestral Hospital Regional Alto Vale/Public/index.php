<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecione o local</title>
</head>
<body>
    <!-- codigo para a seleção de tablets/dispositivos -->

<div class="container">
        <h1>Painel de Seleção de Tablets</h1>

        <!-- Escolher a ala em que se encontra o dispositivo -->
        <h2>Por favor, selecione a ala médica que este dispositivo ocupará</h2>
        <form method="POST" action=""> <!-- Alterar daqui pra baixo -->
            <input type="text" name="nova_pergunta" placeholder="Digite a nova pergunta" required>
            <button type="submit" name="add_pergunta">Adicionar</button>
        </form>

        <hr>

        <!-- Tabela de Perguntas -->
        <h2>Gerenciar Perguntas</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pergunta</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($perguntas) && is_array($perguntas)) : ?>
                    <?php foreach ($perguntas as $pergunta): ?>
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
                                <button type="submit" name="delete_pergunta" onclick="return confirm('Tem certeza que deseja excluir esta pergunta?')">Excluir</button>
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
    </div>
</body>
</html>