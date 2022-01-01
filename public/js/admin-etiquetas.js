let editaModal = document.getElementById('admin-edita-etiqueta-modal');
let apagaModal = document.getElementById('admin-elimina-etiqueta-modal');
let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

editaModal.addEventListener('shown.bs.modal', (_) => {
    document.getElementById('admin-etiqueta-text').focus();
})

editaModal.addEventListener('show.bs.modal', (e) => {
    let botao = e.relatedTarget;
    let nome = botao.getAttribute('data-bs-nome');
    document.getElementById('admin-etiqueta-text').value = nome;
    document.getElementById('admin-etiqueta-edita-guarda').setAttribute('data-bs-id', e.relatedTarget.getAttribute('data-bs-id'));
});

apagaModal.addEventListener('show.bs.modal', (e) => {
  let botao = e.relatedTarget;
  let nome = botao.getAttribute('data-bs-nome');
  document.getElementById('admin-etiqueta-apaga-txt').innerText = `Tem a certeza que quer eliminar a etiqueta de nome: ${nome}`;
  document.getElementById('admin-etiqueta-apaga-btn').setAttribute('data-bs-id', e.relatedTarget.getAttribute('data-bs-id'));
});

document.getElementById('admin-etiqueta-edita-guarda').addEventListener('click', (e) => {
  fetch(`${window.location.origin}/etiqueta/${e.target.getAttribute('data-bs-id')}`, {
    method: 'PUT',
    credentials: "same-origin",
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-type': 'application/json',
        "X-Requested-With": "XMLHttpRequest",
    },
    body: JSON.stringify({
      nome: document.getElementById('admin-etiqueta-text').value
    })
  })
  .then((response) => response.json())
  .then((jsonData) => {
    console.log(jsonData);
    if(jsonData.sucesso) {
      bootstrap.Modal.getInstance(editaModal).hide();
      location.reload();
    } else {
      document.getElementById('admin-etiqueta-text').classList.add('is-invalid');
      let feedback = document.getElementById('admin-etiqueta-text-feedback');
      feedback.style.display = "block"
      feedback.innerText = jsonData.erro.nome[0];
    }
  });
});

document.getElementById('admin-etiqueta-apaga-btn').addEventListener('click', (e) => {
  fetch(`${window.location.origin}/etiqueta/${e.target.getAttribute('data-bs-id')}`, {
    method: 'DELETE',
    credentials: "same-origin",
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        "X-Requested-With": "XMLHttpRequest",
    }
  })
  .then((_) => {
    bootstrap.Modal.getInstance(apagaModal).hide()
    location.reload();
  });
});