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
	<meta charset="UTF-8">
	<title>Recipes</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<link rel="stylesheet" title="basic style" type="text/css" href ="./recipes.css" media="all"/>
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
TOP;

print <<<RECIPESEARCH
	<h3>Recipe Search </h3>
	<form id="recipeSearch" method="post" action="recipes.php">
	<h4>Difficulty:</h4>
        <label>
        <input name="difficulty" type="radio" value="Easy"> Easy
        </label>
        <label>
        <input name="difficulty" type="radio" value="Medium"> Medium
        </label>
        <label>
        <input name="difficulty" type="radio" value="Hard"> Hard
	</label><br/><br/>
	<input class = "button" name="recipeSearchSubmit" type = "submit" value = "Search" />
        </form>
RECIPESEARCH;

if (isset($_POST['recipeSearchSubmit'])) {
	$host = "spring-2019.cs.utexas.edu";
	$user = "cs329e_mitra_rcastell";
	$pwd = "Serene4arrive*Click";
	$dbs = "cs329e_mitra_rcastell";
	$port = "3306";
	$table = 'RECIPES';

	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

	if (empty($connect)){
	  die("mysqli_connect failed: " . mysqli_connect_error());
	}

	extract($_POST);
	$username = $_SESSION['username'];
	$name = $_POST['name'];
	$title = $_POST['title'];
	$difficulty = $_POST['difficulty'];
	$ingredients = $_POST['recipeIngredients'];
	$instructions = $_POST['recipeInstructions'];
	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
	if (empty($connect)){
		die("mysqli_connect failed: " . mysqli_connect_error());
	}
	$result = mysqli_query($connect, "SELECT * from $table WHERE difficulty='$difficulty' ORDER BY id DESC");
	for($i=0; $i<4; $i++){
		if($row=$result->fetch_row()){
			$row4 = htmlspecialchars($row[4]);
			$row5 = htmlspecialchars($row[5]);
			print<<< MIDDLE
			<div class="posts"><a href="./recipePost.php?id=$row[0]">
			<h4>$row[3]</h4> 
			<h5>$row[2]</h5>
MIDDLE;
			print "</a></div><br/>";
		}
		else {
			print "No more results to show";
			break;
		}
	}

	$result->free();

	// Close connection to the database
	mysqli_close($connect);
}

print <<<RECIPEFORM
	<div class="blogHeader"><h3>Submit Your Own Recipe</h3></div>
	<div class="instructions">Please submit your own recipe. Remember to review our guidelines before submitting!</div>
	<form id="recipeForm" method="post" action="recipes.php">
	<table>
		<tr>
			<td><div>Your Name: </div></td>
			<td><input type="text" name="name" id="name" maxlength="20" required></td>
		</tr>
		<tr>
			<td><div>Recipe Name: </div></td>
			<td><input type="text" name="title" id="title" maxlength="50" required></td>
		</tr>
		<tr>
			<td><div>Difficulty: </div></td>
			<td>
			<label>
			<input name="difficulty" type="radio" value="Easy"> Easy
			</label>
			<label>
			<input name="difficulty" type="radio" value="Medium"> Medium 
			</label>
			<label>
			<input name="difficulty" type="radio" value="Hard"> Hard
			</label>
			</td>
		</tr>
		<tr>
			<td><div>Ingredients: </div></td>
			<td><textarea id="recipeIngredients" name="recipeIngredients" cols="75" rows="15" maxlength="2500" required></textarea></td>
		</tr>
		<tr>
			<td><div>Instructions: </div></td>
			<td><textarea id="recipeInstructions" name="recipeInstructions" cols="75" rows="15" maxlength="8500" required></textarea></td>
		</tr>
		<tr>
			<td colspan="2" id="submitButton">
			<input class = "button" name="recipeSubmit" type = "submit" value = "Submit" />
			<input class="button" type="reset" value="Clear">
			</td>
		</tr>
	</table>
RECIPEFORM;

if (isset($_POST['recipeSubmit'])) {
	if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true){
		// Connect to the MySQL database
		$host = "spring-2019.cs.utexas.edu";
		$user = "cs329e_mitra_rcastell";
		$pwd = "Serene4arrive*Click";
		$dbs = "cs329e_mitra_rcastell";
		$port = "3306";
		$table = 'RECIPES';

		$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

		if (empty($connect)){
		  die("mysqli_connect failed: " . mysqli_connect_error());
		}

		extract($_POST);
		$username = $_SESSION['username'];
		$name = $_POST['name'];
		$title = $_POST['title'];
		$difficulty = $_POST['difficulty'];
		$ingredients = $_POST['recipeIngredients'];
		$instructions = $_POST['recipeInstructions'];
		$stmt = mysqli_prepare ($connect, "INSERT INTO $table VALUES (DEFAULT, ?, ?, ?, ?, ?, ?)");
		mysqli_stmt_bind_param ($stmt, 'ssssss', $username, $name, $title, $ingredients, $instructions, $difficulty);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// Close connection to the database
		mysqli_close($connect);
		echo "<script>alert(\"Thanks for your submission!\")</script>";
	}
	else{
		echo "<script>alert(\"Please log in to submit recipe.\")</script>";
	}
}

print <<<BOTTOM
	<div>
	<h3>Some Additional Links</h3>
	<a href="https://tasty.co/">Tasty</a><br/>
	<a href="https://www.allrecipes.com/recipes/">allrecipes</a>
	</div>
	<div class="footer">&copy; Amateur Chefs | <a href="./contact.html">Contact Us</a></div>
</body>
</html>
BOTTOM;

?>
