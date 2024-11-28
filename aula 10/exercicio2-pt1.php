<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o campo 'login' foi enviado e não está vazio
    if (isset($_POST['login']) && !empty($_POST['login'])) {
        // Define os cookies 'usuario' e 'inicio' com expiração em 5 minutos
        setcookie("usuario", $_POST['login'], time() + (60 * 5), "/");
        setcookie("inicio", date("Y-m-d H:i:s"), time() + (60 * 5), "/");
        echo "Cookies definidos com sucesso! <br>";
        echo "Usuário: " . $_POST['login'] . "<br>";
        echo "Data/hora de início: " . date("Y-m-d H:i:s") . "<br>";
    } else {
        echo "Erro: O campo 'login' não foi enviado.";
    }
} else {
    echo "Acesso inválido.";
}
?>