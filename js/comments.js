document.getElementById("addPet").onclick = function() {
    var petCell = document.getElementById("petCell");
    var input = document.createElement("input");
    input.type = "text";
    input.name = "pets[]";
    input.value = `[${EL_video.dataset.pausedat}] : `;
    var br = document.createElement("br"); 
    petCell.appendChild(input);
    petCell.appendChild(br);
}