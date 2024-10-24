<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação</title>
    <link rel="stylesheet" href="../public/css/styleLogin.css">
</head>
<body>
<div class="wrapper">
    <div class="container">
        <form action="../src/auth.php" method="post">
            <h1>Entrar</h1>
            <div class="input-box">
                <input type="text" name="username" id="username" placeholder="Nome de usuário" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Senha" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Entrar</button>
        </form>

        <!-- Exibir mensagem de erro se houver -->
        <?php if (isset($_GET['error'])): ?>
                <p style="color: red; margin-top: 10px;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
    </div>
</div>
</body>
</html>
