<?php
session_start();
?>

<?php
	
	if (isset($_POST['username']) && isset($_POST['password']))
		{

			require './db_connection.php'; //credentials for data base login
			//atempt to pull user info based on password and username provided in form
			$sql = "SELECT * FROM adminTable 
				 WHERE username = :username 
				 AND password = :password";
		
			$stmt = $dbConn -> prepare($sql);
			$stmt -> execute(array (":username" => $_POST['username'],
							":password" => hash("sha1",$_POST['password'])));
			$record = $stmt -> fetch();
		
		
			//if record is found session variables are stored and user is directed to a new page
			if (!empty($record))
			{
				
				$sql = "INSERT INTO userLog
						(username)
						VALUES
						(:username)";
				$stmt = $dbConn -> prepare($sql);
				$stmt -> execute(array (":username" => $_POST['username']));
				
				$_SESSION['username'] = $record['username'];
				$_SESSION['firstName'] = $record['firstName'];
				header("Location: changePassword.php");
				//header("Location:http://hosting.otterlabs.org/classes/lloydjasonk/html/week4/assignment4.php");
			}
			else 
			{
			echo "incorrect username or password";	
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

		<title>Team Assignment Login</title>
		<meta name="Team Assignment Login<" content="">
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
		<h3> Site Login </h3>
		
		<form method="post">
			username:
			<input type='text' name='username' placeholder="username" />
			<br>
			password:
			<input type='password' name='password' placeholder="password" />
			<input type= 'submit' />			
		</form>
		<br>
		<a href="createAccount.php">Click here to create an account</a>
		
	</body>
</html>