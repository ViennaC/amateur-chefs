<?php
session_start();
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false || !isset($_SESSION['username'])) {
	$account = "Login/Register";
}
else {
	$account = "Your Account";
}
print <<<TOP
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Amateur Chefs</title>
	<link rel="stylesheet" title="basic style" type="text/css" href ="./projectphase4.css" media="all"/>
</head>
<body>

	<div class="header">
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
TOP;

if (isset($_POST["logout"])){
	session_destroy();
	header('Location:./finalproject.php');
}

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
$result = mysqli_query($connect, "SELECT * from $table ORDER BY id DESC");
	print <<<SIDEBAR
	<div class="sideBar">
	<h3><a href="./blogs.php">Recent Posts</a></h3>
SIDEBAR;
for($i=0; $i<4; $i++){
	if($row=$result->fetch_row()){
		$post = substr($row[4],0,100);
		$end = "";
		if(strlen($row[4])>100){
			$end = "......";
		}
		print <<<MIDDLE
		<div class="sideBarItem"><a href="./posts.php?id=$row[0]">
		<div class="posts">
		<h4>$row[3]</h4>
		<h5>$row[2]</h5>
		<p>$post $end</p>
		</div></a></div>
MIDDLE;

	}
}

print "</div>";

print <<<BOTTOM
	<div class="aboutUs">
		<h3><a href="./blank.html">About Us</a></h3>
		<p>Amateur Chefs is a community-based recipe website. Members are welcome to upload their own homemade recipes or blogs sharing fun and exciting new cooking ideas or experiences. You can also order the official AmateurChefs recipe books. Get started by exploring the recipes and blogs created by our very own Amateur Chef members.</p>
	</div>

	<div class="forum">
		<h3><a href="./recipes.html">Videos</a></h3>
		<iframe width="400" height="310" src="https://www.youtube.com/embed/vz4T2RWUGlU">
	</iframe>
		<iframe width="400" height="310" src="https://www.youtube.com/embed/ERUugjLmwuY">
	</iframe>
	</div>


	<div class="footer">&copy; Amateur Chefs | <a href="./contact.html">Contact Us</a></div>
	</body>
	</html>
BOTTOM;

$result->free();

// Close connection to the database
mysqli_close($connect);


?>
