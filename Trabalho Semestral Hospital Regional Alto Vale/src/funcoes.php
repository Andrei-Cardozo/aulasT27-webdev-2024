<?php

// Função para listar perguntas
function listarPerguntas() {
    $conn = getConnection();
    if ($conn) {
        $sql = 'SELECT * FROM perguntas';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}

// Função para adicionar nova pergunta (usada no admin)
function adicionarPergunta($texto) {
    $conn = getConnection();
    if ($conn) {
        $sql = 'INSERT INTO perguntas (texto) VALUES (:texto)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':texto', $texto);
        return $stmt->execute();
    }
    return false;
}

function listarSetores() {
    $conn = getConnection(); // Obter a conexão com o banco de dados
    $sql = "SELECT * FROM setores WHERE ativo = TRUE"; // Filtrar setores ativos
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os setores ativos
}

function obterPerguntasAtivas($conn, $setor_id) {
    if ($setor_id === null) {
        return []; // Retorna um array vazio se setor_id não for válido
    }

    // Verifique se $setor_id é um inteiro
    $setor_id = (int)$setor_id;

    // Atualize a consulta para usar TRUE em vez de 1
    $sql = "SELECT * FROM perguntas WHERE ativo = TRUE AND setor_id = :setor_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':setor_id', $setor_id, PDO::PARAM_INT); // Assegure-se de que seja tratado como inteiro
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>