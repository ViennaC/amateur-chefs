<?php
session_start();
if(!isset($_SESSION['loggedIn'])){
	$_SESSION['loggedIn'] = false;
}

function checkUsername($name) {
    $file = fopen("passwd.txt", "r");
    while (!feof($file)){
    //read lines and create the array
    $line = fgets($file);
    $parts = explode(':', $line);
    if(trim($parts[0])==trim($name)){
      return true;
    }
  }
  fclose($file);
  return false;
}

function matchPassword($password, $repeatpassword){

  if($password === $repeatpassword) {
return true;
  }
  else {
  	echo "<script>alert(\"Password don't match. Please try again.\")</script><br/>";
    return false;
  }
}


if (isset($_POST["register"])){
extract ($_POST);
$username = $_POST["username"];
$password = $_POST["password"];
$repeatpassword = $_POST["repeatpassword"];
$userIsThere = checkUsername($username);
if (!$userIsThere && $username!="" && $password!="" && $repeatpassword!=""){
  if (matchPassword($password,$repeatpassword)){
    $fh = fopen("passwd.txt","a");
    $encrPass = crypt($password, 3280);
    $str = "$username:$encrPass\n";
    fwrite($fh,$str);
    fclose ($fh);
    $_SESSION['loggedIn'] = true;
    $_SESSION['username'] = $username;
    header('Location:./account.php');
  }
}

else if ($username=="" || $password=="" && $repeatpassword==""){
}

else {
	echo "<script>alert(\"Username taken. Please try a different username. \")</script><br/>";
	}
}

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false || !isset($_SESSION['username'])) {
        $account = "Login/Register";
}
else {
        $account = "Your Account";
}

print <<<REGISTER
	<html>
	<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" title="basic style" type="text/css" href ="./projectphase4.css" media="all"/>
	<script src="./register.js"></script>
	<title>User Registration </title>
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
	<h3>Please Register</h3>
	<div class="form">
	<form id = "textForm" method = "post" action = "register.php">
	Username <br/> <input type = "text" name = "username" id = "username" onchange="callServer();"/><br/>
	Password <br/> <input type = "password" name = "password" id = "password"/><br/>
	Repeat Password <br/> <input type = "password" name = "repeatpassword" id = "repeatpassword"/><br/>
	<input class = "button" name="register" type = "submit" value = "Register"/>
	<input class = "button" name="clear" type = "reset" value = "Clear" />
	</form>
	<a href="./account.php">Click here to return to login page.</a>
	</div>
	<div class="footer">&copy; Amateur Chefs | <a href="./contact.html">Contact Us</a></div>
	</body>
	</html>
REGISTER;
?>
