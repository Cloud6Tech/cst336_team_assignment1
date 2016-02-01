<?php
	if (!isset($_SESSION)) { session_start(); }	

	require_once 'db_connection.php';
		
	// Create user school list table to store user's "My List" schools if one doesn't exist
	$sql= "CREATE TABLE IF NOT EXISTS `user_university_list` 
				(
				`listId` int(11) NOT NULL AUTO_INCREMENT,
 				`username` varchar(50) NOT NULL,
 				`univId` smallint(4) NOT NULL,	
  				PRIMARY KEY (`listId`)
				)";
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute();
	
	// Check user's list for specific university id
	function inUserList($univId) {
		global $dbConn;
		
		$sql = "SELECT listId
				FROM user_university_list
				WHERE username = :username
				AND univId = :univId";
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute( array(':username' => $_SESSION['username'],
								':univId' => $univId));
		$results = $stmt->fetch();

		if ($results == NULL) {
			return false;
		} else {
			return true;
		}
	}

	// Add a school to the user's list
	if (isset($_POST['add'])) {
		if (!inUserList($_POST['univId'])) {			
			$sql = "INSERT INTO user_university_list (username, univId)
					VALUES (:username,:univId)";
			$stmt = $dbConn -> prepare($sql);
			$stmt -> execute( array(":username" => $_SESSION['username'],
									"univId" => $_POST['univId']));		
		}
		// Go back to the page that submitted this request
		header('Location: ' . $_POST['redirect']); 
	}
	
	// Remove a school from the user's list
	if (isset($_POST['remove'])) {
		if (inUserList($_POST['univId'])) {
			global $dbConn;
			
			$sql = "DELETE FROM user_university_list
					WHERE username = :username
					AND univId = :univId";
			$stmt = $dbConn -> prepare($sql);
			$stmt -> execute( array(':username' => $_SESSION['username'],
									':univId' => $_POST['univId']));
		}
									
		// Go back to the page that submitted this request
		header('Location: ' . $_POST['redirect']); 
	}
 
?>
