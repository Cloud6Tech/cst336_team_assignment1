<?php
	require_once './db_connection.php'; //credentials for data base login

		// creat table for user login 
		$sql= "CREATE TABLE IF NOT EXISTS `userLog` 
			(
 			`username` varchar(50),
 			`loginTime` timestamp NOT NULL DEFAULT NOW()
			)";
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute();			
?>