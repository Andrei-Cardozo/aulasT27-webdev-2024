<?php
session_start(); // Inicia a sessão
require_once '../src/funcoes.php'; 

// Conecta ao banco de dados
$db = getConnection(); 

if (!$db) {
    die("Erro ao conectar com o banco de dados.");
}

// Armazena o setor na sessão
if (isset($_GET['setor'])) {
    $_SESSION['setor_selecionado'] = $_GET['setor'];
}

// Você pode retornar um status de sucesso
echo json_encode(['status' => 'success']);

$tablet_id = $_GET['tablet_id'];
$setor = $_GET['setor']; // ou $_GET['setor_id'] se você tiver uma variável id específica

// Aqui você deve buscar o ID do setor no banco de dados, se necessário.
// Vamos assumir que você já tem o setor_id definido corretamente.
$_SESSION['setor_id'] = $setor_id; // Certifique-se de que setor_id é um número válido

?>
