<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/base/settings.php");

$email = $_POST["Email"];
$password = $_POST["Password"];
$username = $_POST["Username"];

if (!isset($email) || !isset($password) || !isset($username)) {
    echo "Error: missing username, email or password";
    die;
}

$password = password_hash($password, PASSWORD_DEFAULT);

if (!preg_match('/^(.)*(?=.*[a-z])(?=.*([0-9]|[A-Z]))(.)*$/', $password)) {
    echo "Error in the password format. Retry with another password";
    die;
}

try {
    $conn = new PDO($dbhost, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("INSERT INTO plane.users(nickname, email, password) VALUES (:user, :email, :password);");
    $stmt->execute([":email" => $email, ":user" => $username, ":password" => $password]);
    $user = $conn->lastInsertId();
    $stmt = null;
    $conn = null;
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
