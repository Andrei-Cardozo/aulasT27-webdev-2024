<?php

    try {
        $dbconn = pg_connect("host=localhost port=5432 dbname=php user=postgres password=postgres");
        
        if($dbconn) {
            $aDados = array ($_POST['campo_primeiro_nome'],
                             $_POST['campo_sobrenome'],
                             $_POST['campo_email'],
                             $_POST['campo_password'],
                             $_POST['campo_cidade'],
                             $_POST['campo_estado']);
            $result = pg_query_params($dbconn, "INSERT INTO TBPESSOA(PESNOME, PESSOBRENOME, PESEMAIL, PESPASSWORD, PESCIDADE, PESESTADO) VALUES ($1, $2, $3, $4, $5, $6)", $aDados);
            while ($row = pg_fetch_assoc($result)) {
                echo print_r($row) . "<br>";
            }               
        }
    } catch (Exception $e){
        echo $e->getMessage();
    }

?>