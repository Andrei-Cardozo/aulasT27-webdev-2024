<?php
$conteudoHTML = <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Avaliação</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <section>
        <h2>Como você avaliaria a qualidade do atendimento recebido durante sua visita ao Hospital Regional?</h2>
    </section>

    <div id="scale-container">
        <!-- Escala de avaliação -->
        <div class="scale-number" style="background-color: #FF8080;">0</div>
        <div class="scale-number" style="background-color: #FF9999;">1</div>
        <div class="scale-number" style="background-color: #FFB2B2;">2</div>
        <div class="scale-number" style="background-color: #FFB2B2;">3</div>
        <div class="scale-number" style="background-color: #FFCCCC;">4</div>
        <div class="scale-number" style="background-color: #F2F2F2;">5</div>
        <div class="scale-number" style="background-color: #FFFFB2;">6</div>
        <div class="scale-number" style="background-color: #D4FFB2;">7</div>
        <div class="scale-number" style="background-color: #B2FFB2;">8</div>
        <div class="scale-number" style="background-color: #B2FFB2;">9</div>
        <div class="scale-number" style="background-color: #99FF99;">10</div>
    </div>

    <div class="feedback-area">
        <textarea placeholder="Feedback adicional (opcional)" rows="4" cols="50"></textarea>
    </div>

    <button id="submit-button">Enviar Avaliação</button>

    <footer>
        <p>Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
    </footer>

    <script src="js/scaleAnimation.js"></script>
</body>
</html>
HTML;

echo $conteudoHTML;
?>
