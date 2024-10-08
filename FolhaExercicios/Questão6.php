<?php
// Q6: Criar uma lista de produtos com seus preços e quantidades, 
//calcular o valor total gasto, e verificar se o 
//dinheiro disponível é suficiente, faltante ou exato.

// Produtos e suas quantidades em Kg
$produtos = [
    "maçã" => [ "preco" => 5.00, "quantidade" => 2 ],
    "melancia" => [ "preco" => 10.00, "quantidade" => 1 ],
    "laranja" => [ "preco" => 3.00, "quantidade" => 3 ],
    "repolho" => [ "preco" => 4.00, "quantidade" => 1 ],
    "cenoura" => [ "preco" => 2.00, "quantidade" => 2 ],
    "batatinha" => [ "preco" => 3.50, "quantidade" => 1 ]
];

$total = 0;
foreach ($produtos as $produto => $dados) {
    $gasto = $dados["preco"] * $dados["quantidade"];
    $total += $gasto;
}

$saldo_disponivel = 50.00;

if ($total > $saldo_disponivel) {
    $diferenca = $total - $saldo_disponivel;
    echo "<p style='color:red;'>Faltam R$ $diferenca para completar a compra.</p>";
} elseif ($total < $saldo_disponivel) {
    $diferenca = $saldo_disponivel - $total;
    echo "<p style='color:blue;'>Joãozinho ainda pode gastar R$ $diferenca.</p>";
} else {
    echo "<p style='color:green;'>O saldo foi esgotado. Joãozinho gastou exatamente R$ 50,00.</p>";
}
?>
