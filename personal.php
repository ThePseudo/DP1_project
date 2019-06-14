<?php
require_once("base/baseTemplate.php");
$getPageBase("PlaneR login");
?>

<h1 class="title">Personal page</h1>

<div id="content"></div>
<script>
    $(document).ready(function() {
        updateContent("content", false);
    });
</script>

<script>
    function onClick(object) {
        console.log(object.innerText);
    }
</script>

<?php closeHTML(); ?>