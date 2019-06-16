<?php
require_once("../base/settings.php");
$email = $_POST["Email"];
$password = $_POST["Password"];

if (!isset($email) || !isset($password)) {
    echo "Error: missing email or password";
    die;
}

$email = htmlentities($email, ENT_HTML5, "UTF-8");

try {
    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];
    $conn = new PDO($dbhost, $dbusername, $dbpassword, $options);
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch();
    $stmt = null;
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    die;
}

if ($user == null) {
    header("Location: " . "../login.php?message=fail");
    die;
} else {
    if (password_verify($password, $user["password"])) {
        session_start();
        $time = $_SERVER['REQUEST_TIME'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        setcookie("time", time(), 0, "/");
        header("Location: ../");
    } else {
        header("Location: " . "../login.php?message=fail");
        die;
    }
}
