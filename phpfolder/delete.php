<?php
    include('session.php');
    // this is delete the task
    if(isset($_POST['delete']))
    {
        $id=$_POST['id'];
        $query="delete from tasks where id='$id'";
        if(mysqli_query($con,$query))
        {
            $res=[
                'status'=>200,
                'message'=>'deleted successfully',
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res=[
                'status'=>201,
                'message'=>'deleted not successfully',
            ];
            echo json_encode($res);
            return;
        }
    }
    // this is update the task
    if(isset($_POST['update'])) {
        $id = mysqli_real_escape_string($con, $_POST['id']);

        // Check if the ID is valid
        if (!is_numeric($id) || $id <= 0) {
            $res = [
                'status' => 201,
                'message' => 'Invalid ID',
            ];
            echo json_encode($res);
            return;
        }

        $task_date = mysqli_real_escape_string($con, $_POST['edit_taskdate']);
        $task_category = mysqli_real_escape_string($con, $_POST['edit_taskcategory']);
        $task_abouttask = mysqli_real_escape_string($con, $_POST['edit_taskabouttask']);

        $query = "UPDATE tasks SET";

        if (!empty($task_date)) {
            $query .= " date = '$task_date',";
        }

        if (!empty($task_category)) {
            $query .= " category = '$task_category',";
        }

        if (!empty($task_abouttask)) {
            $query .= " abouttask = '$task_abouttask',";
        }

        // Remove the trailing comma
        $query = rtrim($query, ",");

        $query .= " WHERE id='$id'";

        if(mysqli_query($con, $query)) {
            $res = [
                'status' => 200,
                'message' => 'Updated successfully',
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => 201,
                'message' => 'Update not successful: ' . mysqli_error($con),
            ];
            echo json_encode($res);
        }

        // Close the connection
        mysqli_close($con);
        return;
    }
?>