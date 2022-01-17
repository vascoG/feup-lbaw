let buttons = document.getElementsByClassName("responder");
let buttons1 = document.getElementsByClassName("comentar-questao");
let buttons2 = document.getElementsByClassName("comentar-resposta");


for(let i=0;i<buttons.length;i++)
    buttons[i].addEventListener("click",showFormResposta,false);

function showFormResposta()
{   
    form = document.getElementById("formResposta");
    form.classList.remove("hidden");
    document.getElementById("formComentario").classList.add("hidden");
    document.getElementById("formComentarioResposta").classList.add("hidden");
    
}

for(let i=0;i<buttons1.length;i++)
    buttons1[i].addEventListener("click",showFormComentario,false);

function showFormComentario()
{   
    form = document.getElementById("formComentario");
    form.classList.remove("hidden");
    document.getElementById("formComentarioResposta").classList.add("hidden");
    document.getElementById("formResposta").classList.add("hidden");
    
}

for(let i=0;i<buttons2.length;i++)
    buttons2[i].addEventListener("click",showFormComentarioResposta,false);

function showFormComentarioResposta()
{   
    let id=this.getAttribute('data-id');
    form = document.getElementById("formComentarioResposta");
    form.classList.remove("hidden");
    document.getElementById("formResposta").classList.add("hidden");
    document.getElementById("formComentario").classList.add("hidden");
    let oldAction = form.action;
    id = "criar-comentario-resposta/" + id;
    let newAction = oldAction.replace("criar-comentario-resposta/0", id);
    form.action = newAction;
    
}