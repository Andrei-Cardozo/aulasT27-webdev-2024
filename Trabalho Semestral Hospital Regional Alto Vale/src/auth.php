<?php
require_once '../src/db.php'; // Certifique-se de que o caminho está correto
require_once '../config.php'; // Inclui o arquivo de configuração
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = getConnection();
    if (!$conn) {
        die("Erro ao conectar com o banco de dados.");
    }

    // Consultar o banco de dados para o usuário fornecido
    $sql = "SELECT * FROM usuarios_admin WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o usuário existe e se a senha está correta
    if ($user && hash(HASH_ALGO, $password) === $user['password_hash']) {
        // Configurar a sessão de login
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
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
?>
