<?php
//foreach usa em cada array
    $disciplinas = array("AlgII", "SGBDII", "AdmBSN", "ProgWEBI", "Redes de Comp");
        foreach ($disciplinas as $chave => $valor);
    $professores = array("AlgII" => "Fernando", "SGBDII" => "Marco", "AdmBSN" => "Sandro", "ProgWEBI" => "Cléber", "Redes de Comp" => "Fabiano");
        foreach ($professores as $chave => $valor) {
            echo "Disciplina= ". $chave . ", tem esse professor(a)= ". $valor;
            echo "<br>";
        }
?>