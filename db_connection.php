<?php
    $host = "localhost";
	$dbname = "maso1047"; //otterID
	$username = "maso1047"; //otter ID
	$password = "abc1234"; //database account password

	try
	{
		//establishes database connection
		$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	}
	catch (Exception $e)
	{
		echo "Unable to connect to data base!";
		exit();	
	}
	
	//shows errors when connecting to database
	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
?>