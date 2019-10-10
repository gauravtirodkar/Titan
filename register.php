<?php
$error = '';
if (isset($_POST['register'])) {
    if (empty($_POST['newuser']) || empty($_POST['newpass'])) {
        $error = "Username or Password is Invalid";
    } else {
        $newuser = $_POST['newuser'];
        $newpass = $_POST['newpass'];
        $newemail = $_POST['newemail'];
        $conn = new mysqli("localhost", "root", "", "test");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO userpass (user, pass, email)
VALUES ('$newuser', '$newpass','$newemail')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php"); 
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
