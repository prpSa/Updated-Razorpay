<?php
// Create connection
    $server = "localhost";
    $username = "root";
    $password = "";
    $con = mysqli_connect($server, $username, $password,"payment");
    // Check connection
    if ($con->connect_error)  {
        die("Connection failed: " . $con->connect_error);
    } 
?>