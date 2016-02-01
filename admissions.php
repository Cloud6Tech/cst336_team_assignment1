<?php
	// Open database connection
	require 'db_connection.php';
	
	function getAdmissionsInfo() {
		global $dbConn;
		
		$sql = "SELECT admission_offices.phone, admission_offices.website, public_universities.name 
				FROM admission_offices
				INNER JOIN public_universities
				ON public_universities.public_university_id = admission_offices.public_university_id
				WHERE admission_offices.public_university_id = :univId"; 
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute(array (":univId" => $_GET['id']));
		return $stmt->fetch();
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
		
		<div id="admissionsInfo">
			<?php
				// Get university admissions info
				$univInfo = getAdmissionsInfo();
			?>
			
			<table class="admissionsInfo">
				<tr><th><?= $univInfo['name'] ?></th></tr>
				<tr><td><?= $univInfo['phone'] ?></td></tr>
				<tr><td><a href='<?= $univInfo['website'] ?>'><?= $univInfo['website'] ?></a></td></tr>
			</table>
			
		</div>
	
	</body>

</html>