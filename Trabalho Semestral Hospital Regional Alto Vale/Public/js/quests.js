
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
