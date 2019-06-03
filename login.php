<?php 
require_once( realpath($_SERVER["DOCUMENT_ROOT"]) . "/base/baseTemplate.php");
getPageBase("PlaneR login");
?>
<h1 class="title">Login</h1>

<form action="/actions/action_login.php" method="POST">
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
<div class="columnMedium"></div>
<div class="columnSmaller"></div>
<div class="columnSmaller"></div>

<input type="submit" value="Log in" class="button" style="margin-top:20px;" id="SUBMIT_BTN">

</form> 

<script>
var emailOK = false;
var passwordOK = false;
$(document).ready(function () {
    if($("#EMAIL").val() !== "") {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
        .test(document.getElementById("EMAIL").value)) {
            emailOK = true;
        }
        else {
            emailOK = false;
        }
    }
    else {
        emailOK = false;
    }
    document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK);
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
    document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK);
});

$("#PASSWORD").on("input", function () {
    if($(this).val() !== "") {
        passwordOK = true;
    }
    else {
        passwordOK = false;
    }
    document.getElementById("SUBMIT_BTN").disabled = !(emailOK && passwordOK);
});
</script>

<?php closeHTML(); ?>