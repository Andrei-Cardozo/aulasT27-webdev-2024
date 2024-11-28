<?php
function calcularValorFinal($valor, $desconto) {
    if ($desconto < 0 || $desconto > 100) {
        throw new Exception("O desconto deve ser um valor entre 0 e 100.");
    }
    
    $valorFinal = $valor - ($valor * ($desconto / 100));
    return $valorFinal;
}

try {
    if (isset($_REQUEST['valor']) && isset($_REQUEST['desconto'])) {
        $valor = $_REQUEST['valor'];
        $desconto = $_REQUEST['desconto'];
       
        if (!is_numeric($valor) || !is_numeric($desconto)) {
            throw new Exception("Os parâmetros 'valor' e 'desconto' devem ser numéricos.");
        }
        
        $valor = floatval($valor);
        $desconto = floatval($desconto);

        if ($valor < 0) {
            throw new Exception("O valor deve ser um número positivo.");
        }

        $valorFinal = calcularValorFinal($valor, $desconto);
        echo "Valor original: R$ " . number_format($valor, 2, ',', '.') . "<br>";
        echo "Desconto: " . number_format($desconto, 2) . "%<br>";
        echo "Valor final: R$ " . number_format($valorFinal, 2, ',', '.');
        
    } else {
        throw new Exception("Parâmetros 'valor' e 'desconto' são obrigatórios na query string.");
    }
} catch (Exception $e) {

    echo "Erro: " . $e->getMessage();
}
?>
