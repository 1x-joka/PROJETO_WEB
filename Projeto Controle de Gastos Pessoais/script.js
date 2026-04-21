let gastos = []

const addGasto = () => {
    let desc = document.getElementById("desc").value
    let vl = document.getElementById("valor").value
    let catg = document.getElementById("categoria").value

    if (desc === "" || vl === "" || catg === "") {
        alert('Descreva seu gasto!')
        return
    }
    gastos.push({
        descricao: desc, // Adicionando na lista "gastos" o que o usuário digita, não um valor definido
        valor: Number(vl),
        categoria: catg
    })

    salvar()
    listarGasto()
    totalGasto()

    // Limpando os campos
    document.getElementById("desc").value = ""
    document.getElementById("vl").value = ""
    document.getElementById("catg").value = ""
}

const listarGasto = () => {
    let lista = document.getElementById("lista")
    lista.innerHTML = ""

    gastos.forEach(function(gasto,index) { // index = posição do objeto no array gastos
        let item = document.createElement("li")

        item.innerHTML = gasto.descricao + " - R$" + gasto.valor.toFixed(2) + " - " + gasto.categoria + `<button onclick="removerGasto(${index})">Remover</button>` // chama a função removerGasto passando a posição (index) daquele item

        lista.appendChild(item) // Adicionando o item na lista
    })
}

const removerGasto = (index) => {
    gastos.splice(index, 1) // removendo um item (definido pelo index/sua posição) do array

    salvar()
    listarGasto()
    totalGasto()
}

const totalGasto = () => {
    let total = 0

    gastos.forEach(function(gasto){
        total = total + gasto.valor
    })

    document.getElementById("total").innerText = "R$" + total
}

const salvar = () => {
    localStorage.setItem("gastos", JSON.stringify(gastos)) // salva os gastos no navegador
}

const filtrarGasto = () => {
    let filtro = document.getElementById("filtro").value
    let lista = document.getElementById("lista")
    lista.innerHTML = ""

    gastos.forEach(function(gasto, index){
        switch (filtro) {
            case "alimentacao":
                if (gasto.categoria === "Alimentação"){
                    criarItem(gasto, index)
                }
                break
            
            case 'transporte':
                if (gasto.categoria === "Transporte"){
                    criarItem(gasto, index)
                }
                break

            case 'lazer':
                if (gasto.categoria === "Lazer"){
                    criarItem(gasto, index)
                }
                break

            // caso não for nenhum dos casos acima (ou seja, TODOS no select), mostra todos os gastos 
            default:
                criarItem(gasto, index)
        }
    })
}

const criarItem = (gasto, index) => {
    let lista = document.getElementById("lista")
    let item = document.createElement("li")

    item.innerHTML = gasto.descricao + " -R$" + gasto.valor.toFixed(2) + " - " + gasto.categoria +
    ` <button onclick="removerGasto(${index})">Remover</button>`

    lista.appendChild(item)
}