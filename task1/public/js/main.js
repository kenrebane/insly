
let form = document.getElementById('calculator');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    let date = new Date();
    let data = new FormData(form);
    let newXHR = new XMLHttpRequest();

    let values = {
        time: {
            day: date.getDay(),
            hour: date.getHours()
        }
    };
    data.forEach(function(input, val) {
        console.log(input, val);
        values[val] = input;
    })

    let formattedJsonData = JSON.stringify( values );

    newXHR.addEventListener( 'load', reqListener );
    newXHR.open( 'POST', 'http://localhost:8000/api/policy' );
    newXHR.send( formattedJsonData );

});

function updateTextInput(val, elemId) {
    document.getElementById(elemId).innerHTML=val;
}


function reqListener () {
    let json = JSON.parse(this.response);
    CreateTableFromJSON(json.installments, 'showData');
    CreateTableFromJSON([json.totals], 'showData2');
}

function CreateTableFromJSON(data, elemId) {

    var col = [];
    for (var i = 0; i < data.length; i++) {
        for (var key in data[i]) {
            if (col.indexOf(key) === -1) {
                col.push(key);
            }
        }
    }

    var table = document.createElement("table");
    table.classList.add('table');


    var tr = table.insertRow(-1);

    for (var i = 0; i < col.length; i++) {
        var th = document.createElement("th");
        th.innerHTML = col[i];
        tr.appendChild(th);
    }

    for (var i = 0; i < data.length; i++) {

        tr = table.insertRow(-1);

        for (var j = 0; j < col.length; j++) {
            var tabCell = tr.insertCell(-1);
            tabCell.innerHTML = data[i][col[j]];
        }
    }

    var divContainer = document.getElementById(elemId);
    divContainer.innerHTML = "";
    divContainer.appendChild(table);
}