<?php
require_once("../../base/settings.php");
session_start();
$id = -1;
$isHome = false;
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
    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];
    $conn = new PDO($dbhost, $dbusername, $dbpassword, $options);
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
                $found = false;
                foreach ($seats as $dataEntry) {
                    if ($dataEntry["row"] == $i && $dataEntry["seat"] == $j) {
                        $found = true;
                        if ($dataEntry["bought"] == $bought) {
                            $totalBought++;
                            ?>
                                <td class="red" style="cursor: pointer" onclick="javascript:onClick(this)">
                                <?php
                            } else {
                                $totalReserved++;
                                if ($id == $dataEntry["userID"]) {
                                    $ownSeats++;
                                    ?>
                                    <td class="yellow" style="cursor: pointer" onclick="javascript:onClick(this)">
                                    <?php
                                } else {

                                    ?>
                                    <td class="orange" style="cursor: pointer" onclick="javascript:onClick(this)">
                                    <?php
                                }
                            }
                            break; #optimization
                        }
                    }
                    if (!$found) {
                        ?>
                        <td class="green" style="cursor: pointer" onclick="javascript:onClick(this)">
                        <?php
                    }
                    $found = false;
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

if ($isHome == "true") :
    ?>
    <div class="row" style="margin-top:20px;">
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>
        <div class="columnSmallest"></div>

        <div class="rowSmall">
            <div class="columnSmallMedium">
                <a style="font-size: 20px; padding:2px;">Total seats:</a>
                <a style="font-size: 20px"> <?= ($totalSeats) ?></a>
            </div>
        </div>
        <div class="rowSmall">

            <div class="columnSmallMedium">
                <a class="greenT" style="font-size: 20px; padding:2px;">Free seats:</a>
                <a style="font-size: 20px"> <?= ($totalSeats - $totalBought - $totalReserved) ?></a>
            </div>
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

        <div class="rowSmall">
            <div class="columnSmallMedium">
                <a class="orangeT" style="font-size: 20px; padding:2px;">Reserved seats:</a>
                <a style="font-size: 20px"> <?= ($totalReserved) ?></a>
            </div>
        </div>
        <div class="rowSmall">
            <div class="columnSmallMedium">
                <a class="redT" style="font-size: 20px; padding:2px;">Purchased seats:</a>
                <a style="font-size: 20px"> <?= ($totalBought) ?></a>
            </div>
        </div>
    </div>
<?php
endif;
?>