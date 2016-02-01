<?php
session_start();

// Redirect to login page if not logged in
if(empty($_SESSION['username'])) { header("Location: login.php"); } 
?>

<?php

	// Verify user has set all fields	
	if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirm'])  )
	{
		require './db_connection.php'; // Credentials for data base login
		
			
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

		<title>Update Password</title>
		<meta name="Update Password" content="">
		<meta name="author" content="masonm">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		
		<link rel="stylesheet" type="text/css" href="univ.css">
		
	</head>


	<body>
		<?php include 'navBar.php' ?>
		<div class="accountForm">
			<h3> Update your password </h3>
			
			<form method="post">
				<table>
					<tr>
						<th>Current password:</th>
						<td><input type='password' name='oldPassword' placeholder="password" required/></td>
					</tr>
					<tr>
						<th>New password:</th>
						<td><input type='password' name='newPassword' placeholder="new password" required/></td>
					</tr>
					<tr>
						<th>Confirm:</th>
						<td><input type='password' name='confirm' placeholder="confirm password" required /></td>
					</tr>
					<tr>
						<td colspan="2"><input type= 'submit' /></td>
					</tr>
				</table>
			</form>
			<!--<br>
			<a href="signinLog.php"><h3>View your login history</h3></a>-->
		</div>
	</body>
<?php $dbConn = null; // Close connection ?>
</html>