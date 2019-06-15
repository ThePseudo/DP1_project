<?php
require_once("../../base/settings.php");
session_start();
if (!isset($_POST["seatID"])) {
    echo "NO INNER TEXT!";
    die;
}
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    echo "NO SESSION!";
    header("Location: ../../");
    die;
}
$id = $_SESSION["id"];
$numReservedSeats = $_SESSION["reserved"];

$digits = htmlentities($_POST["seatID"]);
$digits = str_split($digits);
$column = $digits[0];
$column = ord($column) - $baseChar;
$row = 0;
foreach ($digits as $num) {
    if (is_numeric($num)) {
        $row = $row . $num;
    }
}
$row = (int)$row - 1;

try {
    $conn = new PDO($dbhost, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
    $conn->beginTransaction();
    $stmt = $conn->prepare("SELECT * FROM seats WHERE row = :row AND seat = :column FOR UPDATE");
    $stmt->execute([":row" => $row, ":column" => $column]);
    $result = $stmt->fetch();
    if ($id != $result['userID']) {
        if ($result['bought'] != $bought) {
            $stmt = $conn->prepare("INSERT INTO seats(row, seat, userID, bought) VALUES (:row, :column, :id, :reserved) ON DUPLICATE KEY UPDATE userID = :id");
            $stmt->execute([":row" => $row, ":column" => $column, ":id" => $id, ":reserved" => $reserved]);
            $numReservedSeats++;
            echo "yellow";
        } else {
            echo "red";
        }
    } else {
        if ($result['bought'] != $bought) {
            $stmt = $conn->prepare("DELETE FROM seats WHERE row = :row AND seat = :column AND bought = :reserved"); #double check
            $stmt->execute([":row" => $row, ":column" => $column, ":reserved" => $reserved]);
            echo "green";
            $numReservedSeats--;
        } else {
            echo "red";
        }
    }
    $conn->commit();
    $stmt = null;
    $conn = null;
    $result = null;
    $_SESSION["reserved"] = $numReservedSeats;
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    die;
}
