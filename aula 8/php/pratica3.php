<?php
    $SALARIO1 = 1000;
    $SALARIO2 = 2000; 
    $SALARIO2 = $SALARIO1;
    $SALARIO2++;
    $SALARIO1 += $SALARIO1 * 0.10;

    echo "Valor do Salário 1 é: " . $SALARIO1 . " e o Valor do Salário 2 é: " . $SALARIO2 . "<br>";
    echo " ";

    if ($SALARIO1 > $SALARIO2) {
        echo "O valor da variável 1 é maior que o valor da variável 2 <br>";
    } else if ($SALARIO1 < $SALARIO2) {
        echo "O valor da variável 2 é maior que o valor da variável 1 <br>";
    } else {
        echo "Os valores são iguais <br>";
    }

    //comando de repetição while
    $status = array('ótimo', 'Muito bom', 'bom');

    foreach ($status as $valor) {
        echo '$valor <br>';
    }
?>