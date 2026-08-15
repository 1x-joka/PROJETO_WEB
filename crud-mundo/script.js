function alternarCamposVinculo() {
    const tipoVinculo = document.getElementById('gov_vinculo_tipo').value;
    const grupoPais = document.getElementById('grupo_vinculo_pais');
    const grupoCidade = document.getElementById('grupo_vinculo_cidade');
    
    if (tipoVinculo === 'pais') {
        grupoPais.style.display = 'block';
        grupoCidade.style.display = 'none';
        document.querySelector('select[name="cidade_id"]').value = ""; // Limpa a cidade se escolher país
    } else if (tipoVinculo === 'cidade') {
        grupoPais.style.display = 'none';
        grupoCidade.style.display = 'block';
        document.querySelector('select[name="pais_id"]').value = ""; // Limpa o país se escolher cidade
    }
}

function confirmarExclusao(event, itemNome) {
    const conf = confirm(`Tem certeza absoluta de que deseja excluir "${itemNome}"?`);
    if (!conf) {
        event.preventDefault(); 
        return false;
    }
    return true;
}