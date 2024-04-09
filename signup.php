<?php
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
    
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) { 
    die("This email already exists");
}
$stmt->close();
$hashpass = password_hash($formpassword, PASSWORD_BCRYPT);
$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, company, position, passwordd) VALUES (?,?,?,?,?,?)");
$stmt->bind_param("ssssss", $firstname, $lastname, $email, $company, $position, $hashpass);
$stmt->execute();
echo "Email has been added";
header('Location: login.html');



