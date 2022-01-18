let clicaveis = document.getElementsByClassName('clicavel');
for (let i = 0; i < clicaveis.length; i++) {
    clicaveis[i].addEventListener('click', (_) => {
        if (window.getSelection().type != 'Range') {
            window.location.href = clicaveis[i].dataset.href;
        }
    })
}