let conexaoToast = document.getElementById('homepage-etiqueta-conexao-erro');
    let submete = document.getElementsByClassName('votar-questao')[0];
    let esperaResposta = document.getElementsByClassName('voto-acao-espera')[0];
    if (submete && esperaResposta) {
        submete.addEventListener('click', (e) => {
            e.stopPropagation();
            submete.style.display = 'none';
            esperaResposta.style.display = "block";
            fetch(`${window.location.origin}/votar/questao/${submete.dataset.id}`, {
                method: 'PATCH',
                credentials: "same-origin",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "X-Requested-With": "XMLHttpRequest",
                }
            })
            .then((response) => response.json())
            .then((jsonData) => {
                esperaResposta.style.display = 'none';
                submete.style.display = 'block';
                if (jsonData.novoEstado == "VOTO") {
                    submete.classList.remove("bi-hand-thumbs-up");
                    submete.classList.add("bi-hand-thumbs-down");
                    submete.innerText = ' Não Gosto';
                } else if (jsonData.novoEstado == "NAO_VOTO") {
                    submete.classList.remove("bi-hand-thumbs-down");
                    submete.classList.add("bi-hand-thumbs-up");
                    submete.innerText = ' Gosto';
                }
            })
            .catch((_) => {
                esperaResposta.style.display = 'none';
                submete.style.display = 'block';
                bootstrap.Toast.getOrCreateInstance(conexaoToast).show();
            })
        });
    };


