// Função que será chamada ao clicar ou tocar na tela
function showQuestionnaire() {
    document.getElementById('loading-screen').style.display = 'none'; // Esconde a tela de loading
    document.getElementById('questionnaire').style.display = 'block'; // Mostra o questionário
}

// Adiciona eventos para detectar clique ou toque
document.getElementById('loading-screen').addEventListener('click', showQuestionnaire); // Para clique de mouse
document.getElementById('loading-screen').addEventListener('touchstart', showQuestionnaire); // Para toque em telas touch