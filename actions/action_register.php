<?php
require_once("../base/settings.php");

$email = $_POST["Email"];
$password = $_POST["Password"];

if (!isset($email) || !isset($password)) {
    echo "Error: missing email or password";
    die;
}

#sanitize
$email = htmlentities($email, ENT_HTML5, "UTF-8");

# encrypt
$password = password_hash($password, PASSWORD_DEFAULT);

if (!preg_match('/^(.)*(?=.*[a-z])(?=.*([0-9]|[A-Z]))(.)*$/', $password)) {
    echo "Error in the password format. Retry with another password";
    die;
}

try {
    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];
    $conn = new PDO($dbhost, $dbusername, $dbpassword, $options);
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    die;
}
try {
    $stmt = $conn->prepare("INSERT INTO users(email, password) VALUES (:email, :password);");
    $stmt->execute([":email" => $email, ":password" => $password]);
    $user = $conn->lastInsertId();
    $stmt = null;
} catch (PDOException $e) {
    header("Location: ../registration.php?message=" . urlencode("the user already exists"));
    die;
}

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user");
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
$_SESSION['email'] = $user['email'];
setcookie("time", time(), 0, "/");
header("Location: ../");
