let etiquetas = document.getElementsByClassName('etiqueta-card');
let conexaoToast = document.getElementById('erro-conexao');
Array.from(etiquetas).forEach((etiqueta) => {
    let submete = etiqueta.getElementsByClassName('homepage-etiqueta-acao')[0];
    let esperaResposta = etiqueta.getElementsByClassName('homepage-etiqueta-acao-espera')[0];
    if (submete && esperaResposta) {
        submete.addEventListener('click', (e) => {
            e.stopPropagation();
            submete.style.display = 'none';
            esperaResposta.style.display = "block";
            fetch(`${window.location.origin}/seguidos/etiqueta/${submete.dataset.id}`, {
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
                if (jsonData.novoEstado == "SEGUE") {
                    submete.innerText = 'Parar de seguir';
                } else if (jsonData.novoEstado == "NAO_SEGUE") {
                    submete.innerText = 'Seguir';
                }
            })
            .catch((_) => {
                esperaResposta.style.display = 'none';
                submete.style.display = 'block';
                console.log(conexaoToast);
                bootstrap.Toast.getOrCreateInstance(conexaoToast).show();
            })
        });
    }
});
