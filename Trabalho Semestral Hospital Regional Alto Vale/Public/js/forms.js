 // Quando um botão de avaliação for clicado
    document.querySelectorAll('.botao-avaliacao').forEach(button => {
        button.addEventListener('click', function() {
            const perguntaId = this.getAttribute('data-pergunta');
            const valor = this.getAttribute('data-valor');

            // Armazena o valor da avaliação no campo hidden
            document.getElementById('avaliacao-' + perguntaId).value = valor;

            // Exibe a caixa de feedback opcional
            document.getElementById('feedback-' + perguntaId).style.display = 'block';
        });
    });
