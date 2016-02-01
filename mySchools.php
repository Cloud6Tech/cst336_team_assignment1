<?php
	session_start();	

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
		
		$sql = "SELECT admission_offices.phone, admission_offices.website, public_universities.name 
				FROM admission_offices
				INNER JOIN public_universities
				ON public_universities.public_university_id = admission_offices.public_university_id
				WHERE admission_offices.public_university_id = :univId"; 
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
		
		<title>Admissions Information</title>
		
		<link rel="stylesheet" type="text/css" href="univ.css">
	</head>
	
	<body>
		<?php include 'navBar.php' ?>
							
			<?php $schools = getList(); ?>
			
			
			<table>
				<tr><th>School</th><th>Phone</th><th>Website</th><th>Actions</th></tr>
				
				<?php
					foreach ($schools as $school) {
						echo "<tr>";
							echo "<td>" . $school[2] . "</td>";  // Name
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
	</body>
</html>