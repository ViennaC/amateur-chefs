<?php
session_start();
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false || !isset($_SESSION['username'])) {
        $account = "Login/Register";
}
else {
        $account = "Your Account";
}
print<<<HEAD
<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <title>Blogs</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="blogs.js"></script>
        <link rel="stylesheet" title="basic style" type="text/css" href ="./blogs.css" media="all"/>
</head>
<body>
        <div class="mainHeader">
                <a href="./amateurChefs.php">
                <img src="logo.jpg" alt="logo">
                <h2>Amateur Chefs</h2>
                </a>
        </div>

        <div class="navBar">
                <ul>
                        <li><a href="./order.php">Order Now</a></li>
                        <li><a href="./recipes.php">Recipes</a></li>
                        <li><a href="./blogs.php">Blogs</a></li>
                        <li><a href="./account.php">$account</a></li>
                </ul>
        </div>
        <div class="blogHeader"><h3>All Blogs</h3></div>
HEAD;

$host = "spring-2019.cs.utexas.edu";
$user = "cs329e_mitra_rcastell";
$pwd = "Serene4arrive*Click";
$dbs = "cs329e_mitra_rcastell";
$port = "3306";
$table = 'BLOGPOSTS';

$name = $_POST['name'];
$title = $_POST['title'];
$blogpost = $_POST['blogpost'];
$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
if (empty($connect)){
                  die("mysqli_connect failed: " . mysqli_connect_error());
                }
$result = mysqli_query($connect, "SELECT * from $table");
while ($row=$result->fetch_row()){
                $post = substr($row[3],0,150);
                $end = "";
                if(strlen($row[3])>150){
                        $end = "......";
                }
                                print<<< MIDDLE
                <div class="posts"><a href="./posts.php?id=$row[0]">
                <h4>$row[2]</h4>
                <h5>$row[1]</h5>
                <p>$post $end</p>
        </a></div>
MIDDLE;
        }

$result->free();

// Close connection to the database
mysqli_close($connect);

print <<<BOTTOM
</body>
</html>
BOTTOM;
?>
