<?php
// Q4: Definir duas variáveis para os lados de um retângulo,
//calcular a área e exibir o resultado em uma frase. 
//Se a área for maior que 10, usar h1, senão h3.

$a = 3;
$b = 2;
$area = $a * $b;

if ($area > 10) {
    echo "<h1>A área do retângulo de lados $a e $b metros é $area metros quadrados.</h1>";
} else {
    echo "<h3>A área do retângulo de lados $a e $b metros é $area metros quadrados.</h3>";
}
?>
