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
        var url = window.location.search;
        url = url.slice(1);
        if (url.slice(0, 8) === "message=") {
            url = url.slice(8);
            url = url.split("%20").join(" ");
            $("#msg").html(url);
            $("#msg").addClass("red");
            $("#msg ").css("display", "block");
        }
        if (url.slice(0, 8) === "success=") {
            url = url.slice(8);
            url = url.split("%20").join(" ");
            $("#msg").html(url);
            $("#msg").addClass("orange");
            $("#msg ").css("display", "block");
        }
    });

    function onClick(object) {
        reserveSeat(object, "#msg");
    }

    function buy() {
        buySeats("content", "#msg");
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