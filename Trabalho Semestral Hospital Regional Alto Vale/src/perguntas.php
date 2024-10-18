<?php
class Perguntas {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Função para listar perguntas
    public function listarPerguntas() {
        $sql = 'SELECT * FROM perguntas';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função para adicionar nova pergunta
    public function adicionarPergunta($texto) {
        $sql = 'INSERT INTO perguntas (texto) VALUES (:texto)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':texto', $texto);
        return $stmt->execute();
    }

    // Função para editar pergunta
    public function editarPergunta($id, $novoTexto) {
        $sql = 'UPDATE perguntas SET texto = :texto WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':texto', $novoTexto);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Função para deletar pergunta
    public function deletarPergunta($id) {
        $sql = 'DELETE FROM perguntas WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
