<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        <?php include "style.css" ?>
    </style>
    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php
    include 'partials/_dbconnect.php';
    ?>

    <?php
    include 'partials/_header.php';
    ?>


    <!-- Fetch cagtegory info by category id  -->
    <?php
    $categoryId = $_GET['catid'];
    $sql = "SELECT * FROM `catagories` WHERE `category_id` = $categoryId";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>
    <!-- Insert into thread db -->
    <?php
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == "POST") {

        $th_title = htmlspecialchars($_POST['title']);
        $th_desc = htmlspecialchars($_POST['desc']);
        $currerent_user_id = $_SESSION['userid'];
        $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `created`) VALUES ('$th_title', '$th_desc', '$categoryId', '$currerent_user_id', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been added. Please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <!-- Category Info container starts here -->
    <div class="container mt-5">

        <div class="alert alert-secondary" role="alert">
            <h3 class="alert-heading mb-3">Welcome to <?php echo $catname ?> forums</h3>
            <p> <?php echo $catdesc ?></p>
            <hr>
            <p class="mb-0">This is a peer to peer to peer forum for sharing knowlead with each other. No Spam, Advertising, Self-promote in the forums.
                Do not post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post questions.
                Remain respectful of other members at all times.</p>
            <a href="" class="btn btn-success btn-lg mt-3" role="button">Learn more</a>
        </div>
    </div>



    <!-- Thread submitted form -->

    <?php

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '<div class="container">
            <h1 class="py-2">Start a Discussion</h1>
            <form action="/idiscuss/threadlist.php?catid=' . $categoryId . '" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Problem Title</label>
                    <input type="text" maxlength="255" class="form-control" id="title" name="title" aria-describedby="titleHelp">
                    <div id="titleHelp" class="form-text">Keep your title as short and crisp as possible.</div>
                </div>
                <div class="mb-3">
                    <label for="desc" class="form-label">Elaborate Your Concern</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>';
    } else {
        echo '<div class="container">
            <h1 class="py-2">Start a Discussion</h1>
            <p class="fs-5 text-warning">You are not logged in. Please login to be able to start a Discussion.</p>
            </div>';
    }

    ?>

    <div class="container my-3" id="footer-bottom">
        <h1 class="py-2">Browse Questions</h1>

        <!-- Fetch question by category id  -->
        <?php
        $categoryId = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE `thread_cat_id` = $categoryId";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $user_id = $row['thread_user_id'];
            $date =  date_create($row['created']);
            $formatedDate = date_format($date, " M d, Y");

            $sql_user = "SELECT user_email FROM `users` WHERE `id` = '$user_id'";
            $result_user = mysqli_query($conn, $sql_user);
            $user_row = mysqli_fetch_assoc($result_user);
            $email = $user_row['user_email'];
            $username = strstr($email, '@', true);

            // class="alert alert-secondary" role="alert"
            echo ' <div class="d-flex alert alert-secondary px-2 py-2">
                <div class="flex-shrink-0">
                    <img src="image/user1.png" class="align-self-start mr-3" width="54px" alt="user-image">
                </div>
                <div class="flex-grow-1 ms-3">
                 
                    <p class="fs-5 mb-1">  <a  href="/idiscuss/thread.php?threadid=' . $id . '">' . $title . '  </a>   </p>
                    <p >' . $desc . '</p>
                    <p class="fw-bold my-0 fs-6">  <small class="fw-lighter fs-6">Ask by:</small>  ' . $username . '   <small class="text-muted fw-lighter "> at ' . $formatedDate . ' </small></p>
                </div>
               </div>';
        }

        if ($noResult) {
            echo ' <div class="alert alert-secondary" role="alert">
            <p class="display-6 mb-3">No Threads Found</p>
            <p> Be the first person to ask a question.</p>

        </div>';
        }
        ?>
    </div>
    </div>

    <?php
    include 'partials/_footer.php';
    ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> -->


</body>

</html>