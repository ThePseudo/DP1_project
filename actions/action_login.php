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
    $conn = new PDO($dbhost, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM plane.users WHERE email = :email");
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
        setcookie("time", time(), 0, "/");
        // header("Location: ../");
    }
}
