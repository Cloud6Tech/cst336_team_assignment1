<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Edit University Data</title>
  <meta name="description" content="">
  <meta name="author" content="Jason Lloyd">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <?php
    require 'db_connection.php';
	
	function isAdmin($username) {
		global $dbConn;
		$sql = 'SELECT isAdmin FROM user WHERE username = :username';
		$stmt = $dbConn->prepare($sql);
		$stmt->execute(array(":username" => $_SESSION['username']));
		$record = $stmt->fetch();
		return $record[0];			
	}
	
	function getAllUniversities() {
  		global $dbConn;
		$sql = "SELECT *
				FROM public_universities 
				ORDER BY name";
		$stmt = $dbConn->prepare($sql);
    	$stmt->execute();
    	return $stmt->fetchAll();
  	}
	
	function getUniversityById($id) {
  		global $dbConn;
		$sql = "SELECT *
				FROM public_universities
				WHERE public_university_id = " . $id;		
		$stmt = $dbConn->prepare($sql);
    	$stmt->execute();
    	return $stmt->fetch();
  	}
	
	function getAdmissionsOffice($schoolId) {
  		global $dbConn;
		$sql = "SELECT * 
			FROM admissions_offices
			WHERE public_university_id = " . $schoolId;
		$stmt = $dbConn->prepare($sql);
    	$stmt->execute();
    	return $stmt->fetch();
  	}
  	if(($_SESSION['username']) and isAdmin($_SESSION['username'])) {
  		$isAdmin = true;
  	} else {
  		echo 'You are not an admin. Click <a href="findSchool.php">here</a> to go back.';
  	}
  ?>

</head>

<body>
  <?php
    if (isset($isAdmin) and $isAdmin) {
  ?>
  <div>
    <h2>Database Editor</h2>
    <div id="instructions">
    	Select a University from the list. Then edit the fields below.
    	Click "Update" to commit your changes to the database.
    </div>

    <div>
    <form name="selectSchool" method="get">
      <select name="univId">
      	<option value="-1"> - Select School -</option>
      	<?php
      	  $univList = getAllUniversities();
          foreach ($univList as $univ) {
		    print '<option value=' . $univ['public_university_id'];
			if(isset($_GET['univId']) and $_GET['univId'] == $univ['public_university_id']){
				echo ' selected="1" ';
			}  
		    print '>' . htmlentities($univ['name']) . '</option>';
		  }
		?>
      </select>
      <input type="submit" value="Get School Info" />
    </form>
    <form name="addUniversity">
    	<input type="submit" value="Add University">
    </form>
    </div>
    <?php
      if( isset($_GET['univId']) and $_GET['univId'] != -1) {
      	echo '<div>';
      	echo '<form method="post" action="updateUniversity.php">';
		echo '<input type="hidden" name="code" value="' . $_GET['univId'] . '">';
		echo '<table>';
      	$school = getUniversityById($_GET['univId']);
		echo '<tr><td>Federal School Code:</td>';
		echo '<td><input type="number" size="6" name="code" value="' . $school['federal_school_code'] . '"/>' . '</td></tr>';
		echo '<tr><td>City:</td>';
		echo '<td><input type="text" name="city" value="' . $school['city'] . '"/>' . '</td></tr>';
		echo '<tr><td>County:</td>';
		echo '<td><input type="text" name="county" value="' . $school['county'] . '"/>' . '</td></tr>';
		echo '<tr><td>Founded:</td>';
		echo '<td><input type="number" size="5" min="1900" max="2016" value="' . $school['founded'] . '"/>' . '</td></tr>';
		echo '<tr><td>Acceptance Rate<br> (Fall 2015):</td>';
		echo '<td><input type="number" min="1" max="100" value="' . $school['fall_2015_acceptance_percentage'] . '"/>' . '%</td></tr>';
		echo '<tr><td>Students:</td>';
		echo '<td><input type="number" size="8" value="' . $school['students'] . '"/>' . '</td></tr>';
		echo '<tr><td><input type="submit" value="Update"></td></tr>';
		echo '</table>'; 
		echo '</form>';
		echo '<h3>Admissions Info</h3>';
		echo '<form method="post" action="updateAdmissions.php">';
		$admissions = getAdmissionsOffice($_GET['univId']);
		echo '<input type="hidden" name="code" value="' . $admissions['admissions_offices_id'] . '">';
		echo '<table>';
		echo '<tr><td>Website:</td>';
		echo '<td><input type="text" size="30" value="' . $admissions['website'] . '"/>' . '</td></tr>';
		echo '<tr><td>Phone:</td>';
		echo '<td><input type="text" size="12" value="' . $admissions['phone'] . '"/>' . '</td></tr>';
		echo '<tr><td><input type="submit" value="Update"></td></tr>';
		echo '</table>';
		echo '</form>';
		echo '</div>';
      } 
    ?>

  </div>
  <?php
	}
  ?>
</body>
</html>
