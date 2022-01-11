let listaNotificacoes = document.getElementById('lista-notificacoes');
let mostraNotificacoes = document.getElementById('botao-mostra-notificacao');
listaNotificacoes.addEventListener('click', (e) => e.stopPropagation());

function alteraView(_) {
    fetch(`${window.location.origin}/notificacoes`, {
        method: 'GET',
        credentials: "same-origin",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            "X-Requested-With": "XMLHttpRequest",
        }
    })
    .then((response) => response.json())
    .then((responseJSON) => {
        listaNotificacoes.innerHTML = responseJSON.html;
        if (responseJSON.nNotificacoes == 0) {
            mostraNotificacoes.innerHTML = '<i class="bi bi-bell"></i>'
        } else {
            '<i class="bi bi-bell-fill"></i>'
        }
        adicionaEventHandlersNotificacao();
    });
}

function adicionaEventHandlersNotificacao() {
    let dispensaTodas = document.getElementById('dispensa-todas-notificacao');
    document.getElementById("reload-notificacoes").addEventListener('click', alteraView);
    Array.from(document.getElementsByClassName('dispensa-notificacao')).forEach((dispensaNotificacao) => {
        dispensaNotificacao.addEventListener('click', () => {
            fetch(`${window.location.origin}/notificacao/${dispensaNotificacao.dataset.id}`, {
                method: 'DELETE',
                credentials: "same-origin",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "X-Requested-With": "XMLHttpRequest",
                }
            }).then((_) => {
                if (listaNotificacoes.getElementsByClassName('notificacao').length == 1) {
                    alteraView();
                } else {
                    listaNotificacoes.removeChild(dispensaNotificacao.parentElement);
                }
            })
            .catch((err) => {
                
            });
        })
    });
    if(dispensaTodas) {
        dispensaTodas.addEventListener('click', (_) => {
            fetch(`${window.location.origin}/notificacoes`, {
                method: 'DELETE',
                credentials: "same-origin",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "X-Requested-With": "XMLHttpRequest",
                }
            }).then((_) => {
                alteraView();
            })
            .catch((err) => {});
        });
    }
}

adicionaEventHandlersNotificacao();
