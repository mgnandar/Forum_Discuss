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



    <!-- Search Results -->

    <div class="container my-3" id="footer-bottom">
        <h1 class="py-2">Search result for <em>"<?php echo $_GET['search'] ?>"</em> </h1>
        <?php
        $search_for = $_GET['search'];
        $noResult = true;
        // Fetch shearch result **(need to run fulltext in mysql ' ALTER TABLE table_name ADD FULLTEXT(column_name1, column_name2,…)')
        $sql = "SELECT * FROM threads WHERE MATCH (thread_title, thread_desc) against ('$search_for')";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $user_id = $row['thread_user_id'];
            $date =  date_create($row['created']);
            $formatedDate = date_format($date, " M d, Y");

            // Qyery the users table to find out the name of poster
            $sql_user = "SELECT user_email FROM `users` WHERE `id` = '$user_id'";
            $result_user = mysqli_query($conn, $sql_user);
            $user_row = mysqli_fetch_assoc($result_user);
            $email = $user_row['user_email'];
            $username = strstr($email, '@', true);


            echo '<div class="d-flex alert alert-secondary px-2 py-2">
                    <div class="flex-shrink-0">
                        <img src="image/user1.png" class="align-self-start mr-3" width="54px" alt="user-image">
                    </div>
                    <div class="flex-grow-1 ms-3">

                        <p class="fs-5 mb-1"> <a href="/idiscuss/thread.php?threadid=' . $id . '">' . $title . ' </a> </p>
                        <p>' . $desc . '</p>
                        <p class="fw-bold my-0 fs-6"> <small class="fw-lighter fs-6">Ask by:</small>' . $username  . '<small class="text-muted fw-lighter"> at ' . $formatedDate . ' </small></p>
                    </div>
                </div>';
        }

        if ($noResult) {
            echo ' <div class="alert alert-secondary" role="alert">
            <p class="display-6 mb-3">No Result Found for ' . $search_for . '</p>
            <p class="fw-lighter fs-6"> Suggesstions: <ul class="text-muted fw-lighter">
            <li>Make sure that all words are spelled correctly.</li>
            <li>Try different keywords.</li>
            <li>Try more general keywords.</li> </ul>
            </p>

        </div>';
        }
        ?>



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