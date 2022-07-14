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
  


    <!-- Slider starts here -->
    <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="image/carousel1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="image/carousel2.jfif" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="image/carousel3.jfif" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>


    <!-- Category container starts here -->
    <div class="container mt-5" id="footer-bottom">
        <h2 class="text-center mb-5">iDiscuss - Categories</h2>

        <div class="row my-4">
            <!-- Fetch all the categories and use loop to iterate through categories -->
            <?php
            $sql = "SELECT * FROM `catagories`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['category_id'];
                $cat = $row['category_name'];
                $desc = strlen($row['category_description']) > 90 ? substr($row['category_description'], 0, 90) . "..." : $row['category_description'];

                echo '<div class="col-md-4 my-4">
                        <div class="card" style="width: 18rem;">
                        <img src="image/card' . $id . '.jpg" class="card-img-top" alt="image">
                            <div class="card-body">
                                <h5 class="card-title"> <a href="/idiscuss/threadlist.php?catid=' .  $id . '">' .  $cat . '</a></h5>
                                <p class="card-text"> 
                             
                                ' . $desc . '
                              
                                </p>
                                <a href="/idiscuss/threadlist.php?catid=' .  $id . '" class="btn btn-primary">View Threads</a>
                              </div>
                        </div>
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