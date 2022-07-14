<?php
 include 'partials/_dbconnect.php';
session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand" href="/idiscuss">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/idiscuss">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/idiscuss/about.php">About</a>
        </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   Top Categories
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

$sql = "SELECT category_name, category_id FROM `catagories` LIMIT 5";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<li><a class="dropdown-item" href="/idiscuss/threadlist.php?catid=' . $row['category_id'] . '">' . $row['category_name'] . '</a></li>';
}


echo   '</ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/idiscuss/contact.php">Contacts</a>
            </li>
        </ul>

        <form class="d-flex " method="get" action="search.php">
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
        </form>';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $email = $_SESSION['useremail'];
    $username = strstr($email, '@', true);
    echo '<p class="text-light my-0 mx-2">Welcome ' . $username . '</p> <a href="/idiscuss/partials/_handleLogout.php" class="btn btn-outline-success mx-2">Logout</a>';
} else {
    echo '<button class="btn btn-outline-success mx-2" data-bs-toggle="modal"  data-bs-target="#loginModal">Login</button>
            <button class="btn btn-outline-success"  data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>
            ';
}


echo ' </div>
</div>
</nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
if (isset($_GET['operation_success']) && $_GET['operation_success'] == "true") {

    echo '  <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong>&nbsp;' . $_GET['msg'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        ';
} else if (isset($_GET['operation_success']) && $_GET['operation_success'] == "false") {
    echo '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong>&nbsp;' . $_GET['error'] . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
';
}
