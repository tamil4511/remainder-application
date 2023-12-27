<?php
include('conn.php');
session_start();
if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($con, htmlspecialchars($_POST['email']));
    $password = mysqli_real_escape_string($con, htmlspecialchars($_POST['password']));

    if (empty($email) || empty($password)) {
        $res = [
            'status' => 200,
            'message' => 'All fields are mandatory',
        ];
        echo json_encode($res);
        return;
    } else {
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($con, $query);

        $ex=mysqli_num_rows($result);
        if($ex==0)
        {
            $res = [
                'status' => 220,
                'message' => 'no account exist',
            ];
            echo json_encode($res);
            return;
        }
        if ($result) {
            $user = mysqli_fetch_assoc($result);

            if ($user && $password==$user['password']) {
                $_SESSION['email']=$email;
                // echo $_SESSION['email'];
                // echo 'tmil';
                $res = [
                    'status' => 300,
                    'message' => 'Login successfully',
                ];
                echo json_encode($res);
                return;
            } else {
                $res = [
                    'status' => 240,
                    'message' => 'The email or password doesn\'t match',
                ];
                echo json_encode($res);
                return;
            }
        } else {
            $res = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            echo json_encode($res);
            return;
        }
    }
}
?>
