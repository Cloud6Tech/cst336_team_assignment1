<?php
	session_start();
	
	// Redirect to login page if not logged in	
	if(empty($_SESSION['username'])) { header("Location: login.php"); } 

	// Open database connection
	require 'db_connection.php';
	
	function getAdmissionsInfo() {
		global $dbConn;
		
		$sql = "SELECT admissions_offices.phone, admissions_offices.website, public_universities.name 
				FROM admissions_offices
				INNER JOIN public_universities
				ON public_universities.public_university_id = admissions_offices.public_university_id
				WHERE admissions_offices.public_university_id = :univId"; 
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
				<tr><th><?= htmlentities($univInfo['name']) ?></th></tr>
				<tr><td><?= $univInfo['phone'] ?></td></tr>
				<tr><td><a href='<?= $univInfo['website'] ?>'><?= $univInfo['website'] ?></a></td></tr>
				<tr><td>
					<form method='post' action='updateList.php'>
						<input type="hidden" name="redirect" value="admissions.php?id=<?=$_GET['id']?>">
						<input type="hidden" name="univId" value=<?=$_GET['id']?>>
						<?php
							include 'updateList.php';
							
							if (inUserList($_GET['id'])) {
								echo '<input type="submit" name="remove" value="Remove from My List">';
							} else {
								echo '<input type="submit" name="add" value="Add to My List">';
							}
					?>
					</form>
				</td></tr>
			</table>
			
		</div>
	
	</body>

	<?php $dbConn = null; // Close connection ?>
</html>