<?php 
	require_once 'db_connection.php';
	
	function isAdminCheck(){
		global $dbConn;
		
		$sql = "SELECT isAdmin
				FROM user
				WHERE username = :userName";
				
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute(array (":userName" => $_SESSION['username']));
		$result = $stmt->fetch();
		return $result[0];
	}
?>

<div id="navBar">
	<?php
		if(!empty($_SESSION['username'])) {
			echo "Welcome, <a href='changePassword.php'>" . $_SESSION['username'] . "</a> | ";
			echo "<a href='findSchool.php'>Find a School</a> | ";
			if (isAdminCheck()) { echo "<a href='editSchools.php'>Edit DB</a> | 
				<a href='signinLog.php'> User Log</a> |"; }
			echo "<a href='mySchools.php'> My Schools</a> | ";
			echo "<a href='logout.php'>Logout</a>";
		}
	?>
	
	<a href="findSchool.php" id="titleLink"><h1>California Public University Admissions Database</h1></a>
</div>
