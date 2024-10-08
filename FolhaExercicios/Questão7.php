<?php
// Q7: Definir o valor à vista de um carro, 
//calcular o valor total das parcelas, 
//determinar o valor dos juros pagos em um financiamento.

$valor_a_vista = 22500.00;
$parcelas = 60;
$valor_parcela = 489.65;
$valor_total_financiado = $parcelas * $valor_parcela;
$juros = $valor_total_financiado - $valor_a_vista;

echo "Mariazinha pagará R$ $juros só em juros ao comprar o carro financiado.";
?>
