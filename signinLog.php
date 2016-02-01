<?php
session_start();

// Redirect to login page if not logged in
if(empty($_SESSION['username'])) { header("Location: login.php"); } 

?>

<?php

	require 'db_connection.php'; //credentials for data base login
	
	//pulls login times related to username
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
				
		<link rel="stylesheet" type="text/css" href="univ.css">
		
	</head>


	<body>
		<?php include 'navBar.php' ?>
		
		<h3> Your Login History 
			<form action='changePassword.php'>
				<input type='submit' value='Go Back'>
			</form>
		</h3>
		
	<?php
		//prints user logs oldest to newest
		$userRecord = 0;
		foreach ($userLogs as $log) 
		{
			$userRecord++;
			echo "Record " . $userRecord . ": " . $log['loginTime'] . "<br>";	
		}
	?>
	
	




	</body>
<?php $dbConn = null; // Close connection ?>
</html>