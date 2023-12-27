<?php
include('session.php');
$email = $_SESSION['email'];

// this is retrieve the username and all the profile details in the profile table
if(isset($_POST['profile']))
{
        $query = "SELECT * FROM profile WHERE email='$email'";
    $result = mysqli_query($con, $query);
    $query1="SELECT username FROM users WHERE email='$email'";
    $result1=mysqli_query($con,$query1);
    if ($result && $result1) {
        $values = mysqli_fetch_assoc($result);
        $values1=mysqli_fetch_assoc($result1);
        if ($values) {
            $res = [
                'status'=>200,
                'firstname' => $values['firstname'],
                'lastname' => $values['lastname'],
                'mobileno'=>$values['mobileno'],
                'dob'=>$values['dob'],
                'address'=>$values['address'],
                'district'=>$values['district'],
                'pincode'=>$values['pincode'],
                'username'=>$values1['username'],
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
            return;
        } else {
            $res = [
                'error' => 'No profile found for the given email',
            ];
            echo json_encode($res);
            return;
        }
    } else {
        $res = [
            'error' => 'Error executing the query',
        ];
        echo json_encode($res);
        return;
    }
}





//today tasks retrieve
if (isset($_GET['task'])) {
    $query = "SELECT * FROM tasks WHERE email='$email' AND date = CURDATE()";
    $result = mysqli_query($con, $query);
    
    $rows = [];
    while ($answer = mysqli_fetch_assoc($result)) {
        $rows[] = [
            'category' => $answer['category'],
            'abouttask' => $answer['abouttask'],
            'date' => $answer['date']
        ];
    }

    if (!empty($rows)) {
        $res = [
            'status' => 200,
            'message' => 'There are messages',
            'answer' => $rows,
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 200,
            'message' => 'There is no message',
            'answer' => 'no data',
        ];
        echo json_encode($res);
        return;
    }
}





//whole task
if(isset($_GET['all_task']))
{
    $query = "SELECT * FROM tasks WHERE email='$email'";
    $result = mysqli_query($con, $query);

    // Check if there are any rows returned
    if(mysqli_num_rows($result) > 0)
    {
        $tasks = array();

        // Fetch all rows and store them in the $tasks array
        while($row = mysqli_fetch_assoc($result))
        {
            $tasks[] = $row;
        }

        $res = [
            'status'  => 200,
            'message' => 'data found',
            'answer'   => $tasks,
        ];
        echo json_encode($res);
    }
    else
    {
        $res = [
            'status'  => 201,
            'message' => 'no data found',
        ];
        echo json_encode($res);
    }
}




//image retrieve
if (isset($_GET['image'])) {
    $query = "SELECT * FROM profile WHERE email='$email'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $values = mysqli_fetch_assoc($result);
        if ($values) {
            $res = [
                'status'=>200,
                'image' => $values['image'],
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
            return;
        } else {
            $res = [
                'error' => 'No profile found for the given email',
            ];
            echo json_encode($res);
            return;
        }
    } else {
        
        $res = [
            'error' => 'Error executing the query',
        ];
        echo json_encode($res);
        return;
    }
}
?>
