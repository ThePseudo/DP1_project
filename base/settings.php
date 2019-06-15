<?php
#report errors
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

#Enforcing HTTPS
if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
    #Tell the browser to redirect to the HTTPS URL.
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    #Prevent the rest of the script from executing.
    exit;
}


# DB settings
$dbhost = "mysql:host=localhost;dbname=s265340";
$dbusername = "s265340";
$dbpassword = "ateroyst";

$reserved = 0;
$bought = 1;

# session timeout: 2 mins in sec
$timeOut = 120;

#PLANE settings
$seatsPerRow = 6;
$rows = 10;

# for the chars: we assume that there will never be more than 26 seats in a row
# it is reasonable, since it's a plane
# use chr($baseChar + num); to retrieve the letter
$baseChar = ord('A');
