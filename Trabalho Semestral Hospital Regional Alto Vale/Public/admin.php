<?php
require_once '../src/db.php';
require_once '../src/perguntas.php';
require_once '../src/funcoes.php';

//exibir as perguntas cadastradas
$perguntas = listarPerguntas();

// Obtém a conexão com o banco de dados
$conn = getConnection();

// Instancia o objeto da classe Perguntas
$perguntasObj = new Perguntas($conn);

// Lida com adição de nova pergunta
if (isset($_POST['add_pergunta'])) {
    $novaPergunta = $_POST['nova_pergunta'];
    $perguntasObj->adicionarPergunta($novaPergunta);
}

// Lida com edição de uma pergunta
if (isset($_POST['edit_pergunta'])) {
    $id = $_POST['id'];
    $textoEditado = $_POST['texto_editado'];
    $perguntasObj->editarPergunta($id, $textoEditado);
}

// Lida com exclusão de uma pergunta
if (isset($_POST['delete_pergunta'])) {
    $id = $_POST['id'];
    $perguntasObj->deletarPergunta($id);
}

// Obtém a lista de perguntas
$perguntas = $perguntasObj->listarPerguntas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../public/css/styleAdmin.css">
</head>
<body>
<!--    Salvar esse código para reutilizar logo mais. Alterar o código daqui para baixo     -->

<div class="sidebar">
        <div class="container">
        <div class="logo">
            <!-- Colocar admin aqui -->
        </div>

        <ul class="menu">
            <li><a href="">
                <i class="fas fa-home"></i>
                <span>Menu</span>
                </span>
            </a></li>

            <li><a href="">
                <i class="fa-solid fa-bell"></i>
                <span>Notificações</span>
            </a></li>

            <li><a href="">
                <i class="fa-solid fa-gear"></i>
                <span>Configurações</span>
            </a></li>
            
            <li><a href="">
                <i class="fas fa-globe"></i>
                <span>Site HRAV</span>
            </a></li>

        </ul>
    </div>

    <div class="logout">
        <i class="fas fa-sign-out-alt"></i>
        <span class="link-text">Sair</span>
    </div>

    </div>
    <div class="menu-btn">
        <i class="fa-solid fa-bars"></i>
    </div>

    <script src="js/admin.js"></script>

</body>
</html>
