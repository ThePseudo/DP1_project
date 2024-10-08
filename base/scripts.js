
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
                $(warningMessenger).removeClass("orange");
                $(warningMessenger).addClass("green");
            } else if (returnedData == "yellow") {
                $(warningMessenger).html("Seat reserved successfully!");
                $(warningMessenger).removeClass("green");
                $(warningMessenger).removeClass("red");
                $(warningMessenger).removeClass("orange");
                $(warningMessenger).addClass("yellow");
            } else if (returnedData == "red") {
                $(warningMessenger).html("Impossible: this seat has already been purchased!");
                $(warningMessenger).removeClass("green");
                $(warningMessenger).removeClass("yellow");
                $(warningMessenger).removeClass("orange");
                $(warningMessenger).addClass("red");
            }
            $(warningMessenger).css("display", "block");
            seat.className = returnedData;
        });
}

function buySeats(container, warningMessenger) {
    $.post("actions/ajax/buySeats.php", {},
        function (returnedData) {
            updateContent(container, false);
            if (returnedData == "NO_SEATS") {
                $(warningMessenger).addClass("orange"); // using orange since red might mean error
                $(warningMessenger).removeClass("green");
                $(warningMessenger).removeClass("yellow");
                $(warningMessenger).css("display", "block");
                window.location.href = "./personal.php?warning=" + encodeURI("No seat was selected for reservation.");
                return;
            }
            if (returnedData != "ERROR") {
                $(warningMessenger).html(returnedData);
                $(warningMessenger).addClass("green"); // using orange since red might mean error
                $(warningMessenger).removeClass("orange");
                $(warningMessenger).removeClass("yellow");
                $(warningMessenger).css("display", "block");
                window.location.href = "./personal.php?success=" + encodeURI("Purchase done!");
                return;
            }

            window.location.href = "./personal.php?message=" + encodeURI("Error in buying seats. Someone stole them.");
        });
}