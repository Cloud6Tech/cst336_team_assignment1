<?php

	require './db_connection.php'; //credentials for data base login

		//verifies the user has entered all form items
		if (isset($_POST['createUsername']) && isset($_POST['createPassword']) && isset($_POST['confirm'])  && isset($_POST['firstName'])&& isset($_POST['lastName']))
		{
			//create admin table to store user names. can be in separate file
			$sql= "CREATE TABLE IF NOT EXISTS `user` 
				(
				`id` int(11) NOT NULL AUTO_INCREMENT,
  				`firstName` varchar(50),
 				`lastName` varchar(50),
 				`username` varchar(50),
 				`password` varchar(50),
 				`isAdmin` BOOLEAN DEFAULT FALSE,
  				PRIMARY KEY (`id`)
				)";
			$stmt = $dbConn -> prepare($sql);
			$stmt -> execute();
	        
			//Check for a dupilicate username
			$sql = "SELECT *
					FROM user
					WHERE username = :username";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute(array(":username" => $_POST['createUsername']));
			$record = $stmt->fetch();
			
			if(empty($record)) {
			  //username doesn't exist
			  //Verifies createPassword and confirm match
			  if ($_POST['createPassword'] == $_POST['confirm'])
			  {
				$sql = "INSERT INTO user
						(firstName, lastName, username, password)
						VALUES
						(:firstName, :lastName, :username, :password)";
				$stmt = $dbConn -> prepare($sql);
				$stmt -> execute(array (":firstName" => $_POST['firstName'],
		 						":lastName" => $_POST['lastName'],
		 						":username" => $_POST['createUsername'],
								":password" => hash("sha1", $_POST['createPassword'])));
				header("Location: login.php");	
			  } else {
				$invalidPassword = true;
			  }
			} else {
				$invalidUsername = true;
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

		<title>Create Account</title>
		<meta name="Create Account" content="">
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
			<h3> Create a Username and Password </h3>
			
			<form method="post">
			  <table>
			  	<tr>
			  	  <td>First Name:</td>
			  	  <td><input type='text' name='firstName' <?= (isset($_POST['firstName'])) ? "value='" . $_POST['firstName'] ."'" : "placeholder='Joe'" ?> required/></td>
				</tr>
				<tr>
				  <td>Last Name:</td>
				  <td><input type='text' name='lastName' <?= (isset($_POST['lastName'])) ? "value='" . $_POST['lastName'] ."'" : "placeholder='Smith'" ?> required/></td>
				</tr>
				<tr>
				  <td>username:</td>
				  <td><input type='text' name='createUsername' <?= (isset($_POST['createUsername']) and !isset($invalidUsername)) ? "value='" . $_POST['createUsername'] ."'" : "placeholder='username'" ?> required/></td>
				</tr>
				<tr>
					<td>password:</td>
					<td><input type='password' name='createPassword' <?= (isset($_POST['createPassword']) and !isset($invalidPassword)) ? "value='" . $_POST['createPassword'] ."'" : "placeholder='password'" ?> required/></td>
				</tr>
				<tr>
					<td>confirm:</td>
					<td><input type='password' name='confirm' <?= (isset($_POST['confirm']) and !isset($invalidPassword)) ? "value='" . $_POST['confirm'] ."'" : "placeholder='password again'" ?> required/></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" /></td>
				</tr>
			  </table>				
			</form>
			<?php 
				if(isset($invalidPassword) and $invalidPassword == true) {
					echo '<p style="color:red">Passwords do not match.</p>';
				} elseif (isset($invalidUsername) and $invalidUsername == true) {
					echo '<p style="color:red">Username is already in use.</p>';
				}
			?>
			<br>
			<a href="login.php">Go back</a>
		</div>
	</body>
<?php $dbConn = null; // Close connection ?>
</html>