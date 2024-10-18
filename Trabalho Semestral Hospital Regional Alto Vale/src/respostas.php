<?php
class Respostas {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Função para listar respostas
    public function listarRespostas() {
        $sql = 'SELECT respostas.*, perguntas.texto AS pergunta_texto 
                FROM respostas 
                JOIN perguntas ON respostas.id_pergunta = perguntas.id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função para adicionar nova resposta
    public function adicionarResposta($id_pergunta, $avaliacao, $feedback = null) {
        $sql = 'INSERT INTO respostas (id_pergunta, avaliacao, feedback) 
                VALUES (:id_pergunta, :avaliacao, :feedback)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_pergunta', $id_pergunta);
        $stmt->bindParam(':avaliacao', $avaliacao);
        $stmt->bindParam(':feedback', $feedback);
        return $stmt->execute();
    }

    // Função para editar resposta
    public function editarResposta($id, $avaliacao, $feedback = null) {
        $sql = 'UPDATE respostas SET avaliacao = :avaliacao, feedback = :feedback WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':avaliacao', $avaliacao);
        $stmt->bindParam(':feedback', $feedback);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Função para deletar resposta
    public function deletarResposta($id) {
        $sql = 'DELETE FROM respostas WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Função para listar respostas de uma pergunta específica
    public function listarRespostasPorPergunta($id_pergunta) {
        $sql = 'SELECT * FROM respostas WHERE id_pergunta = :id_pergunta';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_pergunta', $id_pergunta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
