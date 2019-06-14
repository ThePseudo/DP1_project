<?php
require_once("../../base/settings.php");
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    echo "NO SESSION!";
    header("Location: ../../");
    die;
}
$id = $_SESSION["id"];
$numReservedSeats = $_SESSION["reserved"];

#TODO

try {
    $conn = new PDO($dbhost, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
    $conn->beginTransaction();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM seats WHERE userID = :id AND bought = :reserved");
    $stmt->execute([":id" => $id, ":reserved" => $reserved]);
    $result = $stmt->fetch()[0];
    if ($result != $numReservedSeats) {
        echo "Someone stole your seats. We're sorry, try again with new seats.";
    } else {
        $stmt = $conn->prepare("UPDATE seats SET bought = :bought WHERE userID = :id AND bought = :reserved");
        $stmt->execute([":id" => $id, ":bought" => $bought, ":reserved" => $reserved]);
        echo "Purchase done!";
    }

    $conn->commit();
    $stmt = null;
    $conn = null;
    $result = null;
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    die;
}
