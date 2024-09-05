function adicionarLinhaMedia() {
    const tabela = document.getElementById("tabelaNotas");
    const numLinhas = tabela.rows.length;
    const linhaMedia = tabela.insertRow(numLinhas);

    const celulaAluno = linhaMedia.insertCell(0);
    celulaAluno.innerHTML = "<strong>Média</strong>";

    // Calcular médias por coluna de nota (Semestre 1, 2, 3)
    for (let i = 1; i <= 9; i++) {
        let soma = 0;
        let count = 0;

        for (let j = 1; j < numLinhas; j++) {
            const nota = parseFloat(tabela.rows[j].cells[i].innerHTML);
            if (!isNaN(nota)) {
                soma += nota;
                count++;
            }
        }
        const media = (soma / count).toFixed(2);
        const celulaMedia = linhaMedia.insertCell(i);
        celulaMedia.innerHTML = media;
    }
}

function adicionarColunaMedia() {
    const tabela = document.getElementById("tabelaNotas");
    const numLinhas = tabela.rows.length;

    // Verifica se a coluna de média já foi adicionada
    if (tabela.rows[0].cells.length > 10) {
        alert("A coluna de médias já foi adicionada.");
        return;
    }

    // Adiciona cabeçalho da coluna "Média" para cada aluno
    tabela.rows[0].insertCell(10).outerHTML = '<th rowspan="2">Média</th>';
    
    // Calcular a média para cada linha (aluno) e adicionar na nova célula
    for (let i = 1; i < numLinhas; i++) {
        let soma = 0;
        let count = 0;

        for (let j = 1; j <= 9; j++) {
            const nota = parseFloat(tabela.rows[i].cells[j].innerHTML);
            if (!isNaN(nota)) {
                soma += nota;
                count++;
            }
        }

        const media = (soma / count).toFixed(2);
        tabela.rows[i].insertCell(10).innerHTML = media;
    }
}
