let conexaoToast = document.getElementById('homepage-etiqueta-conexao-erro');
Array.from(questoes).forEach((questao) => {
    let submete = questao.getElementsByClassName('votar')[0];
    let esperaResposta = questao.getElementsByClassName('homepage-etiqueta-acao-espera')[0];
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
                console.log(jsonData);
                esperaResposta.style.display = 'none';
                submete.style.display = 'block';
                if (jsonData.novoEstado == "VOTO") {
                    submete.classList.add(" voto-ativo");
                } else if (jsonData.novoEstado == "NAO_VOTO") {
                    submete.classList.remove("voto-ativo");
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


