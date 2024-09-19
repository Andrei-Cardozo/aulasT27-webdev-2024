<?php
//Comando de repetição while
    $SALARIO1 = 0;
    $SALARIO2 = 2000;
    $iteracao = 0;
    while($iteracao <= 100) {
    $SALARIO1++;
    $iteracao++;
        if ($iteracao == 49) {
            break;
        } 

        if ($SALARIO1 < $SALARIO2) {
            echo "O valor de SALARIO1 é: $SALARIO1, que é menor do que SALARIO2 ($SALARIO2).<br>";
        } else {
            echo "O valor de SALARIO1 é: $SALARIO1, que não é menor do que SALARIO2 ($SALARIO2).<br>";
        }
    }
?>