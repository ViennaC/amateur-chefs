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
	<div class="blogHeader"><h3>Recents Posts</h3></div>
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
$result = mysqli_query($connect, "SELECT * from $table ORDER BY id DESC");
for($i=0; $i<4; $i++){
	if($row=$result->fetch_row()){
		$post = substr($row[4],0,150);
		$end = "";
		if(strlen($row[4])>150){
			$end = "......";
		}
				print<<< MIDDLE
		<div class="posts"><a href="./posts.php?id=$row[0]">
		<h4>$row[3]</h4>
		<h5>$row[2]</h5>
		<p>$post $end</p>
	</a></div>
MIDDLE;
	}
}

$result->free();

// Close connection to the database
mysqli_close($connect);

if (isset($_POST['viewAllBlogs'])) {
	header('Location:./viewAllBlogs.php');
}

if (isset($_POST["blogSubmit"])){
	if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true){
		// Connect to the MySQL database
		$host = "spring-2019.cs.utexas.edu";
		$user = "cs329e_mitra_rcastell";
		$pwd = "Serene4arrive*Click";
		$dbs = "cs329e_mitra_rcastell";
		$port = "3306";
		$table = 'BLOGPOSTS';

		$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

		if (empty($connect)){
		  die("mysqli_connect failed: " . mysqli_connect_error());
		}

		extract($_POST);
		$username = $_SESSION['username'];
		$name = $_POST['name'];
		$title = $_POST['title'];
		$blogpost = $_POST['blogpost'];
		$stmt = mysqli_prepare ($connect, "INSERT INTO $table VALUES (DEFAULT,?, ?, ?, ?, DEFAULT)");
		mysqli_stmt_bind_param ($stmt, 'ssss', $username, $name, $title, $blogpost);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// Close connection to the database
		mysqli_close($connect);
		echo "<script>alert(\"Thanks for your submission!\")</script>";
		header('Location:./blogs.php');
	}
	else{
		echo "<script>alert(\"Please log in to submit post.\")</script>";
	}

}



print <<<BOTTOM
	<form id="viewAllForm" method="post" action="blogs.php"> 
	<input class="button" type="submit" name ="viewAllBlogs" value="View All"> 
	</form>
	<div class="blogHeader"><h3>Write Post</h3></div>
	<div class="instructions">Please submit a blog post. Remember to review our guidelines before submitting!</div>
	<form id="blogForm" method="post" action="blogs.php">
	<table>
		<tr>
			<td><div>Your name: </div></td>
			<td><input type="text" name="name" id="name" size="50" required></td>
		</tr>
		<tr>
			<td><div>Title of post: </div></td>
			<td><input type="text" name="title" id="title" size="50" required></td>
		</tr>
		<tr>
			<td><div>Your post: </div></td>
			<td><textarea id="blogPost" name="blogpost" id="blogpost" cols="75" rows="15" required></textarea></td>
		</tr>
		<tr>
			<td colspan="2" id="submitButton">
			<input class = "button" name="blogSubmit" type = "submit" value = "Submit" />
			<input class="button" type="reset" value="Clear">
			</td>
		</tr>
	</table>
	</form>
	<div class="footer">&copy; Amateur Chefs | <a href="./contact.html">Contact Us</a></div>
</body>
</html>
BOTTOM;
?>

