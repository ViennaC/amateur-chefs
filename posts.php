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
HEAD;

$id = $_GET['id'];
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
$result = mysqli_query($connect, "SELECT * from $table WHERE id=$id");
if($row=$result->fetch_row()){
	print<<< BOTTOM
		<div>
		<h4>$row[3]</h4>
		<h5>$row[2]</h5>
		<p>$row[4]</p>
	</div><br/>
	<a href="./blogs.php">Go back to blog posts</a>
	<div class="footer">&copy; Amateur Chefs | <a href="./contact.html">Contact Us</a></div>
	</body>
	</html>
BOTTOM;
}
?>
