// O QUE VAI APARECER NOS SELECTS DOS GOVERNANTES DE ACORDO COM A SELEÇÃO FEITA
function alternarCamposVinculo() {
    const tipoVinculo = document.getElementById('gov_vinculo_tipo').value;
    const grupoPais = document.getElementById('grupo_vinculo_pais');
    const grupoCidade = document.getElementById('grupo_vinculo_cidade');
    const inputPais = document.getElementById('gov_pais_id');
    const inputCidade = document.getElementById('gov_cidade_id');

    if (tipoVinculo === 'pais') {
        grupoPais.style.display = 'block';
        grupoCidade.style.display = 'none';
        inputPais.setAttribute('required', 'required');
        inputCidade.removeAttribute('required');
        inputCidade.value = "";
    } else if (tipoVinculo === 'cidade') {
        grupoPais.style.display = 'none';
        grupoCidade.style.display = 'block';
        inputCidade.setAttribute('required', 'required');
        inputPais.removeAttribute('required');
        inputPais.value = "";
    } else {
        grupoPais.style.display = 'none';
        grupoCidade.style.display = 'none';
        inputPais.removeAttribute('required');
        inputCidade.removeAttribute('required');
    }
}

// ALERTANDO E CONFIRMANDO A EXCLUSÃO
function confirmarExclusao(event, itemNome) {
    const conf = confirm(`Tem certeza absoluta de que deseja excluir "${itemNome}"?`);
    if (!conf) {
        event.preventDefault(); // impede o comportamento padrão que um HTML faria no navegador e deixa que o JS resolve
        return false;
    }
    return true;
}