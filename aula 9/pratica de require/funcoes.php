<?php
function calcularMedia($notas) {
    $totalNotas = array_sum($notas);
    $quantidadeNotas = count($notas);
    $media = $totalNotas / $quantidadeNotas;
    return $media;
}

function verificarAprovacaoPorNota($media) {
    if ($media >= 7) {
        return "Aprovado por Nota";
    } else {
        return "Reprovado por Nota";
    }
}

function calcularFrequencia($faltas) {
    $totalAulas = count($faltas);
    $aulasPresentes = $totalAulas - array_sum($faltas);
    $frequencia = ($aulasPresentes / $totalAulas) * 100;
    return $frequencia;
}

function verificarAprovacaoPorFrequencia($frequencia) {
    if ($frequencia >= 70) {
        return "Aprovado por Frequência";
    } else {
        return "Reprovado por Frequência";
    }
}
?>
