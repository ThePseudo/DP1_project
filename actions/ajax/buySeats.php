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

#TODO

try {
    $conn = new PDO($dbhost, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
    $conn->beginTransaction();
    $stmt = $conn->prepare("SELECT * FROM seats WHERE row = :row AND seat = :column");
    $stmt->execute([":row" => $row, ":column" => $column]);
    $result = $stmt->fetch();
    if ($id != $result['userID']) {
        $stmt = $conn->prepare("INSERT INTO seats(row, seat, userID, bought) VALUES (:row, :column, :id, 0) ON DUPLICATE KEY UPDATE userID = :id");
        $stmt->execute([":row" => $row, ":column" => $column, ":id" => $id]);
        echo "yellow";
    } else {
        $stmt = $conn->prepare("DELETE FROM seats WHERE row = :row AND seat = :column");
        $stmt->execute([":row" => $row, ":column" => $column]);
        echo "green";
    }
    $conn->commit();
    $stmt = null;
    $conn = null;
    $result = null;
    $numReservedSeats++;
    $_SESSION["reserved"] = $numReservedSeats;
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    die;
}
