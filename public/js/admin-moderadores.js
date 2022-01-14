let moderadores = document.getElementsByClassName('admin-moderador-card');
let conexaoToast = document.getElementById('erro-conexao');

function trocaPlaceholders() {
    let wrapsImagem = document.getElementsByClassName('admin-moderador-img-wrap');
    let trocaPlaceholder = (curWrap, imagem, placeholder) => {
        if (imagem.complete) {
            imagem.classList.remove('d-none');
            curWrap.removeChild(placeholder);
        } else {
            imagem.addEventListener('load', () => trocaPlaceholder(curWrap, imagem, placeholder));
        }
    }
    let trocaFonte = (imagem) => {
        imagem.src = imagem.dataset.src;
        imagem.removeAttribute('data-src');
    }
    for(let i = 0; i < wrapsImagem.length; i++) {
        let curWrap = wrapsImagem[i];
        let imagem = curWrap.querySelector('img');
        let placeholder = curWrap.querySelector('div');
        trocaFonte(imagem);
        trocaPlaceholder(curWrap, imagem, placeholder);
    }
}

Array.from(moderadores).forEach((user) => {
    let submete = user.getElementsByClassName('admin-moderador-acao')[0];
    let esperaResposta = user.getElementsByClassName('admin-moderador-acao-espera')[0];
    if (submete && esperaResposta) {
        submete.addEventListener('click', (e) => {
            e.stopPropagation();
            submete.style.display = 'none';
            esperaResposta.style.display = "block";
            fetch(`${window.location.origin}/admin/moderadores/editar/${submete.dataset.id}`, {
                method: 'PATCH',
                credentials: "same-origin",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "X-Requested-With": "XMLHttpRequest",
                }
            })
            .then((response) => response.json())
            .then((jsonData) => {
                console.log(jsonData);
                esperaResposta.style.display = 'none';
                submete.style.display = 'block';
                if (jsonData.novoEstado == "MODERADOR") {
                    submete.innerText = 'Remover Moderador';
                } else if (jsonData.novoEstado == "NAO_MODERADOR") {
                    submete.innerText = 'Adicionar Moderador';
                }
            })
            .catch((_) => {
                esperaResposta.style.display = 'none';
                submete.style.display = 'block';
                bootstrap.Toast.getOrCreateInstance(conexaoToast).show();
            })
        });
    }
});

trocaPlaceholders();
