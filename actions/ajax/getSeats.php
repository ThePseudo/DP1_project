<?php
require_once("../../base/settings.php");
session_start();
$id = -1;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
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
                        ?>
                            <td class="red">
                            <?php
                        } else {
                            if ($id == $dataEntry["userID"]) {
                                ?>
                                <td class="yellow">
                                <?php
                            } else {
                                ?>
                                <td class="orange">
                                <?php
                            }
                        }
                        break; #optimization
                    } else {
                        ?>
                        <td class="green">
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