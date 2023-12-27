<?php
include('conn.php');
session_start();
if(isset($_SESSION['email']))
{
    $s=$_SESSION['email'];
}
if(isset($_POST['logout']))
{
    // echo "working";
    session_destroy();

// Provide a response of successful logout
$response = [
    'status' => 200,
    'message' => 'Logout successful',
];

echo json_encode($response);
return;
}
?>