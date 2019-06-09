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
	<title>Order Now</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<script src="order.js"></script>
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
if (!isset($_SESSION['ordered']) || $_SESSION['ordered'] == false) {
	print <<<ORDERFORM
	<h2 class="recipesHeader"> Recipe Books</h2>
	<form id="orderForm" method="post" action="order.php" onsubmit="validateOrder();">
	<table>
		<tr>
			<th>Books</th>
			<th>Quantity</th>
		</tr>
		<tr class="recipe">
			<td><img src="vol1.png" alt="foodImg"><p>$25.00</p></td>
			<td class="title"><input class="quantityInput" type = "text" name = "vol1Amt" id = "vol1Amt" onchange="updateTotal();" maxlength="3"></td>
		</tr>
		<tr class="recipe">
			<td><img src="vol2.png" alt="foodImg"><p>$25.00</p></td>
                        <td class="title"><input type = "text" class="quantityInput" name = "vol2Amt" id = "vol2Amt" onchange="updateTotal();" maxlength="3"/></td>

		</tr>
		<tr class="recipe">
			<td><img src="vol3.png" alt="foodImg"><p>$25.00</p></td>
			<td class="title"><input type = "text" class="quantityInput" name = "vol3Amt" id = "vol3Amt" onchange="updateTotal();" maxlength="3"/></td>
		</tr>
  		<tr class="recipe">
                	<td>Total: </td>
                	<td class="title"><input type = "text" class="quantityInput" name = "total" id="orderTotal" value = "$0.00" readonly></td>
        	</tr>
		<tr>
			<td colspan="2"><input class = "orderButton" name="orderSubmit" type = "submit" value = "Order" /><input class = "orderButton" name="clear" type = "reset" value = "Clear" /></td>
		</tr>		
	</table>
	</form>
ORDERFORM;

	if (isset($_POST['orderSubmit'])) {
		$_SESSION['ordered'] = true;
		if ($_POST['vol1Amt'] == null) {
			$_SESSION['vol1Amt'] = 0;
		}
		else {
			$_SESSION['vol1Amt'] = $_POST['vol1Amt'];
		}
		if ($_POST['vol2Amt'] == null) {
                        $_SESSION['vo21Amt'] = 0;
                }
                else {
                        $_SESSION['vol2Amt'] = $_POST['vol2Amt'];
                }
		if ($_POST['vol3Amt'] == null) {
                        $_SESSION['vol3Amt'] = 0;
                }
                else {
                        $_SESSION['vol3Amt'] = $_POST['vol3Amt'];
                }
		$_SESSION['total'] = $_POST['total'];
		header('Location:./order.php');	
	}
}

if ($_SESSION['ordered'] == true) {
$total = $_SESSION['total'];
$vol1Amt = $_SESSION['vol1Amt'];
$vol2Amt = $_SESSION['vol2Amt'];
$vol3Amt = $_SESSION['vol3Amt'];
print <<<BILLINGFORM
	<h2 class="recipesHeader">Shipping Information</h2>
	<form id="shippingForm" method="post" action="order.php">
	<table>
	<tr class="recipe">
		<td>Total: </td>
		<td>$total</td>
	</tr>
	<tr class="recipe">
                <td>Books: </td>
		<td>Vol. 1: $vol1Amt | 
		Vol. 2: $vol2Amt |
		Vol. 3: $vol3Amt</td>
        </tr>

	<tr class="recipe">
    		<td>Name: </td>
    		<td class="info"><input type = "text" id = "name" name = "name"maxlength="30"/></td>
	</tr>
	<tr class="recipe">
                <td>Phone Number: </td>
                <td class="info"><input type = "text" id = "phone" name = "phone" maxlength="20"/></td>
        </tr>

	<tr class="recipe">
    		<td>Street Address: </td>
    		<td class="info"><input type = "text" id = "streetAddress" name = "streetAddress" maxlength="50"/></td>
	</tr>
	<tr class="recipe">
    		<td>City: </td>
    		<td class="info"><input type = "text" id = "city" name = "city"maxlength="30"/></td>
	</tr>
	<tr class="recipe">
    		<td>State: </td>
    		<td class="info"><input type = "text" id = "state" name = "state" maxlength="30"/></td>
	</tr>
	<tr class="recipe">
    		<td>Zipcode: </td>
    		<td class="info"><input type = "text" id = "zipCode" name = "zipCode" maxlength="5"/></td>
	</tr>
	<tr class="recipe">
    		<td>Card Number: </td>
    		<td class="info"><input type = "text" name = "cardNumber" maxlength="16"/></td>
	</tr>
	<tr>
    		<td colspan="2"><input class = "orderButton" name="shippingSubmit" type = "submit" value = "Order" /><input class = "orderButton" name="clear" type = "reset" value = "Clear" /><input class = "orderButton" name="cancelSubmit" type = "submit" value = "Cancel Order" /></td>
	</tr>
</table>
</form>
BILLINGFORM;
	if (isset($_POST['cancelSubmit'])) {
		$_SESSION['ordered'] = false;
		$_SESSION['vol1Amt'] = 0;
		$_SESSION['vol2Amt'] = 0;
		$_SESSION['vol3Amt'] = 0;
		$_SESSION['total'] = 0;
		header('Location:./order.php');
	}
}
print <<<BOTTOM
	<div class="footer">&copy; Amateur Chefs | <a href="./contact.html">Contact Us</a></div>
</body>
</html>
BOTTOM;
?>
