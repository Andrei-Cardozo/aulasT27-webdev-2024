<?php
$conteudoHTML = <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <link rel="stylesheet" href="css/styleLoading.css">
</head>
<body>
    <div id="loading-screen">
        <div class="spinner"></div>
        <p>Responda nosso formulário anônimamente! Sua opinião nos ajuda a melhorar continuamente.</p>
    </div>

    <script>
        // Função que redireciona para index.php após 2 segundos
        setTimeout(function() {
            window.location.href = 'forms.php';
        }, 2000); // 2000 milissegundos = 2 segundos
    </script>
</body>
</html>
HTML;

echo $conteudoHTML;
?>