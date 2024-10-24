<?php
class Perguntas {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Função para listar perguntas ativas
    public function listarPerguntas() {
        $sql = "SELECT * FROM perguntas WHERE status = TRUE ORDER BY id ASC"; // Perguntas ativas
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
        $sql = 'UPDATE perguntas SET status = FALSE WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Função para listar perguntas inativas
    public function listarPerguntasInativas() {
        $sql = "SELECT * FROM perguntas WHERE status = FALSE ORDER BY id ASC"; // Perguntas inativas
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Função para reativar perguntas
    public function reativarPergunta($id) {
        $sql = 'UPDATE perguntas SET status = TRUE WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    //Função para deletar permanentemente as perguntas
    public function excluirPerguntaPermanente($id) {
        $sql = 'DELETE FROM perguntas WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function inativarTodasPerguntas() {
        $sql = "UPDATE perguntas SET status = FALSE WHERE status = TRUE";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }

    public function excluirTodasPerguntasInativas() {
        $sql = "DELETE FROM perguntas WHERE status = FALSE";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
}
?>
