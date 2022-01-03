let modais = document.getElementsByClassName('modal');
let fnRetomaSubmissao = new Map();
let criaModal = document.getElementById('admin-cria-etiqueta-modal');
let editaModal = document.getElementById('admin-edita-etiqueta-modal');
let apagaModal = document.getElementById('admin-elimina-etiqueta-modal');
let conexaoToast = document.getElementById('admin-etiqueta-conexao-erro');

function apagaErrosInput(e) {
  let erros = e.target.getElementsByClassName('invalid-feedback');
  let inputs = e.target.getElementsByClassName('form-control');
  for(let i = 0; i < erros.length; i++) {
    let erro = erros[i];
    erro.style.display = "none";
    erro.innerText = "";
  }
  for(let i = 0; i < inputs.length; i++) {
    inputs[i].classList.remove('is-invalid');
  }
}

function ativaEventosAtualizaDadosModais() {
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

  criaModal.addEventListener('shown.bs.modal', (_) => {
    document.getElementById('admin-cria-etiqueta-text').focus();
  });
}

function ativaEventosSubmissao() {
  document.getElementById('admin-etiqueta-edita-guarda').addEventListener('click', (e) => {
    let terminaLoadFn = fnRetomaSubmissao.get('admin-edita-etiqueta-modal');
    fetch(`${window.location.origin}/admin/etiqueta/${e.target.getAttribute('data-bs-id')}`, {
      method: 'PATCH',
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
      if(jsonData.sucesso) {
        bootstrap.Modal.getInstance(editaModal).hide();
        location.reload();
      } else {
        document.getElementById('admin-etiqueta-text').classList.add('is-invalid');
        let feedback = document.getElementById('admin-etiqueta-text-feedback');
        feedback.style.display = "block"
        feedback.innerText = jsonData.erro.nome[0];
      }
      terminaLoadFn();
    })
    .catch((_) => {
      bootstrap.Toast.getOrCreateInstance(conexaoToast).show();
      terminaLoadFn();
    });
  });
  
  document.getElementById('admin-etiqueta-apaga-btn').addEventListener('click', (e) => {
    let terminaLoadFn = fnRetomaSubmissao.get('admin-elimina-etiqueta-modal');
    fetch(`${window.location.origin}/admin/etiqueta/${e.target.getAttribute('data-bs-id')}`, {
      method: 'DELETE',
      credentials: "same-origin",
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          "X-Requested-With": "XMLHttpRequest",
      }
    })
    .then((_) => {
      bootstrap.Modal.getInstance(apagaModal).hide();
      terminaLoadFn();
      location.reload();
    })
    .catch((_) => {
      bootstrap.Toast.getOrCreateInstance(conexaoToast).show();
      terminaLoadFn();
    });
  });
  
  document.getElementById('admin-etiqueta-cria-btn').addEventListener('click', (_) => {
    let terminaLoadFn = fnRetomaSubmissao.get('admin-cria-etiqueta-modal');
    fetch(`${window.location.origin}/admin/etiquetas`, {
      method: 'POST',
      credentials: "same-origin",
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Content-type': 'application/json',
          "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify({
        nome: document.getElementById('admin-cria-etiqueta-text').value
      })
    })
    .then((response) => response.json())
    .then((jsonData) => {
      if (jsonData.sucesso) {
        bootstrap.Modal.getInstance(criaModal).hide();
        location.reload();
      } else {
        document.getElementById('admin-cria-etiqueta-text').classList.add('is-invalid');
        let feedback = document.getElementById('admin-cria-etiqueta-text-feedback');
        feedback.style.display = "block"
        feedback.innerText = jsonData.erro.nome[0];
      }
      terminaLoadFn();
    })
    .catch((_) => {
      bootstrap.Toast.getOrCreateInstance(conexaoToast).show();
      terminaLoadFn();
    });
  });
}

for(let i = 0; i < modais.length; i++) {
  let botaoSubmete = modais[i].getElementsByClassName('admin-etiqueta-submete-acao')[0];
  let botaoSpinner = modais[i].getElementsByClassName('admin-etiqueta-loading-acao')[0];
  botaoSubmete.addEventListener('click', (_) => {
    botaoSpinner.style.display = "block";
    botaoSubmete.style.display = "none";
  });
  fnRetomaSubmissao.set(modais[i].id, () => {
    botaoSpinner.style.display = "none";
    botaoSubmete.style.display = "block";
  });
}

ativaEventosAtualizaDadosModais();
ativaEventosSubmissao();
editaModal.addEventListener('hide.bs.modal', apagaErrosInput);
criaModal.addEventListener('hide.bs.modal', apagaErrosInput);
