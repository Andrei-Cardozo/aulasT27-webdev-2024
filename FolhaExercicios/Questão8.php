<?php
// Q8: Definir o valor à vista de uma moto, 
//calcular as parcelas para diferentes prazos utilizando juros simples,
//e exibir o valor das parcelas.

$valor_a_vista = 8654.00;

$parcelas_24 = $valor_a_vista * (1 + (1.5 / 100) * 24);
$parcelas_36 = $valor_a_vista * (1 + (2.0 / 100) * 36);
$parcelas_48 = $valor_a_vista * (1 + (2.5 / 100) * 48);
$parcelas_60 = $valor_a_vista * (1 + (3.0 / 100) * 60);

echo "24 vezes: R$ " . ($parcelas_24 / 24) . " por parcela<br>";
echo "36 vezes: R$ " . ($parcelas_36 / 36) . " por parcela<br>";
echo "48 vezes: R$ " . ($parcelas_48 / 48) . " por parcela<br>";
echo "60 vezes: R$ " . ($parcelas_60 / 60) . " por parcela<br>";
?>
