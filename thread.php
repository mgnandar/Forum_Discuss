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


    <!-- Fetch thread info by category thread id  -->
    <?php
    $threadId = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE `thread_id` = $threadId";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {

        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $user_id = $row['thread_user_id'];

        // Qyery the users table to find out the name of poster
        $sql_user = "SELECT user_email FROM `users` WHERE `id` = '$user_id'";
        $result_user = mysqli_query($conn, $sql_user);
        $user_row = mysqli_fetch_assoc($result_user);
        $email = $user_row['user_email'];
        $username = strstr($email, '@', true);
    }
    ?>

    <!-- Insert into comment db -->
    <?php
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == "POST") {
        $comment = htmlspecialchars($_POST['comment']);
        $currerent_user_id = $_SESSION['userid'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_user_id`, `created`) VALUES ('$comment', '$threadId', '$currerent_user_id', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>


    <!-- Category Info container starts here -->
    <div class="container mt-5">

        <div class="alert alert-secondary" role="alert">
            <h3 class="alert-heading mb-3"><?php echo $title ?></h3>
            <p> <?php echo $desc ?></p>
            <hr>
            <p class="mb-0">This is a peer to peer to peer forum for sharing knowlead with each other. No Spam, Advertising, Self-promote in the forums.
                Do not post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post questions.
                Remain respectful of other members at all times.</p>
            <p class="my-2">Posted by:<em> <b> <?php echo $username ?></b> </em></p>
        </div>
    </div>

    <!-- Comment submitted form -->

    <?php

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <form action="/idiscuss/thread.php?threadid=' . $threadId .  '" method="post">

            <div class="mb-3">
                <label for="comment" class="form-label">Type your Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
    } else {
        echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <p class="fs-5 text-warning">You are not logged in. Please login to be able to post a Comment.</p>
        </div>';
    }

    ?> <div class="container my-3" id="footer-bottom">
        <h1 class="py-2">Comments</h1>

        <!-- Fetch comment by  thread id  -->
        <?php



        function time_elapsed_string($datetime, $full = false)
        {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        }


        $threadId = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE `thread_id` = $threadId";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            // $date =  date_create($row['created']);
            $formatedDate =  time_elapsed_string($row['created']);

            $user_id = $row['comment_user_id'];

            $sql_user = "SELECT user_email FROM `users` WHERE `id` = '$user_id'";
            $result_user = mysqli_query($conn, $sql_user);
            $user_row = mysqli_fetch_assoc($result_user);
            $email = $user_row['user_email'];
            $username = strstr($email, '@', true);

            echo ' <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img src="image/user1.png" class="align-self-start mr-3" width="54px" alt="user-image">
                    </div>
                    <div class="flex-grow-1 ms-3">
                    <p class="fw-bold my-0 fs-6">  ' . $username . '   <small class="text-muted fw-lighter "> at ' . $formatedDate . ' </small></p>

                        <p>' . $content . '</p>
                    </div>
                    
                </div>';
        }

        if ($noResult) {
            echo ' <div class="alert alert-secondary" role="alert">
            <p class="display-6 mb-3">No Comments Found</p>
            <p> Be the first person to comment.</p>

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