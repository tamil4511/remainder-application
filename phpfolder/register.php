<?php
include('conn.php');

if (isset($_POST["register"])) {
    $username = mysqli_real_escape_string($con, htmlspecialchars($_POST['username']));
    $email = mysqli_real_escape_string($con, htmlspecialchars($_POST['email']));
    $password = mysqli_real_escape_string($con, htmlspecialchars($_POST['password']));
    $cpassword = mysqli_real_escape_string($con, htmlspecialchars($_POST['cpassword']));

    if (empty($username) || empty($email) || empty($password) || empty($cpassword)) {
        $res = [
            'status' => 200,
            'message' => 'All fields are mandatory',
        ];
        echo json_encode($res);
        return;
    } else {
        if ($password != $cpassword) {
            $res = [
                'status' => 220,
                'message' => 'Passwords do not match',
            ];
            echo json_encode($res);
            return;
        }

        $query = "SELECT * FROM users WHERE email='$email'";
        $ex = mysqli_num_rows(mysqli_query($con, $query));

        if ($ex > 0) {
            $res = [
                'status' => 240,
                'message' => 'Account with this email already exists',
            ];
            echo json_encode($res);
            return;
        }
        else {
            $query1 = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            $ex = mysqli_query($con, $query1);

            if ($ex != 0) {
                $res = [
                    'status' => 300,
                    'message' => 'Registration successful',
                ];
                echo json_encode($res);
                return;
            }
        }
    }
}
?>
