<?php
    $name = $_POST["username"];	 
    $file = fopen("passwd.txt", "r");
    while (!feof($file)){
    //read lines and create the array
    $line = fgets($file);
    $parts = explode(':', $line);
    if(trim($parts[0])==trim($name)){
	    $response = 'true';
	    echo $response;
	    break;
    }
  }
  fclose($file);
?>

