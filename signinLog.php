<?php
session_start();

// Redirect to login page if not logged in
if(empty($_SESSION['username'])) { header("Location: login.php"); } 

?>

<?php

	require 'db_connection.php'; //credentials for data base login
	
	//pulls login times related to username
	echo "Hello " . $_SESSION['firstName'];
	
	$sql = "SELECT * FROM userLog
				 WHERE username = :username";
		
			$stmt = $dbConn -> prepare($sql);
			$stmt -> execute(array (":username" => $_SESSION['username']));
			$userLogs = $stmt -> fetchALL();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Sign In Log</title>
		<meta name="Sign In Log<" content="">
		<meta name="author" content="masonm">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
				
		<style>
			body{background-color: #CCCCCC}
			form{display: inline}
		</style>
		
	</head>


	<body>
		<h3> Your Login History </h3>
		
		
		
	<?php
		//prints user logs oldest to newest
		$userRecord = 0;
		foreach ($userLogs as $log) 
		{
			$userRecord++;
			echo "Record " . $userRecord . ": " . $log['loginTime'];	
		}
	
	
	?>




	</body>
<?php $dbConn = null; // Close connection ?>
</html>