<?php
$pastas = array(
    "bsn <br>" => array(
        "3a Fase <br>" => array(
            "desenvWeb <br>" => array(
                "bancoDados 1 <br>",
                "engSoft 1 <br>"
            )
        ),
        "4a Fase <br>" => array(
            "Intro Web <br>",
            "bancoDados 2 <br>" => array(
                "engSoft 2 <br>"
            )
        )
    )
);

function imprimirArvore($array, $nivel = 0) {
    foreach ($array as $chave => $valor) {
        echo str_repeat("-", $nivel * 3) . " ";
        
        if (!is_numeric($chave)) {
            echo $chave . "\n";
        }

        if (is_array($valor)) {
            imprimirArvore($valor, $nivel + 1);
        } else {
            echo str_repeat("-", ($nivel + 1) * 3) . " " . $valor . "\n";
        }
    }
}

imprimirArvore($pastas);
?>
