<?php

    try {
        $dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres");
        
        if($dbconn) {
            echo "database conectado...". "<br>";

            $termoBusca = $_POST["campo_primeiro_nome"];
            
           
            $result = pg_query($dbconn, "SELECT * FROM TBPESSOA WHERE PESNOME ILIKE '$termoBusca' ");
            }    
            if(pg_num_rows($result) == 0) {
                echo "Não encontrado!". "<br>";
            } else {
                while ($row = pg_fetch_assoc($result)) {
                    echo print_r($row) . "<br>";
            }
        }
    } catch (Exception $e){
        echo $e->getMessage();
    }

?>