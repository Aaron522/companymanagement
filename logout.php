<?php
session_start();

if (isset($_SESSION['logged_in']))
{
    session_destroy();
    header("Location: login.html");
}
echo "You are not logged in";
sleep(2);
header("Location: login.html");