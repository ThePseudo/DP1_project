<?php
require_once("base/baseTemplate.php");
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./");
}
$getPageBase("PlaneR login");


?>

<h1 class="title">Personal page</h1>

<div id="content"></div>
<script>
    $(document).ready(function() {
        updateContent("content", false);
    });

    function onClick(object) {
        if (object.className == "yellow") {
            $("#msg").html("Reservation freed!");
            $("#msg").removeClass("yellow");
            $("#msg").addClass("green");
        } else {
            $("#msg").html("Reservation stored!");
            $("#msg").removeClass("green");
            $("#msg").addClass("yellow");
        }
        reserveSeat(object);
        $("#msg").css("display", "block");
    }

    function buySeats() {
        buySeats();
    }
</script>

<div class="row" style="margin-top: 20px">
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <div class="columnSmaller"></div>

    <button class="button columnSmallerSmall" onclick="refresh()">Refresh</button>
    <div class="columnSmallerSmall"></div>
    <button class="button columnSmallerSmall" onclick="buy()">Buy</button>
</div>

<div class="row">
    <div class="columnSmaller"></div>
    <div class="columnSmaller"></div>

    <p style="display:none;text-align:center" class="columnBig green" id="msg"></p>
</div>

<?php closeHTML(); ?>