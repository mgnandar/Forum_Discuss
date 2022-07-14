<?php
session_start();
session_destroy();

header("Location: /idiscuss");
$showMsg = "You are logged out.";
header("Location: /idiscuss/index.php?operation_success=true&msg=$showMsg");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<title>Logout</title>

<body>

    <h4 class="text-center mt-5">
        Logging you out. Please wait ...
    </h4>

    <div class="d-flex justify-content-center mt-4">
        <div class="spinner-border text-secondary" role="status">
        </div>
    </div>
</body>

</html>