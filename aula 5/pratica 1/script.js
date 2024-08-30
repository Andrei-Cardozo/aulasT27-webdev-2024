document.addEventListener('keydown', function(event) {
    const key = event.key; 
    if (!isNaN(key) || key === '.') {
        appendCharacter(key);
    } else if (key === 'Enter') {
        event.preventDefault(); 
        calculateResult();
    } else if (key === 'Backspace') {
        deleteLast();
    } else if (key === 'Escape') {
        clearDisplay();
    } else if (['+', '-', '*', '/'].includes(key)) {
        appendCharacter(key);
    }
});

function appendCharacter(character) {
    const display = document.getElementById('display');
    display.value += character;
}

function clearDisplay() {
    const display = document.getElementById('display');
    display.value = '';
    resetDisplayStyle();
}

function deleteLast() {
    const display = document.getElementById('display');
    display.value = display.value.slice(0, -1);
}

function calculateResult() {
    const display = document.getElementById('display');
    try {
        const result = eval(display.value);
        display.value = result;
        updateDisplayStyle(result);
    } catch {
        display.value = 'Erro';
        display.classList.remove('result-positive', 'result-negative', 'result-zero');
        display.style.backgroundColor = ''; 
    }
}

function updateDisplayStyle(result) {
    const display = document.getElementById('display');
    display.classList.remove('result-positive', 'result-negative', 'result-zero');

    if (result > 0) {
        display.classList.add('result-positive');
    } else if (result < 0) {
        display.classList.add('result-negative');
    } else {
        display.classList.add('result-zero');
    }
}

function resetDisplayStyle() {
    const display = document.getElementById('display');
    display.classList.remove('result-positive', 'result-negative', 'result-zero');
}
