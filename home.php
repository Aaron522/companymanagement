<?php
session_start();

if (!isset($_SESSION['logged_in']))
{
    die("You have not logged in!");
}

echo "welcome" . " ". $_SESSION['logged_in'];

?>

<a href="logout.php">Logout</a>
