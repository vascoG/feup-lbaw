Array.from(document.getElementsByClassName('etiqueta-card')).forEach((etiqueta) => {
    etiqueta.addEventListener('click', (_) => {
        window.location.href = `${window.location.origin}/questoes?etiqueta=${etiqueta.dataset.id}`;
    })
})