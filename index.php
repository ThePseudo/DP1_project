<?php

require_once("base/baseTemplate.php");
$getPageBase("PlaneR");

?>

<h1 class="title">Seats</h1>

<div id="content"></div>
<script>
    $(document).ready(function() {
        updateContent("content");
    });
</script>

<?php closeHTML(); ?>