<?php
$conteudoHTML = <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <link rel="stylesheet" href="css/styleindex.css">
</head>
<body>
    <div id="loading-screen">
        <div class="spinner"></div>
        <p>Toque na tela e responda nosso formulário anonimamente! Sua opinião nos ajuda a melhorar continuamente.</p>
    </div>

    <script src="js/loading.js"></script>
</body>
</html>
HTML;

echo $conteudoHTML;
?>