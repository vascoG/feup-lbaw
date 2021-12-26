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
document.getElementById("editar-perfil-apaga-imagem").addEventListener('click', apagaImagem);