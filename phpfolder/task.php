<?php
include('session.php');
$email=$_SESSION['email'];
if(isset($_POST['task']))
{
    $date=$_POST['date'];
    $category=$_POST['category'];
    $abouttaks=$_POST['abouttask'];
    if(empty($_POST['date']) || empty($_POST['category']) || empty($_POST['abouttask']))
    {
        $res=[
            'status'=>201,
            'message'=>'all fields mandatory',
        ];
        echo json_encode($res);
        return;
    }
    else{

        $query="INSERT INTO tasks(date,category,abouttask,email)VALUES('$date','$category','$abouttaks','$email')";
        if(mysqli_query($con,$query))
        {
            $res=[
                'status'=>200,
                'message'=>'inserted successfully',
            ];
            echo json_encode($res);
            return;
        }
    }
}
?>