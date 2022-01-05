let apagaBotao = document.getElementById('perfil-apagar');
apagaBotao.addEventListener('click', async (_) => {
    let resultado = await fetch(`${window.location.origin}/perfil/${apagaBotao.dataset.nomeUtilizador}`, {
        method: 'DELETE',
        credentials: "same-origin",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            "X-Requested-With": "XMLHttpRequest",
        },
    });
    let resultadoJSON = await resultado.json();
    if (resultadoJSON.sucesso) {
        window.location = resultadoJSON.localizacao;
    }
});