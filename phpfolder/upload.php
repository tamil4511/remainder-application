<?php
include('conn.php');
session_start();
$s = $_SESSION['email'];

header('Content-Type: application/json'); // Set content type to JSON

if (isset($_POST['uploadImage'])) {
    $name = $_FILES['file']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $extensions_arr = array("jpg", "jpeg", "png", "gif");

    if (in_array($imageFileType, $extensions_arr)) {
        $query = "UPDATE profile SET image='$name' WHERE email='$s'";
        mysqli_query($con, $query);
        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);
        $res = [
            'status' => 200,
            'message' => 'Image uploaded successfully',
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 201,
            'message' => 'Image not uploaded. Invalid file type.',
        ];
        echo json_encode($res);
    }
} else {
    $res = [
        'status' => 400,
        'message' => 'Bad request. Missing parameters.',
    ];
    echo json_encode($res);
}
?>
