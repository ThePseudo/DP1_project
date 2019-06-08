<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/base/baseTemplate.php");
$getPageBase("PlaneR");
?>
<h1 class="title">Seats</h1>

<table style="margin:auto;">
    <?php
    for ($i = 0; $i < $rows; $i++) {
        ?><tr>
            <?php
            for ($j = 0; $j < $seatsPerRow; $j++) {
                if ($j == $seatsPerRow / 2) {
                    ?>
                    <td style="border:none;"></td>
                <?php
            }
            ?>
                <td class="green">
                    <?= chr($baseChar + $j) . ($i + 1)
                    ?>
                </td>
            <?php
        }
        ?>
        </tr>
    <?php
}
?>
</table>

<?php closeHTML(); ?>