<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/base/settings.php");

$email = $_POST["Email"];
$password = $_POST["Password"];
$username = $_POST["Username"];

if (!isset($email) || !isset($password) || !isset($username)) {
    echo "Error: missing username, email or password";
    die;
}

#sanitize
$email = htmlentities($email, ENT_HTML5, "UTF-8");
$password = htmlentities($password, ENT_HTML5, "UTF-8");
$username = htmlentities($username, ENT_HTML5, "UTF-8");

# encrypt
$password = password_hash($password, PASSWORD_DEFAULT);

if (!preg_match('/^(.)*(?=.*[a-z])(?=.*([0-9]|[A-Z]))(.)*$/', $password)) {
    echo "Error in the password format. Retry with another password";
    die;
}

try {
    $conn = new PDO($dbhost, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
}
try {
    $stmt = $conn->prepare("INSERT INTO plane.users(nickname, email, password) VALUES (:user, :email, :password);");
    $stmt->execute([":email" => $email, ":user" => $username, ":password" => $password]);
    $user = $conn->lastInsertId();
    $stmt = null;
} catch (PDOException $e) {
    header("Location: ../registration.php?message=" . urlencode("the user already exists"));
}

try {
    $stmt = $conn->prepare("SELECT * FROM plane.users WHERE id = :user");
    $stmt->execute([":user" => $user]);
    $user = $stmt->fetch();
    $stmt = null;
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    die;
}

session_start();
$time = $_SERVER['REQUEST_TIME'];
$_SESSION['id'] = $user['id'];
setcookie("time", time(), 0, "/");
header("Location: ../");
