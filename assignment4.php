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

  <title>Assignment 4</title>
  <meta name="description" content="">
  <meta name="author" content="Jason Lloyd">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  
<?php
  require 'db_connection.php';
 
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
		echo '<input type="hidden" name="code" value="' . $_GET['univId'] . '">';
		echo '<table>';
      	$school = getUniversityById($_GET['univId']);
		echo '<tr><td>Federal School Code:</td><td> ' . $school['federal_school_code'] . '</td></tr>';
		echo '<tr><td>City:</td><td>' . $school['city'] . '</td></tr>';
		echo '<tr><td>County:</td><td>' . $school['county'] . '</td></tr>';
		echo '<tr><td>Founded:</td><td>' . $school['founded'] . '</td></tr>';
		echo '<tr><td>Acceptance Rate<br> (Fall 2015):</td><td>' . $school['fall_2015_acceptance_percentage'] . '%</td></tr>';
		echo '<tr><td>Students:</td><td>' . $school['students']. '</td></tr>';
		echo '<tr><td><input type="submit" value="Update Info"></td></tr>';
		echo '</table>'; 
		echo '</form>';
		echo '<h3>Admissions Info</h3>';
		echo '<form method="post" action="updateAdmissions.php">';
		$admissions = getAdmissionsOffice($_GET['univId']);
		echo '<input type="hidden" name="code" value="' . $admissions['admissions_offices_id'] . '">';
		echo '<table>';
		echo '<tr><td>Website:</td><td>' . $admissions['website'] . '</td>';
		echo '<td><input type="hidden" name="website" value="' . $admissions['admissions_offices_id'] . '"></td></tr>';
		echo '<tr><td>Phone:</td><td>' . $admissions['phone'] . '</td></tr>';
		echo '<tr><td><input type="submit" value="Update"></td></tr>';
		echo '</table>';
		echo '</form>';
      }    
	?>
	</p>
  </div>
</body>
</html>