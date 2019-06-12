<?php
require_once("base/baseTemplate.php");
$getPageBase("PlaneR login");
?>

<h1 class="title">Personal page</h1>

<div id="content"></div>
<script>
    $(document).ready(function() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && (this.status == 200 || this.status == 0)) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", "actions/ajax/getSeats.php", true);
        xhttp.send();
    });
</script>


<?php closeHTML(); ?>