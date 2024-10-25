
function showPopup(message) {
    document.getElementById('popup-message').innerText = message;
    document.getElementById('popup').style.display = 'block';
}

document.getElementById('close').onclick = function() {
    document.getElementById('popup').style.display = 'none';
}

// Fecha o popup se o usuário clicar fora dele
window.onclick = function(event) {
    const popup = document.getElementById('popup');
    if (event.target == popup) {
        popup.style.display = "none";
    }
}

// Função para abrir o modal e preencher os dados da pergunta
function abrirModal(id, texto) {
    document.getElementById('modalEditar').style.display = 'block';
    document.getElementById('idPergunta').value = id;
    document.getElementById('textoPergunta').value = texto;
}

// Função para fechar o modal
function fecharModal() {
    document.getElementById('modalEditar').style.display = 'none';
}

// Fecha o modal se o usuário clicar fora dele
window.onclick = function(event) {
    const modal = document.getElementById('modalEditar');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}