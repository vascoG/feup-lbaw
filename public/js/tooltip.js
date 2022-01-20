let tooltips = document.getElementsByClassName('ajuda');
for(let i = 0; i < tooltips.length; i++) {
    new bootstrap.Tooltip(tooltips[i]);
}