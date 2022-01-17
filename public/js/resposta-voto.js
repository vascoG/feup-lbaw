let conexaoToastresposta = document.getElementById('homepage-etiqueta-conexao-erro');
    let submeteResposta = document.getElementsByClassName('votar-resposta')[0];
    let esperarResposta = document.getElementsByClassName('voto-resposta-acao-espera')[0];
    if (submeteResposta && esperarResposta) {
        submeteResposta.addEventListener('click', (e) => {
            e.stopPropagation();
            submeteResposta.style.display = 'none';
            esperarResposta.style.display = "block";
            fetch(`${window.location.origin}/votar/resposta/${submeteResposta.dataset.id}`, {
                method: 'PATCH',
                credentials: "same-origin",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "X-Requested-With": "XMLHttpRequest",
                }
            })
            .then((response) => response.json())
            .then((jsonData) => {
                esperarResposta.style.display = 'none';
                submeteResposta.style.display = 'block';
                if (jsonData.novoEstado == "VOTO") {
                    submeteResposta.classList.remove("bi-hand-thumbs-up");
                    submeteResposta.classList.add("bi-hand-thumbs-down");
                    submeteResposta.innerText = jsonData.numVotos;
                } else if (jsonData.novoEstado == "NAO_VOTO") {
                    submeteResposta.classList.remove("bi-hand-thumbs-down");
                    submeteResposta.classList.add("bi-hand-thumbs-up");
                    submeteResposta.innerText = jsonData.numVotos;
                }
            })
            .catch((_) => {
                esperarResposta.style.display = 'none';
                submeteResposta.style.display = 'block';
                bootstrap.Toast.getOrCreateInstance(conexaoToastreposta).show();
            })
        });
    };


