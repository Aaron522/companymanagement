<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$db = "companymanagement";
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
    die;
}
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$company = $_POST['company'];
$position = $_POST['position'];
$formpassword = $_POST['password'];
$email = $_POST['email'];


$conn = new mysqli($host, $user, $password, $db);

if($conn->connect_error) { 
    die("conn failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * from users WHERE firstname = ? AND lastname = ? AND email = ? AND company = ? AND position = ?");
$stmt->bind_param("sssss", $firstname, $lastname, $email, $company, $position);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $passwordfromdb = $row['passwordd'];
    $checkpasswords = password_verify($formpassword, $passwordfromdb);
    if ($checkpasswords) {
        $_SESSION['logged_in'] = $firstname;
        header("Location: home.php");
    }
    else {
        echo("Incorrect email/password");
        header("Location: login.html");
    }
}
