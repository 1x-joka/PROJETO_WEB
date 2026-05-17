function gerar() {
    let form = document.querySelector("form");
    let qtdAlunos = Number(document.getElementById("qtd-alunos").value);

    let gerados = document.querySelectorAll(".gerado");
    gerados.forEach(obj => obj.remove()); // Apaga cada elemento da tela, um por um

    for (let i = 0; i < qtdAlunos; i++) {
        let nomeAluno = document.createElement("p");
        nomeAluno.textContent = "Nome do Aluno " + (i + 1);
        nomeAluno.classList.add("gerado");
        let aluno = document.createElement("input");
        aluno.type = "text";
        aluno.name = "aluno[]";
        aluno.classList.add("gerado");

        let valorNota1 = document.createElement("p");
        valorNota1.textContent = "Nota 1";
        valorNota1.classList.add("gerado");
        let nota1 = document.createElement("input");
        nota1.type = "number";
        nota1.name = "nota1[]";
        nota1.classList.add("gerado");

        let valorNota2 = document.createElement("p");
        valorNota2.textContent = "Nota 2";
        valorNota2.classList.add("gerado");
        let nota2 = document.createElement("input");
        nota2.type = "number";
        nota2.name = "nota2[]";
        nota2.classList.add("gerado");

        let valorNotaTrabalho = document.createElement("p");
        valorNotaTrabalho.textContent = "Nota do Trabalho";
        valorNotaTrabalho.classList.add("gerado");
        let notaTrabalho = document.createElement("input");
        notaTrabalho.type = "number";
        notaTrabalho.name = "notaTrabalho[]";
        notaTrabalho.classList.add("gerado");

        let divisao = document.createElement("hr");
        divisao.classList.add("gerado"); // coloca a classe "gerado" no elemento criado acima

        form.appendChild(nomeAluno); // pega o nome do aluno e coloca dentro do formulário
        form.appendChild(aluno);
        form.appendChild(valorNota1);
        form.appendChild(nota1);
        form.appendChild(valorNota2);
        form.appendChild(nota2);
        form.appendChild(valorNotaTrabalho);
        form.appendChild(notaTrabalho);
        form.appendChild(divisao);
    }

    let btnResultado = document.createElement("button");
    btnResultado.type = "submit";
    btnResultado.textContent = "Mostrar Resultado";
    btnResultado.classList.add("gerado", "resultado");
    form.appendChild(btnResultado);
}