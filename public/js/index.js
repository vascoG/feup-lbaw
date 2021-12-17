function maxAltura() {
    let header = document.getElementById("header");
    let alturaMaxElems = document.getElementsByClassName('max-altura');
    for (let i = 0; i < alturaMaxElems.length; i++) {
        alturaMaxElems[i].style.height = `calc(92% - ${header.offsetHeight}px)`;
    }
}

function main() {
    maxAltura();
}

main();