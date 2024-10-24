<?php
// Iniciar a sessão
session_start();

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Definir as credenciais corretas
    $correct_username = 'admin';
    $correct_password = 'adminHRAV!';

    // Obter o nome de usuário e a senha do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar se as credenciais estão corretas
    if ($username === $correct_username && $password === $correct_password) {
        // Configurar a sessão de login
        $_SESSION['logged_in'] = true;
        $_SESSION['last_activity'] = time(); // Iniciar o tempo da sessão

        // Redirecionar para admin.php
        header('Location: ../public/admin.php');
        exit();
    } else {
        // Se as credenciais forem incorretas
        $error = urlencode('Credenciais incorretas. Tente novamente.');
        header("Location: ../public/login.php?error=$error");
        exit();
    }
} else {
    // Se o acesso for direto a auth.php, redirecionar para a página de login
    header('Location: ../public/login.php');
    exit();
}
