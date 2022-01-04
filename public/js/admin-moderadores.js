let moderadores = document.getElementsByClassName('etiqueta-card');
let conexaoToast = document.getElementById('homepage-etiqueta-conexao-erro');
Array.from(users).forEach((user) => {
    let submete = user.getElementsByClassName('admin-moderador-acao')[0];
    let esperaResposta = etiqueta.getElementsByClassName('admin-moderador-acao-espera')[0];
    if (submete && esperaResposta) {
        submete.addEventListener('click', (e) => {
            e.stopPropagation();
            submete.style.display = 'none';
            esperaResposta.style.display = "block";
            fetch(`${window.location.origin}/admin/moderadores`, {
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

for(let i = 0; i < moderadores.length; i++) {
    moderadores[i].addEventListener('click', (_) => {
        window.location.href = `${window.location.origin}/admin?moderadores=${moderadores[i].dataset.id}`;
    })
}
