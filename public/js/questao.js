let buttons = document.getElementsByClassName("questao-button");

for(let i=0;i<buttons.length;i++)
    buttons[i].addEventListener("click",showForm,false);

function showForm()
{
    f = document.getElementById("pubForm");
    f.classList.remove("hidden");
}
