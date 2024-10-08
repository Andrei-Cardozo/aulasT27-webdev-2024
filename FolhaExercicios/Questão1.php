<?php
// Q1: Ter 3 variáveis numéricas, somar os valores e aplicar condições para mudar 
//a cor do resultado com base nos valores das variáveis.

$var1 = 12;
$var2 = 8;
$var3 = 15;
$soma = $var1 + $var2 + $var3;

if ($var1 > 10) {
    echo "<p style='color:blue;'>A soma é $soma</p>";
}
if ($var2 < $var3) {
    echo "<p style='color:green;'>A soma é $soma</p>";
}
if ($var3 < $var1 && $var3 < $var2) {
    echo "<p style='color:red;'>A soma é $soma</p>";
}
?>
