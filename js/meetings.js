document.getElementById("addagendum").onclick = function() {
    var petCell = document.getElementById("agendaCell");
    var input = document.createElement("input");
    input.type = "text";
    input.name = "agenda[]";
    var br = document.createElement("br"); 
    petCell.appendChild(input);
    petCell.appendChild(br);
}

let selNumber=0;

document.getElementById("addparts").onclick = function() {
    var array = ["R","A","C","I"];
    var petCell = document.getElementById("partsCell");
    var input = document.createElement("input");
    input.type = "text";
    input.name = "participants[]";
    var br = document.createElement("br"); 
    var sel = document.createElement('select');
    sel.id = "myselect" + selNumber;
    sel.name = "myselect" + selNumber;
    selNumber = selNumber + 1;
    petCell.appendChild(input);
    petCell.appendChild(sel);
    petCell.appendChild(br);
    for(var i=0; i<array.length;i++) {
	var option=document.createElement("option");
	option.value=array[i];
	option.text=array[i];
	sel.appendChild(option);
    }
}
