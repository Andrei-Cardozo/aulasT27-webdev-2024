// Função para exibir os números de forma sequencial
function showScaleNumbers() {
    const numbers = document.querySelectorAll('.scale-number');
    
    numbers.forEach((number, index) => {
        setTimeout(() => {
            number.classList.add('visible'); // Adiciona a classe para mostrar o número
        }, index * 200); // Atraso progressivo para cada número (600 ms entre cada)
    });
}

// Chama a função ao carregar a página
window.onload = showScaleNumbers;
