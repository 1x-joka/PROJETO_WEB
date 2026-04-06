let gastos = []

const addGasto = () => {
    let descricao = document.getElementById("desc").value
    let valor = document.getElementById("valor").value
    if (descricao === "") {
        alert('Descreva seu gasto!')
        return
    }
    gastos.push({descricao, valor})
}

const listarGasto = () => {

}

const removerGasto = () => {
}

const filtrarGasto = () => {

}

const totalGasto = () => {
    let total = document.getElementById("total")
}