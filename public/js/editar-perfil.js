let descricao = document.getElementById("descricao");
let descCharCnt = document.getElementById("desc-char-cnt");
let maxCharDescCnt = descricao.maxLength;

function atualizaDescCharCnt() {
    descCharCnt.innerText = descricao.value.length + ` / ${maxCharDescCnt}`;
}

function apagaImagem(e) {
    e.preventDefault();
    let nomeUtilizador = document.getElementById('edita-perfil-imagem').dataset.nomeUtilizador;
    fetch(`${window.location.origin}/perfil/frpdoliv3/imagem`, {
        method: 'DELETE',
        credentials: "same-origin",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            "X-Requested-With": "XMLHttpRequest",
        }
    }).then ( () => window.location.reload());
}

atualizaDescCharCnt();
document.getElementById("editar-perfil-apaga-imagem").addEventListener('click', apagaImagem);
descricao.addEventListener('keyup', (_) => atualizaDescCharCnt());
descricao.addEventListener('focus', (_) => descCharCnt.style.visibility = "visible");
descricao.addEventListener('focusout', (_) => descCharCnt.style.visibility = "hidden");
