function gerar() {
    let container = document.getElementById("container");
    let qtdAlunos = Number(document.getElementById("qtd-alunos").value);

    for (let i = 0; i < qtdAlunos; i ++) {
        let nomeAluno = document.createElement("p")
        nomeAluno.textContent = "Nome do Aluno " + (i + 1)
        let aluno = document.createElement("input")
        aluno.type = "text"
        aluno.name = "aluno[]"

        let valorNota1 = document.createElement("p")
        valorNota1.textContent = "Nota 1"
        let nota1 = document.createElement("input")
        nota1.type = "number"
        nota1.name = "nota1[]"

        let valorNota2 = document.createElement("p")
        valorNota2.textContent = "Nota 2"
        let nota2 = document.createElement("input")
        nota2.type = "number"
        nota2.name = "nota2[]"

        let valorNotaTrabalho = document.createElement("p")
        valorNotaTrabalho.textContent = "Nota do Trabalho"
        let notaTrabalho = document.createElement("input")
        notaTrabalho.type = "number"
        notaTrabalho.name = "notaTrabalho[]"

        let divisao = document.createElement("hr")

        container.appendChild(nomeAluno)
        container.appendChild(aluno)
        container.appendChild(valorNota1)
        container.appendChild(nota1)
        container.appendChild(valorNota2)
        container.appendChild(nota2)
        container.appendChild(valorNotaTrabalho)
        container.appendChild(notaTrabalho)
        container.appendChild(divisao)
    }
}