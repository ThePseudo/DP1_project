<?php
require_once("../../base/settings.php");
session_start();
$id = -1;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
if (isset($_POST['home'])) {
    $isHome = $_POST['home'];
}
$_SESSION['reserved'] = 0;
$totalSeats = $seatsPerRow * $rows;
$ownSeats = 0;
$totalReserved = 0;
$totalBought = 0;
$seats = null;
try {
    $conn = new PDO($dbhost, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM seats");
    $stmt->execute();
    $seats = $stmt->fetchAll();
    $stmt = null;
    $conn = null;
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    die;
}

?>
<div id="row">
    <table style="margin:auto;">
        <?php
        for ($i = 0; $i < $rows; $i++) {
            ?><tr>
                <?php
                for ($j = 0; $j < $seatsPerRow; $j++) {
                    if ($j == $seatsPerRow / 2) : ?>
                        <td style="border:none;"></td>
                    <?php
                endif;
                foreach ($seats as $dataEntry) {
                    if ($dataEntry["row"] == $i && $dataEntry["seat"] == $j) {
                        if ($dataEntry["bought"] == $bought) {
                            $totalBought++;
                            ?>
                                <td class="red" onclick="javascript:onClick(this)">
                                <?php
                            } else {
                                $totalReserved++;
                                if ($id == $dataEntry["userID"]) {
                                    $ownSeats++;
                                    ?>
                                    <td class="yellow" onclick="javascript:onClick(this)">
                                    <?php
                                } else {

                                    ?>
                                    <td class="orange" onclick="javascript:onClick(this)">
                                    <?php
                                }
                            }
                            break; #optimization
                        } else {
                            ?>
                            <td class="green" onclick="javascript:onClick(this)">
                            <?php
                        }
                    }
                    ?>
                        <?= chr($baseChar + $j) . ($i + 1) ?>
                    </td>
                <?php
            }
            ?>
            </tr>
        <?php
    }
    ?>
    </table>
</div>
<?php
$_SESSION['reserved'] = $ownSeats;

if ($isHome == "true") {
    ?>
    <div class="row" style="margin-top:20px;">
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>

        <div class="columnSmallMedium">
            <a style="font-size: 20px">Total seats:</a>
            <a style="font-size: 20px"> <?= ($totalSeats) ?></a>
        </div>
        <div class="columnSmallMedium">
            <a class="green" style="font-size: 20px">Free seats:</a>
            <a style="font-size: 20px"> <?= ($totalSeats - $totalBought - $totalReserved) ?></a>
        </div>
    </div>
    <div class="row" style="margin-top:20px;">
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>

        <div class="columnSmallMedium">
            <a class="orange" style="font-size: 20px">Reserved seats:</a>
            <a style="font-size: 20px"> <?= ($totalReserved) ?></a>
        </div>
        <div class="columnSmallMedium" style="margin-left:5px">
            <a class="red" style="font-size: 20px">Purchased seats:</a>
            <a style="font-size: 20px"> <?= ($totalBought) ?></a>
        </div>
    </div>
<?php
}
