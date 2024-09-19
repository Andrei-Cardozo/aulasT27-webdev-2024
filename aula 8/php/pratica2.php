<?php
    $SALARIO1 = 1000; 
    $SALARIO2 = 2000; 
    $SALARIO2 = $SALARIO1;
    $SALARIO2++;
    $SALARIO1 += $SALARIO1 * 0.10;

    echo "Valor Salário 1: " . $SALARIO1 . " e Valor Salário 2: " . $SALARIO2;
?>