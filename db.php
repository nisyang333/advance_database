<?php
 $conn = mysqli_connect("localhost", "root", "", "advancedatabase");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Databased connected successfully"
?>