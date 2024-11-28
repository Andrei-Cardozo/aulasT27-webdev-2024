<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se 'login' e 'senha' foram passados
    if (isset($_POST['login']) && isset($_POST['senha'])) {
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['senha'] = $_POST['senha'];
        $_SESSION['inicio'] = date("Y-m-d H:i:s");
        echo "Sessão iniciada com sucesso!";
    } else {
        echo "Login e/ou senha não foram enviados.";
    }
}
?>