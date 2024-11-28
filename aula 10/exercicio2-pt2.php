<?php
if(!isset($_COOKIE['usuario']) || !isset($_COOKIE['inicio'])) {
    echo "Dados da sessão perdidos.";
} else {
    echo "Usuário: " . $_COOKIE['usuario'];
    echo "Início: " . $_COOKIE['inicio'];
}
?>