<?php 
require_once( realpath($_SERVER["DOCUMENT_ROOT"]) . "/base/baseTemplate.php");
getPageBase("PlaneR registration");
?>
<h1 class="title">Registration</h1>

<form action="/actions/action_register.php" method="POST">
<div style="margin-top:40px" class="row">
    <div class="columnSmaller"></div>
    <a style="text-align:right;" class="columnSmall" >Username:</a>
    <input type="text" name="Username" class="columnMedium" id="USERNAME">
</div>
<div style="margin-top:40px" class="row">
    <div class="columnSmaller"></div>
    <a style="text-align:right;" class="columnSmall" >E-mail:</a>
    <input type="email" name="Email" class="columnMedium" id="EMAIL">
</div>
<div style="margin-top:40px" class="row">
    <div class="columnSmaller"></div>
    <a style="text-align:right;" class="columnSmall" >Password:</a>
    <input type="password" name="Password" class="columnMedium" id="PASSWORD">
</div>
<div style="margin-top:10px;" class="row" >
    <div class="columnSmaller"></div>
    <div class="columnSmaller"></div>

    <p style="color:red;" class="columnBig"id="error-msg">Your password must contain at least 1 uppercase
     letter or a number in addition to one lowercase letter.
    </p>
</div>
<div class="row">

    <div class="columnMedium"></div>
    <div class="columnSmaller"></div>
    <div class="columnSmaller"></div>
    <input type="submit" value="Register" disabled="true"
    class="button" style="margin-top:0px;" id="SUBMIT_BTN">
</div>

</form> 

<script>
var emailOK = false;
var passwordOK = false;
var userOK = false;
$(document).ready(function () {
    // check on email
    if($("#EMAIL").val() !== "") {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($(this).val())) {
            emailOK = true;
        }
    }

    // check on username
    if($("#USERNAME").val() !== "") {
        userOK = true;
    }

    document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK && userOK);
});
$("#EMAIL").on("input", function () {
    if($("#EMAIL").val() !== "") {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($(this).val())) {
            emailOK = true;
        }
        else {
            emailOK = false;
        }
    }
    else {
        emailOK = false;
    }
    document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK && userOK);
});

$("#USERNAME").on("input", function () {
    if($(this).val() !== "") {
        userOK = true;
    }
    else {
        userOK = false;
    }
    document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK && userOK);
});

$("#PASSWORD").on("input", function () {
    if($(this).val() !== "") {
        if(/^(.)*(?=.*[a-z])(?=.*([0-9]|[A-Z]))(.)*$/.test($(this).val())) {
            passwordOK = true;
        }
        else {
            passwordOK = false;
        }
    }
    else {
        passwordOK = false;
    }
    document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK && userOK);
    if(passwordOK) {
        $("#error-msg").slideUp(500);
    }
    else {
        $("#error-msg").slideDown(500);


    }
});
</script>


<?php closeHTML(); ?>