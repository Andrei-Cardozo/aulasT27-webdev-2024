<?php
// Função para obter a conexão com o banco de dados
function getConnection() {
    // Definir as credenciais de conexão com o PostgreSQL
    $host = 'localhost';  // Host do banco de dados (normalmente localhost para desenvolvimento)
    $port = '5432';       // Porta padrão do PostgreSQL
    $dbname = 'HospitalDB';  // Nome do banco de dados
    $user = 'postgres';      // Usuário do banco de dados
    $password = 'postgres';    // Senha do banco de dados

    try {
        // Criando uma nova instância PDO com a string de conexão para PostgreSQL
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $conn = new PDO($dsn, $user, $password);

        // Configura o PDO para lançar exceções em caso de erro
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;  // Retorna a conexão estabelecida
    } catch (PDOException $e) {
        // Exibe o erro caso a conexão falhe
        die('Erro na conexão com o banco: ' . $e->getMessage());
    }
}
?>
