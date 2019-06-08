<?php

# DB settings
$dbhost = "mysql:host=localhost;dbname:plane";
$dbusername = "s265340";
$dbpassword = "ateroyst";

# session timeout: 2 mins in sec
$timeOut = 120;

#PLANE settings
$seatsPerRow = 6;
$rows = 10;

# for the chars: we assume that there will never be more than 26 seats in a row
# it is reasonable, since it's a plane
# use chr($baseChar + num); to retrieve the letter
$baseChar = ord('A');
?>