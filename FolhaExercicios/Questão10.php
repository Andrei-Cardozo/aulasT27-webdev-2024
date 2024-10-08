<?php
// Q10: Definir um array que representa uma árvore
//de dados e exibir a estrutura hierárquica em forma de texto.

$tree = [
    'root' => [
        'left' => [
            'left_left' => 'A',
            'left_right' => 'B'
        ],
        'right' => [
            'right_left' => 'C',
            'right_right' => 'D'
        ]
    ]
];

// Percorrendo o array de forma simples
echo "root<br>";

echo "--left<br>";
echo "----left_left: A<br>";
echo "----left_right: B<br>";

echo "--right<br>";
echo "----right_left: C<br>";
echo "----right_right: D<br>";
?>
