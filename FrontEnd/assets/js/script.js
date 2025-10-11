function formatarTelefone(valor) {
    let numeros = valor.replace(/\D/g, ''); 

    if (numeros.length > 11) numeros = numeros.substring(0, 11);

    let telefone = numeros;

    if (numeros.length > 2) {
        telefone = '(' + numeros.substring(0, 2) + ')' + numeros.substring(2);
    } else if (numeros.length > 0) {
        telefone = '(' + numeros;
    }

    if (numeros.length > 7) {
        telefone = '(' + numeros.substring(0,2) + ')' + numeros.substring(2,7) + '-' + numeros.substring(7);
    }

    return telefone;
}

function formatarCEP(valor) {
    let numeros = valor.replace(/\D/g, ''); 

    if (numeros.length > 8) numeros = numeros.substring(0, 8);

    let CEP = numeros;

    if (numeros.length > 5) {
        CEP = numeros.substring(0,5) + '-' + numeros.substring(5);
    }

    return CEP;
}

function buscarCEP(CEP){
    let cep = String(CEP).replace(/\D/g, '');

    if (cep.length > 8){
        cep = cep.substring(0, 8);
    }

    let formatado = cep;

    if (cep.length > 5) {
        formatado = cep.substring(0,5) + '-' + cep.substring(5);
    }

    document.getElementById('CEP').value = formatado;
    
    if(cep.length !== 8)return;

    fetch(`https://viacep.com.br/ws/${cep}/json/`).then(response => response.json()).then(dados => {
        if(!dados.erro){
            const enderecoEl = document.getElementById('endereco');
            // const bairroEl   = document.getElementById('bairro');
            // const cidadeEl   = document.getElementById('cidade');
            // const estadoEl   = document.getElementById('estado');

            if (enderecoEl) enderecoEl.value = dados.logradouro ?? '';
            // if (bairroEl)   bairroEl.value   = dados.bairro ?? '';
            // if (cidadeEl)   cidadeEl.value   = dados.localidade ?? '';
            // if (estadoEl)   estadoEl.value   = dados.uf ?? '';
      } else {
        alert('CEP não encontrado. Verifique e tente novamente.');
      }
    })

    return CEP;
}

document.addEventListener('DOMContentLoaded', function() {
    const linksExcluir = document.querySelectorAll('a[href^="excluirContato.php"]');

    linksExcluir.forEach(link => {
        link.addEventListener('click', function(event) {
            const confirmacao = confirm('Tem certeza que deseja excluir este contato?');
            if (!confirmacao) {
                event.preventDefault(); 
            }
        });
    });
});