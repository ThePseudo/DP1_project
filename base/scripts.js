
function updateContent(id, isHome) {
    $.post("actions/ajax/getSeats.php", {
        home: isHome
    },
        function (returnedData) {
            document.getElementById(id).innerHTML = returnedData;
        }
    );

}

function reserveSeat(seat, warningMessenger) {
    $.post("actions/ajax/reserveSeat.php", {
        seatID: seat.innerText,
    },
        function (returnedData) {
            if (returnedData == "green") {
                $(warningMessenger).html("Reservation freed!");
                $(warningMessenger).removeClass("yellow");
                $(warningMessenger).addClass("green");
            } else {
                $(warningMessenger).html("Reservation stored!");
                $(warningMessenger).removeClass("green");
                $(warningMessenger).addClass("yellow");
            }
            $(warningMessenger).css("display", "block");
            seat.className = returnedData;
        });
}

function refresh() {
    location.reload();
}

function buySeats(container, warningMessenger) {
    $.post("actions/ajax/buySeats.php", {},
        function (returnedData) {
            console.log(returnedData);
            updateContent(container, false);
            $(warningMessenger).html(returnedData);
            $(warningMessenger).addClass("orange"); // using orange since red might mean error
            $(warningMessenger).removeClass("green");
            $(warningMessenger).removeClass("yellow");
            $(warningMessenger).css("display", "block");
        });
}