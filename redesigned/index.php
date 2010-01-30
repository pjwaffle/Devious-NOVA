<?php

//Is the game installed?
$info = file('status');

if($info[0] == "NOTINSTALLED\n"){
	//Not Installed
	header("Location: install.php");
	die();
}

//Now login page
header("Location: login.php");
die();

?>
