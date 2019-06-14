
function updateContent(id, isHome) {
    /*
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && (this.status == 200 || this.status == 0)) {
                document.getElementById(id).innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", "actions/ajax/getSeats.php", true);
        xhttp.send();
    */
    $.post("actions/ajax/getSeats.php", {
        home: isHome
    },
        function (returnedData) {
            document.getElementById(id).innerHTML = returnedData;
        }
    );

}

function reserveSeat(seat) {
    $.post("actions/ajax/reserveSeat.php", {
        seatID: seat.innerText,
    },
        function (returnedData) {
            console.log(returnedData);
            seat.className = returnedData;
        });
}

function refresh() {
    location.reload();
}