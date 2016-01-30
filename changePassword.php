<?php
session_start();
?>

<?php

	//verfires user has logged in. reverts back to login page if not
	if(!isset($_SESSION['username']))
	{
		header("Location: login.php");
	}
	
	echo "Hello " . $_SESSION['firstName'];


	//verifies user has set all feilds	
	if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirm'])  )
	{
		require './db_connection.php'; //credentials for data base login
		
			
		if ($_POST['newPassword'] == $_POST['confirm'])
		{
			$sql = "UPDATE adminTable
					SET password = :newPassword
					WHERE username = :username AND password = :oldPassword";
					
			$stmt = $dbConn -> prepare($sql);
			$stmt -> execute(array(":username" => $_SESSION['username'],
							":newPassword" => hash("sha1", $_POST['newPassword']),
							":oldPassword" => hash("sha1", $_POST['oldPassword'])));
			
			echo "<p>Password updated!</p>";	
			}
			
			else 
			{
			echo	"passwords do not match";
			}
			
		}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Upadate Password</title>
		<meta name="Update Password" content="">
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
		<h3> Update your password </h3>
		
		<form method="post">

			old password:
			<input type='password' name='oldPassword' placeholder="password" required/>
			<br>
			new password:
			<input type='password' name='newPassword' placeholder="new password" required/>
			<br>
			confirm:
			<input type='password' name='confirm' placeholder=" confirm password" required />
			<input type= 'submit' />
				
		</form>
		<br>
		<a href="login.php">back to login page</a>
		<br>
		<a href="signinLog.php">Veiw your login history</a>
	</body>
</html>