<?php
// Configurações de banco de dados 
define('DB_HOST', 'localhost'); // Endereço do servidor de banco de dados 
define('DB_PORT', '5432'); // Porta do banco de dados 
define('DB_NAME', 'HospitalDB'); // Nome do banco de dados 
define('DB_USER', 'postgres'); // Nome de usuário do banco de dados 
define('DB_PASS', 'postgres'); // Senha do banco de dados

// Configurações de segurança 
define('HASH_ALGO', 'sha256');

// Outros parâmetros de configuração 
define('DEBUG_MODE', false);

// Configuração da exibição de erros no modo de depuração 
if (DEBUG_MODE) { ini_set('display_errors', 1); 
    ini_set('display_startup_errors', 1); 
    error_reporting(E_ALL); }
?>