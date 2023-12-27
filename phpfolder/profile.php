<?php
include('session.php');
// insert or update the data in the profile table
$email = $_SESSION['email'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profile'])) {
    echo "<script>alert('$email');</script>";
    $query = "SELECT * FROM profile WHERE email='$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $updateQuery = "UPDATE profile SET ";
        $updateFields = array();
    
        // Check each field for updates and include it in the update query
        if (!empty($_POST['firstname'])) {
            $updateFields[] = "firstname='" . mysqli_real_escape_string($con, $_POST['firstname']) . "'";
        }
    
        if (!empty($_POST['lastname'])) {
            $updateFields[] = "lastname='" . mysqli_real_escape_string($con, $_POST['lastname']) . "'";
        }
    
        if (!empty($_POST['mobileno'])) {
            $updateFields[] = "mobileno='" . mysqli_real_escape_string($con, $_POST['mobileno']) . "'";
        }
    
        if (!empty($_POST['dob'])) {
            $updateFields[] = "dob='" . mysqli_real_escape_string($con, $_POST['dob']) . "'";
        }
    
        if (!empty($_POST['address'])) {
           $updateFields[] = "address='" . mysqli_real_escape_string($con, $_POST['address']) . "'";
        }
    
        if (!empty($_POST['district'])) {
            $updateFields[] = "district='" . mysqli_real_escape_string($con, $_POST['district']) . "'";
        }
    
        if (!empty($_POST['pincode'])) {
            $updateFields[] = "pincode='" . mysqli_real_escape_string($con, $_POST['pincode']) . "'";
        }
    
        $updateQuery .= implode(', ', $updateFields);
        $updateQuery .= " WHERE email='$email'";
    
        if (mysqli_query($con, $updateQuery)) {
           
            $res = [
                'status' => 200,
                'message' => 'updated successfully',
            ];
            echo json_encode($res);
            return;
        } else {
            echo "Error updating record: " . mysqli_error($con);
        }
    }
     else {
        // Insert logic
        $insertFields = array('email');
        $insertValues = array("'" . mysqli_real_escape_string($con, $email) . "'");

        // Check each field for non-empty values and include only non-empty fields in the insert query
        if (!empty($_POST['firstname'])) {
            $insertFields[] = 'firstname';
            $insertValues[] = "'" . mysqli_real_escape_string($con, $_POST['firstname']) . "'";
        }

        if (!empty($_POST['lastname'])) {
            $insertFields[] = 'lastname';
            $insertValues[] = "'" . mysqli_real_escape_string($con, $_POST['lastname']) . "'";
        }

        if (!empty($_POST['mobileno'])) {
            $insertFields[] = 'mobileno';
            $insertValues[] = "'" . mysqli_real_escape_string($con, $_POST['mobileno']) . "'";
        }

        if (!empty($_POST['dob'])) {
            $insertFields[] = 'dob';
            $insertValues[] = "'" . mysqli_real_escape_string($con, $_POST['dob']) . "'";
        }

        if (!empty($_POST['address'])) {
            $insertFields[] = 'address';
            $insertValues[] = "'" . mysqli_real_escape_string($con, $_POST['address']) . "'";
        }

        if (!empty($_POST['district'])) {
            $insertFields[] = 'district';
            $insertValues[] = "'" . mysqli_real_escape_string($con, $_POST['district']) . "'";
        }

        if (!empty($_POST['pincode'])) {
            $insertFields[] = 'pincode';
            $insertValues[] = "'" . mysqli_real_escape_string($con, $_POST['pincode']) . "'";
        }

        // Construct the insert query dynamically based on non-empty fields
        $insertQuery = "INSERT INTO profile (" . implode(', ', $insertFields) . ") 
                        VALUES (" . implode(', ', $insertValues) . ")";

        if (mysqli_query($con, $insertQuery)) {
            echo "Record inserted successfully";
        } else {
            echo "Error inserting record: " . mysqli_error($con);
        }
    }
}



//this is change password logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changepassword'])) {
    $oldpassword = mysqli_real_escape_string($con, $_POST['oldpassword']);
    $newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);

    // Assume $email is defined somewhere in your code
    $query = "SELECT password FROM users WHERE email='$email'";
    $result = mysqli_query($con, $query);
   $value=mysqli_fetch_assoc($result);
    // echo $email;
    // echo $value['password'];
    // echo $oldpassword;
    if (trim($value['password']) == trim($oldpassword)) {
        mysqli_query($con, "UPDATE users SET password='$newpassword' WHERE email='$email'");
        $res = [
            'status' => 200,
            'message' => 'Password updated',
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 201,
            'message' => 'Password doesn\'t match the old password',
        ];
        header('Content-Type: application/json');
    echo json_encode($res);
    return;
    }
    
}

?>
