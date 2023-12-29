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
        $qu="select * from profile where email='$s'";
        $r=mysqli_query($con,$qu);
        $row=mysqli_num_rows($r);
        if($row==1)
        {
            $q="update profile set image='$name' where email='$s'";
            $r=mysqli_query($con,$q);
            if($r)
            {
                move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);
                $res = [
                    'status' => 200,
                    'message' => 'Image uploaded successfully.',
                ];
                echo json_encode($res);
            }
            else
            {
                $res = [
                    'status' => 201,
                    'message' => 'Image not uploaded. Invalid file type.',
                ];
                echo json_encode($res);
            }
        }
        else
        {
            $q="insert into profile(email,image) values('$s','$name')";
            $r=mysqli_query($con,$q);
            if($r)
            {
                move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);
                $res = [
                    'status' => 200,
                    'message' => 'Image uploaded successfully',
                ];
                echo json_encode($res);
            }
            else
            {
                $res = [
                    'status' => 201,
                    'message' => 'Image not uploaded. Invalid file type.',
                ];
                echo json_encode($res);
            }
        }
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
