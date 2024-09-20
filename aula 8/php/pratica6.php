<?php
//criar tabela em PHP e transferir para mostrar em HTML5
$table = array(array("Disciplina","Faltas","Média"),array("Matemática", "5", "8.5"),array("Português", "2", "9"),array("Geografia", "10", "6"),array("EDF", "2", "8"));

 echo $table[0][0]."    ".$table[0][1]."   ".$table[0][2]."<br>";
 echo $table[1][0]."    ".$table[1][1]."   ".$table[1][2]."<br>";
 echo $table[2][0]."    ".$table[2][1]."   ".$table[2][2]."<br>";
 echo $table[3][0]."    ".$table[3][1]."   ".$table[3][2]."<br>";
   
    echo ("<br>");
    echo ("<br>");

    //Início da tabela em HTML
    
    echo "<table border ='1'>";
        foreach ($table as $linha) {
            echo "<tr>"; // Início de uma nova linha
            foreach ($linha as $elemento) {
                echo "<td>" . $elemento . "</td>"; // Exibe cada elemento em uma célula
            }
            echo "</tr>"; // Fim da linha
        }

// Fim da tabela HTML
echo "</table>";
?>