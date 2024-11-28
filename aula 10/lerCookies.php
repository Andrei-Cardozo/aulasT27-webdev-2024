<?php
// Verifica se os cookies 'usuario' e 'inicio' existem
if (isset($_COOKIE['usuario']) && isset($_COOKIE['inicio'])) {
    echo "Usuário: " . $_COOKIE['usuario'] . "<br>";
    echo "Data/hora de início da sessão: " . $_COOKIE['inicio'] . "<br>";
} else {
    echo "Os cookies não estão definidos ou expiraram.";
}
?>