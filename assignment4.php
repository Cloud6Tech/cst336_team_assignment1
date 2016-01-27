
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Assignment 4</title>
  <meta name="description" content="">
  <meta name="author" content="Jason Lloyd">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  
<?php
  require 'connection.php';
 
  function getAllUniversities() {
  	global $dbConn;
	$sql = "SELECT *
			FROM public_universities 
			ORDER BY name";
	$stmt = $dbConn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  
  function addUniversity($name, $code) {
  	
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
  
  function updateCity($id, $city) {
  	
  }
  
  function updateCounty($id, $county) {
  	
  }
  
  function updateSystem($id, $system) {
  	
  }
  
  function updateFounded($id, $year) {
  	
  }
  
  function updateStudents($id, $number) {
  	
  }
  
  function updateAcceptanceRate($id, $rate) {
  	
  }
?>

</head>

<body>
  <div id="wrapper">
    <h2>Public Universities</h2>
      
    <form name="schoolQuery" method="get">
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
    <p>
    <?php
      
      if( isset($_GET['univId']) and $_GET['univId'] != -1) {
      	echo '<form method="post" action="updateUniversity.php">';
      	$school = getUniversityById($_GET['univId']);
		echo 'Federal School Code: ' . $school['federal_school_code'];
		echo ' <input type="hidden" name="code" value="' . $_GET['univId'] . '">';
		echo ' <input type="submit" name="code" value="Update"><br/>';
		echo 'City: ' . $school['city'];
		echo ' <input type="hidden" name="city" value="' . $_GET['univId'] . '">';
		echo ' <input type="submit" name="city" value="Update"><br/>';
		echo 'County: ' . $school['county'];
		echo ' <input type="hidden" name="county" value="' . $_GET['univId'] . '">';
		echo ' <input type="submit" name="county" value="Update"><br/>';  
		echo 'Founded: ' . $school['founded'];
		echo ' <input type="hidden" name="founded" value="' . $_GET['univId'] . '">';
		echo ' <input type="submit" name="founded" value="Update"><br/>'; 
		echo 'Acceptance Rate (Fall 2015): ' . $school['fall_2015_acceptance_percentage'] . '%';
		echo ' <input type="hidden" name="acceptanceRate" value="' . $_GET['univId'] . '">';
		echo ' <input type="submit" name="acceptanceRate" value="Update"><br/>';
		echo 'Students: ' . $school['students'];
		echo ' <input type="hidden" name="students" value="' . $_GET['univId'] . '">';
		echo ' <input type="submit" name="students" value="Update"><br/>'; 
		echo '</form>';
		echo '<h3>Admissions Info</h3>';
		echo '<form method="post" action="updateAdmissions.php">';
		$admissions = getAdmissionsOffice($_GET['univId']);
		echo 'Website: ' . $admissions['website'];
		echo ' <input type="hidden" name="website" value="' . $admissions['admissions_offices_id'] . '">';
		echo ' <input type="submit" name="website" value="Update"><br/>';
		echo 'Phone: ' . $admissions['phone'];
		echo ' <input type="hidden" name="phone" value="' . $admissions['admissions_offices_id'] . '">';
		echo ' <input type="submit" name="phone" value="Update"><br/>';
      }    
	?>
	</p>
  </div>
</body>
</html>