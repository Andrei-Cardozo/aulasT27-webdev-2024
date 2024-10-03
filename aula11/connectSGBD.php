<?php
    try {
 
        /*etapa 1 - criar instância de conexão no SGBD (DBname é o nome do database, user= usuario, password, é a senha padrão no caso daqui dos labs é postgres*/
        $dbconn = pg_connect ("host=localhost port=5432 dbname=postgres user=postgres password=postgres");
            if($dbconn) {
                echo "Database Conectado...";

            /*etapa 2 - Fazer um query simples em SGBD*/
                $result = pg_query($dbconn, 'SELECT COUNT(*) AS QTDTABS FROM PG_TABLES');

            /*Etapa 3 - buscar dados query */
                while($row = pg_fetch_assoc($result)) {
                    echo '<br>Result: '.$row['qtdtabs'];
                }
            }

    } catch (Exception $e) {
        /*Caso ocrra erro */
        echo $e->getMessage();
    }
?>