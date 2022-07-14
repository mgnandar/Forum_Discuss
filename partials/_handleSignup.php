<?php
$showError = "false";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';
    $user_email = htmlspecialchars($_POST['signupEmail']);
    $user_pass = htmlspecialchars($_POST['signupPassword']);
    $user_cpass = htmlspecialchars($_POST['signupcPassword']);

    // Check whether this email exists
    $existSql = "SELECT * FROM `users` where `user_email` = '$user_email'";
    $existResult = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($existResult);
    if ($numRows > 0) {
        $showError = "Email already in use";
    } else {
        if ($user_pass == $user_cpass) {
            $hash = password_hash($user_pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `created`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $showMsg = "You can now login.";
                header("Location: /idiscuss/index.php?operation_success=true&msg=$showMsg");
                exit();
            }
        } else {
            $showError = "Passwords do not match";
        }
    }
    header("Location: /idiscuss/index.php?operation_success=false&error=$showError");
}
