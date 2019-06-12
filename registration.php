<?php
require_once("base/baseTemplate.php");
$getPageBase("PlaneR registration");
?>
<h1 class="title">Registration</h1>

<form action="/actions/action_register.php" method="POST">
    <div style="margin-top:40px" class="row">
        <div class="columnSmaller"></div>
        <a style="text-align:right;" class="columnSmall">E-mail:</a>
        <input type="email" name="Email" class="columnMedium" id="EMAIL">
    </div>
    <div style="margin-top:40px" class="row">
        <div class="columnSmaller"></div>
        <a style="text-align:right;" class="columnSmall">Password:</a>
        <input type="password" name="Password" class="columnMedium" id="PASSWORD">
    </div>
    <div style="margin-top:10px;" class="row">
        <div class="columnSmaller"></div>
        <div class="columnSmaller"></div>

        <p style="color:red;" class="columnBig" id="error-msg">Your password must contain at least 1 uppercase
            letter or a number in addition to one lowercase letter.
        </p>
    </div>
    <div class="row">

        <div class="columnMedium"></div>
        <div class="columnSmaller"></div>
        <div class="columnSmaller"></div>
        <input type="submit" value="Register" disabled class="button" style="margin-top:0px;" id="SUBMIT_BTN">
    </div>

    <div style="margin-top:10px;" class="row">
        <div class="columnSmaller"></div>
        <div class="columnSmaller"></div>

        <p style="color:red;" class="columnBig" id="error-register"></p>
    </div>
    <div class="row">

</form>

<script>
    var emailOK = false;
    var passwordOK = false;
    $(document).ready(function() {
        var url = window.location.search;
        url = url.slice(1);
        if (url.slice(0, 8) === "message=") {
            url = url.slice(8);
            url = url.split("+").join(" ")
            $("#error-register").html("Error: " + url);
        }

        // check on email
        if ($("#EMAIL").val() !== "") {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($(this).val())) {
                emailOK = true;
            }
        }
        document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK);
    });
    $("#EMAIL").on("input", function() {
        if ($("#EMAIL").val() !== "") {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($(this).val())) {
                emailOK = true;
            } else {
                emailOK = false;
            }
        } else {
            emailOK = false;
        }
        document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK);
    });

    $("#PASSWORD").on("input", function() {
        if ($(this).val() !== "") {
            if (/^(.)*(?=.*[a-z])(?=.*([0-9]|[A-Z]))(.)*$/.test($(this).val())) {
                passwordOK = true;
            } else {
                passwordOK = false;
            }
        } else {
            passwordOK = false;
        }
        document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK);
        if (passwordOK) {
            $("#error-msg").slideUp(500);
        } else {
            $("#error-msg").slideDown(500);


        }
    });
</script>


<?php closeHTML(); ?>