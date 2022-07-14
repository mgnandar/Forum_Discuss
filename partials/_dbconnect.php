<?php
// Script to connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$db = "idiscuss";

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {

    echo "Sorry failed to connect " . mysqli_connect_error();
}
