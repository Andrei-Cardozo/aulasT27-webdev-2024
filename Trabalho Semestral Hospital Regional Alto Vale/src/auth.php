<?php
$conteudoHTML = <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação</title>
    <link rel="stylesheet" href="../Public/css/styleAuth.css">
</head>
<body>
<div class="wrapper">
        <div class="container">
            <form action="login.php" method="post">
                <h1>Entrar</h1>
                <div class="input-box">
                    <input type="text" placeholder="Nome de usuário" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Senha" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Lembrar de mim</label>
                    <a href="#">Não lembra a senha?</a>
                </div>
                <button type="submit" class="btn">Entrar</button>
                <div class="register-link">
                    <p>Não tem uma conta? <a href="#">Crie uma conta aqui!</a> </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
HTML;

echo $conteudoHTML;
?>