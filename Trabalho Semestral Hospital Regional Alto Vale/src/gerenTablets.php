<?php
class Tablets {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function adicionarTablet($nomeTablet) {
        $sql = "INSERT INTO tablets (nome) VALUES (:nome)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nomeTablet);
    
        try {
            $stmt->execute();
            return true; // Retorna true se a execução for bem-sucedida
        } catch (PDOException $e) {
            // Exibe a mensagem de erro
            echo "Erro ao adicionar tablet: " . $e->getMessage();
            return false; // Retorna false se houver um erro
        }
    }
    

    public function editarTablet($id, $nomeEditado) {
        $sql = "UPDATE tablets SET nome = :nome WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nomeEditado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deletarTablet($id) {
        $sql = "UPDATE tablets SET status = 'inativo' WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function reativarTablet($id) {
        $sql = "UPDATE tablets SET status = 'ativo' WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function excluirTabletPermanente($id) {
        $sql = "DELETE FROM tablets WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function listarTablets() {
        $sql = "SELECT * FROM tablets WHERE status = 'ativo'";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTabletsInativos() {
        $sql = "SELECT * FROM tablets WHERE status = 'inativo'";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inativarTodosTablets() {
        $sql = "UPDATE tablets SET status = 'inativo' WHERE status = 'ativo'";
        return $this->conn->exec($sql);
    }

    public function excluirTodosTabletsInativos() {
        $sql = "DELETE FROM tablets WHERE status = 'inativo'";
        return $this->conn->exec($sql);
    }
}
?>
