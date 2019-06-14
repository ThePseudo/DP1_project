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
        reserveSeat(object);
    }
</script>

<div class="row" style="margin-top: 20px">
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <div class="columnSmallest"></div>
    <button class="button" onclick="refresh()">Refresh</button>
</div>

<?php closeHTML(); ?>