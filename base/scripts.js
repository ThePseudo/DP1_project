
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
                $(warningMessenger).html("Reservation freed successfully!");
                $(warningMessenger).removeClass("yellow");
                $(warningMessenger).removeClass("red");
                $(warningMessenger).addClass("green");
            } else if (returnedData == "yellow") {
                $(warningMessenger).html("Seat reserved successfully!");
                $(warningMessenger).removeClass("green");
                $(warningMessenger).removeClass("red");
                $(warningMessenger).addClass("yellow");
            } else if (returnedData == "red") {
                $(warningMessenger).html("Impossible: this seat has already been purchased!");
                $(warningMessenger).removeClass("green");
                $(warningMessenger).removeClass("yellow");
                $(warningMessenger).addClass("red");
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