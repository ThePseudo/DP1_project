<?php
/*
require_once("../../base/settings.php");

session_start();
if (isset($_SESSION['id'])) {
    if (isset($_COOKIE['time'])) {
        if (time() - $_COOKIE['time'] > $timeOut) {
            session_unset();
            session_destroy();
            session_start();
        } else {
            setcookie("time", time(), $timeOut, "/");
        }
    }
}

