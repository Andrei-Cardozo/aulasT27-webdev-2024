// Função que será chamada ao clicar ou tocar na tela
function showQuestionnaire() {
    // Redirecionar para a página do formulário
    window.location.href = "forms.php"; // Caminho da página do formulário
}

// Adiciona eventos para detectar clique ou toque
document.getElementById('loading-screen').addEventListener('click', showQuestionnaire); // Para clique de mouse
document.getElementById('loading-screen').addEventListener('touchstart', showQuestionnaire); // Para toque em telas touch