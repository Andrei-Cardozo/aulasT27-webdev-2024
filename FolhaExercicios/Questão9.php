<?php
// Q9: Definir o valor à vista de uma moto,
//calcular as parcelas para diferentes prazos utilizando juros compostos,
//e exibir o valor das parcelas.

$valor_a_vista = 8654.00;

function calcular_parcela($capital, $taxa, $tempo) {
    return $capital * pow((1 + $taxa), $tempo);
}

$parcelas_24 = calcular_parcela($valor_a_vista, 2 / 100, 24);
$parcelas_36 = calcular_parcela($valor_a_vista, 2.3 / 100, 36);
$parcelas_48 = calcular_parcela($valor_a_vista, 2.6 / 100, 48);
$parcelas_60 = calcular_parcela($valor_a_vista, 2.9 / 100, 60);

echo "24 vezes: R$ " . ($parcelas_24 / 24) . " por parcela<br>";
echo "36 vezes: R$ " . ($parcelas_36 / 36) . " por parcela<br>";
echo "48 vezes: R$ " . ($parcelas_48 / 48) . " por parcela<br>";
echo "60 vezes: R$ " . ($parcelas_60 / 60) . " por parcela<br>";
?>
