<?php

require_once("base/baseTemplate.php");
$getPageBase("PlaneR");

?>

<h1 class="title">Seats</h1>

<div id="content"></div>
<script>
    $(document).ready(function() {
        updateContent("content", true);
    });

    function onClick(object) {
        <?php
        if (isset($_SESSION['id'])) :
            ?>
            $("#msg").html("You must go to your personal page to reserve your seats.");
        <?php else :
        ?>
            $("#msg").html("Log in to reserve your seats.");
        <?php endif; ?>
        $("#msg").css("display", "block");
    }
</script>


<div class="row">
    <div class="columnSmaller"></div>
    <div class="columnSmaller"></div>

    <p style="display:none;text-align:center" class="columnBig yellow" id="msg"></p>
</div>
<?php closeHTML(); ?>