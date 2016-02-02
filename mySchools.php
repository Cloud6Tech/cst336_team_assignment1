<?php
	session_start();
	
	// Redirect to login page if not logged in	
	if(empty($_SESSION['username'])) { header("Location: login.php"); } 

	// Open database connection
	require 'db_connection.php';
	
	// Echo a table containing the user's saved schools
	function getList() {
		global $dbConn;
		
		// Get user's list of university IDs
		$sql = "SELECT univId
				FROM user_university_list
				WHERE username = :username";
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute( array(':username' => $_SESSION['username']));
		$univIds = $stmt -> fetchAll();
		
		$sql = "SELECT admissions_offices.phone, admissions_offices.website, public_universities.name 
				FROM admissions_offices
				INNER JOIN public_universities
				ON public_universities.public_university_id = admissions_offices.public_university_id
				WHERE admissions_offices.public_university_id = :univId"; 
		$stmt = $dbConn -> prepare($sql);
		
		$results = array();
		foreach ($univIds as $id) {
			$stmt -> execute(array (":univId" => $id[0]));
			$schoolInfo = $stmt->fetch();
			array_push($schoolInfo,$id[0]);
			array_push($results,$schoolInfo);
		}
		return $results;
	}	
	
?>

<!DOCTYPE html>

<html lang="en">
	
	<head>
		<meta charset="UTF-8"/>
		<meta name="author" content="Heather McCabe">
		
		<title>My Schools</title>
		
		<link rel="stylesheet" type="text/css" href="univ.css">
	</head>
	
	<body>
		<?php include 'navBar.php' ?>
							
			<?php $schools = getList(); ?>
			
			<div>
			<h2 style="text-align: center">Your Previously Selected Schools</h2>
			<table id="showSchools">
				<tr><th>School</th><th>Phone</th><th>Website</th><th>Actions</th></tr>
				
				<?php
					foreach ($schools as $school) {
						echo "<tr>";
							echo "<td><a href='./admissions.php?id=" . $school[3] . "'>" . $school[2] . "</a></td>";  // Name
							echo "<td>" . $school[0] . "</td>";  // Phone
							echo "<td><a href='" . $school[1] . "'>" . $school[1] . "</a></td>";  // Website
							
							echo "<td><form method='post' action='updateList.php'>";
							echo "<input type='hidden' name='redirect' value='mySchools.php'>";
							echo "<input type='hidden' name='univId' value='" . $school[3] . "'>";
							echo "<input type='submit' name='remove' value='Remove'>";
							echo "</form></td>";
							
						echo "</tr>";
					}
				?>
			</table>
			</div>
	</body>
	<?php $dbConn = null; // Close connection ?>
</html>