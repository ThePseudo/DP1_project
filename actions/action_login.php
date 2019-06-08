<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/base/settings.php");
$email = $_POST["Email"];
$password = $_POST["Password"];

if (!isset($email) || !isset($password)) {
    echo "Error: missing email or password";
    die;
}

try {
    $conn = new PDO($dbhost, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM plane.users WHERE email = :email");
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch();
    $stmt = null;
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}

if ($user == null) {
    header("Location: " . "../login.php?message=fail");
} else {
    if (password_verify($password, $user["password"])) {
        session_start();
        $time = $_SERVER['REQUEST_TIME'];
        $_SESSION['id'] = $user['id'];
        setcookie("time", time(), 0, "/");
        header("Location: ../");
    }
}
