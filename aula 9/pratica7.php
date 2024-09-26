<?php
$notas = [8.5, 7.0, 6.5, 9.0, 7.5];
$faltas = [0, 1, 0, 0, 1, 0, 0, 1, 0, 0]; // 0: Presente, 1: Falta

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

$media = calcularMedia($notas);
$statusNota = verificarAprovacaoPorNota($media);

$frequencia = calcularFrequencia($faltas);
$statusFrequencia = verificarAprovacaoPorFrequencia($frequencia);

echo "Média das Notas: " . number_format($media, 2) . "\n" . "<br>";
echo "Status de Aprovação por Nota: " . $statusNota . "\n" . "<br>";
echo "Frequência do Aluno: " . number_format($frequencia, 2) . "%\n" . "<br>";
echo "Status de Aprovação por Frequência: " . $statusFrequencia . "\n";

?>
