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