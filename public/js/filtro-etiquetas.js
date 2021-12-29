let items = document.getElementsByClassName('pesquisa-etiqueta');
let botoes = document.getElementsByClassName('cm-ativa-checkbox');
let checkboxes = document.querySelectorAll('.cm-ativa-checkbox input');
let mostrador = document.getElementById('mostrador-etiquetas');
let etiquetasMostradas = new Map();

function atualizaLista(_) {
    let filtro = document.getElementById('filtro-etiquetas').value.toUpperCase();
    for(let i = 0; i < items.length; i++) {
        let textoItem = items[i].querySelector('div').querySelector('p');
        let texto = textoItem.innerHTML;
        if (texto.toUpperCase().indexOf(filtro) > -1) {
            items[i].style.display = "";
        } else {
            items[i].style.display = "none";
        }
    }
}

function criaEtiqueta(texto) {
    let etiqueta = document.createElement('p');
    etiqueta.classList = "etiqueta-pill"
    etiqueta.style.cursor = "default";
    etiqueta.title = texto;
    etiqueta.innerText = texto;
    return etiqueta;
}

function atualizaMostrador(element) {
    console.log(element);
    let id = element.querySelector('input').value;
    let texto = element.querySelector('p').innerText;
    if (etiquetasMostradas.has(id)) {
        etiquetasMostradas.get(id).remove();
        etiquetasMostradas.delete(id);    
    } else {
        let novaEtiqueta = criaEtiqueta(texto);
        etiquetasMostradas.set(id, novaEtiqueta);
        mostrador.appendChild(novaEtiqueta);
    }
}

for (let i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('click', (e) => {
        e.stopPropagation();
        return false;
    })
}

for(let i = 0; i < botoes.length; i++) {
    botoes[i].addEventListener('click', (_) => {
        let estado = botoes[i].querySelector('input').checked;
        botoes[i].querySelector('input').checked = !estado;
        atualizaMostrador(botoes[i]);
    });
}

document.getElementById('filtro-etiquetas').addEventListener('keyup', atualizaLista);
document.getElementById('lista-etiquetas').addEventListener('click', (e) => e.stopPropagation());
