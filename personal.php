<?php
require_once("base/baseTemplate.php");
$getPageBase("PlaneR login");
?>

<h1 class="title">Personal page</h1>

<div id="content"></div>
<script>
    $(document).ready(function() {
        updateContent("content");
    });
</script>


<?php closeHTML(); ?>