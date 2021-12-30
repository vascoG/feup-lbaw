let questoes = document.getElementsByClassName('card-questao');
for(let i = 0; i < questoes.length; i++) {
    questoes[i].addEventListener('click', (_) => {
        window.location.href = `${window.location.origin}/questao/${questoes[i].dataset.id}`;
    });
}