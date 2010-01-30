<?php

/* Uncommentthe next line to stop this file from beign used */
//die('Game already installed');
define("INSIDE",true);

function ReadFromFile($filename) {
	$content = @file_get_contents ($filename);
	return $content;
}

switch($_GET['page']){

	case "2":
		//Sort out config.php
		
		//Load page		
		$page = @file_get_contents ('./install/page2.html');
		
		//Output
		echo $page;

		break;
	
	case "3":
		//Sort out database
		
		//Load page		
		$page = @file_get_contents ('./install/page3.html');
		
		//Output
		echo $page;
		
		break;
	
	case "4":
		//Sort out admin acount
		
		//Load page		
		$page = @file_get_contents ('./install/page4.html');
		
		//Output
		echo $page;
		
		break;
	
	//Special pages
	case "checkconnection":
		//Check the database connections
		
		//Get variables
		$server = $_GET['server'];
		$name = $_GET['name'];
		$user = $_GET['user'];
		$pass = $_GET['pass'];
		
		//Test connection
		@mysql_connect($server, $user, $pass) or die('1');
		
		//Try to make database
		@mysql_query('CREATE DATABASE IF NOT EXISTS '.$name);
		
		//Test database
		@mysql_select_db($name) or die('3');
		
		//Write to file
$file = '<?php
if(!defined("INSIDE")){ die("attemp hacking"); }

$dbsettings = Array(
"server"     => "'.$server.'",	// MySQL server name.
"user"       => "'.$user.'",		// MySQL username.
"pass"       => "'.$pass.'",		// MySQL password.
"name"       => "'.$name.'",		// MySQL database name.
"prefix"     => "{{~databaseprefix~}}",		// Tables prefix.
"secretword" => "{{~cookiename~}}",		// Cookies.
"type"       => "mysql");		// Database type
?>';

		$handle = @fopen("./game/config1.php", 'w') or die("2");
		fwrite($handle, $file);
		fclose($handle);
		
		die('0');
		
		break;
		
	case "importdatabase":
		//Check the database connections
		
		//Get variables
		include('./game/config1.php');
		$cookies = $_GET['cookies'];
		$prefix = $_GET['prefix'];
		
		//Connect
		@mysql_connect($dbsettings['server'], $dbsettings['user'], $dbsettings['pass']) or die('1');
		
		//Select database
		@mysql_select_db($dbsettings['name']) or die('2');
		
		//Now update database
		$sql = @file_get_contents ('./install/database.sql');
		
		//Check size
		if(strlen($sql) < 25){ die('4'); }
		
		//Do some replaces
		$sql = str_replace("{{prefix}}",$prefix,$sql);
		$sql = str_replace("{{cookies}}",$cookies,$sql);
		
		//Log
		//$handle = @fopen("./install/sql.log", 'w');
		//fwrite($handle, $sql);
		//fclose($handle);
		
		//Separate statments
		$q = explode(";\n",$sql);
		
		//Remove last statement
		unset($q[sizeof($q) - 1]);
		
		//Loop statements
		foreach ($q as $query){
			//Import
			@mysql_query($query) or die('5 - '.mysql_error());
		}
		
		//Update the config1.php file
		$config = @file_get_contents('./game/config1.php');
		
		//Update config
		$config = str_replace("{{~databaseprefix~}}",$prefix,$config);
		$config = str_replace("{{~cookiename~}}",$cookies,$config);
		
		//Write to file
		$handle = @fopen("./game/config1.php", 'w') or die("3");
		fwrite($handle, $config);
		fclose($handle);
		
		//Update status
		$status = @file_get_contents ('./status');
		$status = str_replace('NOTINSTALLED','INSTALLED',$status);
		
		$handle = @fopen('./status', 'w') or die("6");
		fwrite($handle, $status);
		fclose($handle);		
		
		die('0');
		
		break;
	
	default:
		//Welcome
		include('./install/page1.html');
		
		break;

}

?>
