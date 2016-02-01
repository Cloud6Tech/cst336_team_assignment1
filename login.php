<?php
session_start();
session_destroy();
session_start();
?>

<?php
	
	if (isset($_POST['username']) && isset($_POST['password']))
		{

			require 'db_connection.php'; //credentials for data base login
			//attempt to pull user info based on password and username provided in form
			$sql = "SELECT * FROM user 
				 WHERE username = :username 
				 AND password = :password";
		
			$stmt = $dbConn -> prepare($sql);
			$stmt -> execute(array (":username" => $_POST['username'],
							":password" => hash("sha1",$_POST['password'])));
			$record = $stmt -> fetch();
		
		
			//if record is found session variables are stored and user is directed to a new page
			if (!empty($record))
			{
				
				//$sql = "INSERT INTO userLog (username) VALUES (:username)";
				//$stmt = $dbConn -> prepare($sql);
				//$stmt -> execute(array (":username" => $_POST['username']));
				
				$_SESSION['username'] = $record['username'];
				$_SESSION['firstName'] = $record['firstName'];
				header("Location: findSchool.php");
	
			}
			else 
			{
			$invalidLogon = true;	
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
				
		<link rel="stylesheet" type="text/css" href="univ.css">
		
	</head>


	<body>
		<?php include 'navBar.php' ?>
		
		<div class="accountForm">
			<h3> Site Login </h3>
			<form method="post">
		          <table>
					<tr>
					  <td>username:</td>
					  <td><input type="text" name="username" placeholder="username" /></td>
					</tr>
					<tr>
					  <td>password:</td>
					  <td><input type="password" name="password" placeholder="password" /></td>
					</tr>
					<tr>
					  <td colspan="2" style="text-align: right"><input type="submit" /> <input type="reset" /></td>			
				 </table>
			</form>
			<br><a href="createAccount.php">Click here to create an account.</a>
			<?php 
			 if(isset($invalidLogon) and $invalidLogon == true) {
			 	echo '<p>Invalid Username or Password</p>';
			 }
			?>
		</div>

	</body>
</html>