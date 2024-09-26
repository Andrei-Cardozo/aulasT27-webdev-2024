<?php
require_once("funcoes.php");

$notas = [8.5, 7.0, 6.5, 9.0, 7.5];
$faltas = [0, 1, 0, 0, 1, 0, 0, 1, 0, 0]; // 0: Presente, 1: Falta

$media = calcularMedia($notas);
$statusNota = verificarAprovacaoPorNota($media);

$frequencia = calcularFrequencia($faltas);
$statusFrequencia = verificarAprovacaoPorFrequencia($frequencia);

echo "Média das Notas: " . number_format($media, 2) . "\n" . "<br>";
echo "Status de Aprovação por Nota: " . $statusNota . "\n" . "<br>";
echo "Frequência do Aluno: " . number_format($frequencia, 2) . "%\n" . "<br>";
echo "Status de Aprovação por Frequência: " . $statusFrequencia . "\n";
?>
