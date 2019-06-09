<?php
session_start();
if (!isset($_SESSION['loggedIn'])){
	$_SESSION['loggedIn'] = false;
}
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false || !isset($_SESSION['username'])) {
        $account = "Login/Register";
}
else {
        $account = "Your Account";
}
print <<<TOP
	<html>
	<head>
	<meta charset='UTF-8'>
	<link rel="stylesheet" title="basic style" type="text/css" href ="./projectphase4.css" media="all"/>
	<title>Account</title>
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

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
	print <<<LOGIN
	<h3>Please log in</h3>
	<div class="form">
	<form id = "textForm" method = "post" action = "account.php">
	Username <br/> <input type = "text" name = "username" required /><br/>
	Password <br/> <input type = "password" name = "password" required /><br/>
	<a href="./register.php">Don't have an account? Click here to sign up!</a><br/>
	<input class = "button" name="login" type = "submit" value = "Login" />
	<input class = "button" name="clear" type = "reset" value = "Clear" />
	</form>
	<form id = "logoutForm" method = "post" action = "account.php">
	<input class = "button" name="logout" type = "submit" value = "Logout" />
	</form>
	</div>
LOGIN;

	if (isset($_POST["login"])){
    		extract ($_POST);
    		$username = $_POST["username"];
		$password = $_POST["password"];
		$encrPass = crypt($password, 3280);
    		//open file 
    		$file = fopen("passwd.txt", "r");
    		$valid = false;
    		//read contents and check if username is there
    		while (!feof($file)){
      			//read lines and create the array
      			$line = fgets($file);
      			$parts = explode(':', $line);
      			if(trim($parts[0])==trim($username) && trim($parts[1])===(trim($encrPass))){
      				//set session logged in as true
				$_SESSION['loggedIn'] = true;
        			if (!isset($_SESSION['username'])) {
	  				$_SESSION['username'] = $username;
				}
				$valid = true;
				header('Location:./account.php');
      			}
    		}
    		if(!$valid){
    			echo "<script>alert(\"Wrong username or password.\")</script><br/>";
    		}
    		fclose($file);
	}	
}

if ($_SESSION['loggedIn'] == true) {
	$username = $_SESSION['username'];
	print "<h2>Hi, $username!</h2>";
	print <<<LOGOUT
	<form id="logoutForm" method="post" action="finalproject.php">
        <input class="button" type="submit" name="logout" value="Logout">
	</form>
LOGOUT;

	print "<h2>Your Blogs</h2>";
	$host = "spring-2019.cs.utexas.edu";
        $user = "cs329e_mitra_rcastell";
        $pwd = "Serene4arrive*Click";
        $dbs = "cs329e_mitra_rcastell";
        $port = "3306";
	$table = 'BLOGPOSTS';
	$username = $_SESSION['username'];
        $name = $_POST['name'];
        $title = $_POST['title'];
        $blogpost = $_POST['blogpost'];
        $connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
        if (empty($connect)){
                  die("mysqli_connect failed: " . mysqli_connect_error());
        }
	$result = mysqli_query($connect, "SELECT * from $table WHERE username='$username'");
	if (mysqli_num_rows($result) == 0) {
		print "No blogs to show.";
	}
	else {
		while ($row=$result->fetch_row()){
                $post = substr($row[4],0,150);
                $end = "";
                if(strlen($row[4])>150){
                        $end = "......";
                }
                print <<<MIDDLE
                <div class="posts"><a href="./posts.php?id=$row[0]">
                <h4>$row[3]</h4>
                <p>$post $end</p>
        </a></div>
MIDDLE;
        }
	}
        $result->free();

        // Close connection to the database
	mysqli_close($connect);

	print "<h2>Your Recipes</h2>";
	$table = 'RECIPES';
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
	$result = mysqli_query($connect, "SELECT * from $table WHERE username='$username'");
	if (mysqli_num_rows($result) == 0) {
		print "No recipes to show";
	}
	else {
        while ($row=$result->fetch_row()){
        	print<<< MIDDLE
                <div class="posts"><a href="./recipePost.php?id=$row[0]">
		<h4>$row[3]</h4>
		<p>$row[6]</p>
                </a></div><br/>
MIDDLE;
        }
	}
        $result->free();

        // Close connection to the database
        mysqli_close($connect);
}

if (isset($_POST["logout"])){
	session_destroy();
}

print <<<BOTTOM
	<div class="footer">&copy; Amateur Chefs | <a href="./contact.html">Contact Us</a></div>
	</body>
	</html>
BOTTOM;
?>
