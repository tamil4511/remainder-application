<?php
define('server', 'localhost');
define('username', 'root');
define('password', '');
define('database', 'todo');
$con = mysqli_connect(server, username, password, database);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
