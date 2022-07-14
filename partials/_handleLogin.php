<?php

$showError = "false";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';
    $user_email = htmlspecialchars($_POST['loginEmail']);
    $user_pass = htmlspecialchars($_POST['loginPassword']);

    $sql = "SELECT * FROM `users` WHERE `user_email` = '$user_email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($user_pass, $row['user_pass'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['useremail'] = $user_email;
            $_SESSION['userid'] = $row['id'];
            $showMsg = "You are logged in.";
            header("Location: /idiscuss/index.php?operation_success=true&msg=$showMsg");
        } else {
            $showError = "Invalid email or password.";
            header("Location: /idiscuss/index.php?operation_success=false&error=$showError");
        }
    } else {
        $showError = "User does not exist.";
        header("Location: /idiscuss/index.php?operation_success=false&error=$showError");
    }
}
