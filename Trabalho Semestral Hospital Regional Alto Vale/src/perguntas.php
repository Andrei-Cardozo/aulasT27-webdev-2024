<?php
class Perguntas {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function adicionarPergunta($texto, $setor_id) {
        $sql = "INSERT INTO perguntas (texto, setor_id, status) VALUES (:texto, :setor_id, true)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':texto', $texto);
        $stmt->bindParam(':setor_id', $setor_id);
        return $stmt->execute();
    }    

    // Função para listar perguntas ativas
    public function listarPerguntas($setor_id = null) {
        $sql = "SELECT * FROM perguntas WHERE status = TRUE";
        if ($setor_id) {
            $sql .= " AND setor_id = :setor_id";
        }
        $stmt = $this->conn->prepare($sql);
        if ($setor_id) {
            $stmt->bindParam(':setor_id', $setor_id);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function listarSetores() {
        $sql = "SELECT id, nome FROM setores WHERE ativo = true"; // Certifique-se de que o campo 'ativo' está correto
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        echo "Tentativa de deletar pergunta com ID: $id"; // Debugging
        $sql = 'UPDATE perguntas SET ativo = FALSE WHERE id = :id';
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
        $sql = "UPDATE perguntas SET status = FALSE WHERE ativo = TRUE";
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
