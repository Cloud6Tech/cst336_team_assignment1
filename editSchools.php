<?php
	session_start();
	
	// Redirect to login page if not logged in
	if(empty($_SESSION['username'])) { header("Location: login.php"); } 
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
  <link rel="stylesheet" type="text/css" href="univ.css">
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
	
	function updateUniversity() {
		global $dbConn;
		$sql = "UPDATE public_universities SET 
				city = :city, 
				county = :county, 
				fall_2015_acceptance_percentage =:rate, 
				federal_school_code = :code, 
				founded = :founded, 
				students = :students 
				WHERE public_university_id = :id";
		$stmt = $dbConn->prepare($sql);
		return $stmt->execute(array(
		 ":city" => $_POST['city'],
		 ":county" => $_POST['county'],
		 ":rate" => $_POST['rate'],
		 ":code" => $_POST['code'],
		 ":founded" => $_POST['founded'],
		 ":students" => $_POST['students'],
		 ":id" => $_POST['id']));
	}
	
	function updateAdmissions() {
		global $dbConn;
		$sql = "UPDATE admissions_offices SET
			   phone = :phone,
			   website = :website
			   WHERE admissions_offices_id = :id";
		$stmt = $dbConn->prepare($sql);
		return $stmt->execute(array(
		  ":phone" => $_POST['phone'],
		  ":website" => $_POST['website'],
		  ":id" => $_POST['id']));
	}
	
	function addUniversity()
	{
		global $dbConn;
		
		$sql = "INSERT INTO public_universities (federal_school_code, name, city, county, college_system, founded, students, fall_2015_acceptance_percentage)
					VALUES (:code,:name,:city,:county,:college_system,:founded,:students,:rate)";
			$stmt = $dbConn -> prepare($sql);
			return $stmt -> execute( array(":code" => $_POST['newCode'],
									":name" => $_POST['newName'],
									":city" => $_POST['newCity'],
									":county" => $_POST['newCounty'],
									":college_system" => $_POST['newCollegeSystem'],
									":founded" => $_POST['newFounded'],
									":students" => $_POST['newStudents'],
									":rate" => $_POST['newRate']));	
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
  <?php include 'navBar.php' ?>
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
      <input type="submit" name="newSchool" value="Add New School" />
    </form>
    </div>
    <?php
      echo '<div id="updateUniversityStatus">';
      if (isset($_POST['updateUniversity'])) {
      	
      	if( updateUniversity() ) {
      		echo "<p><b>Update Succeeded!</b></p>";
      	} else {
      		echo "<p><b>Update Failed</b></p>";
      	}		
	  } 
      echo '</div>'; 
	  
	  //Allows the addition of a new school
	  if (isset($_GET['newSchool']))
	  {
	  	echo '<div>';
      	echo '<form method="post">';
		echo '<table>';
		echo '<tr><td>School Name:</td>';
		echo '<td><input type="text" name="newName" value="' . '"/>' . '</td></tr>';
		echo '<tr><td>Federal School Code:</td>';
		echo '<td><input type="number" size="6" name="newCode" value="' . '"/>' . '</td></tr>';
		echo '<tr><td>City:</td>';
		echo '<td><input type="text" name="newCity" value="' . '"/>' . '</td></tr>';
		echo '<tr><td>County:</td>';
		echo '<td><input type="text" name="newCounty" value="' . '"/>' . '</td></tr>';
		echo '<tr><td>College System:</td>';
		echo '<td><input type="text" name="newCollegeSystem" value="' . '"/>' . '</td></tr>';
		echo '<tr><td>Founded:</td>';
		echo '<td><input type="number" name="newFounded" size="5" min="1900" max="2016" value="' . '"/>' . '</td></tr>';
		echo '<tr><td>Acceptance Rate<br> (Fall 2015):</td>';
		echo '<td><input type="number" name="newRate" min="1" max="100" value="' . '"/>' . '%</td></tr>';
		echo '<tr><td>Students:</td>';
		echo '<td><input type="number" size="8" name="newStudents" value="' . '"/>' . '</td></tr>';
		echo '<tr><td><input type="submit" name="addUniversity" value="Add"></td></tr>';
		if ( isset($_POST['addUniversity'])) {	
      	  if( addUniversity() ) 
      	  {
      		echo "<p><b>New School Added Successfully</b></p>";
      	  } 
      	  else 
      	  {
      		echo "<p><b>Failed to Add New School</b></p>";
      	  }
        }		
		echo '</table>';
		echo '</form>';
		echo '</div>';
	  }
	  
      if( isset($_GET['univId']) and $_GET['univId'] != -1 and !isset($_GET['newSchool'])) {
      	echo '<div>';
      	echo '<form method="post">';
		echo '<input type="hidden" name="id" value="' . $_GET['univId'] . '">';
		echo '<table>';
      	$school = getUniversityById($_GET['univId']);
		echo '<tr><td>Federal School Code:</td>';
		echo '<td><input type="number" size="6" name="code" value="' . $school['federal_school_code'] . '"/>' . '</td></tr>';
		echo '<tr><td>City:</td>';
		echo '<td><input type="text" name="city" value="' . $school['city'] . '"/>' . '</td></tr>';
		echo '<tr><td>County:</td>';
		echo '<td><input type="text" name="county" value="' . $school['county'] . '"/>' . '</td></tr>';
		echo '<tr><td>Founded:</td>';
		echo '<td><input type="number" name="founded" size="5" min="1900" max="2016" value="' . $school['founded'] . '"/>' . '</td></tr>';
		echo '<tr><td>Acceptance Rate<br> (Fall 2015):</td>';
		echo '<td><input type="number" name="rate" min="1" max="100" value="' . $school['fall_2015_acceptance_percentage'] . '"/>' . '%</td></tr>';
		echo '<tr><td>Students:</td>';
		echo '<td><input type="number" size="8" name="students" value="' . $school['students'] . '"/>' . '</td></tr>';
		echo '<tr><td><input type="submit" name="updateUniversity" value="Update"></td></tr>';
		echo '</table>'; 
		echo '</form>';
		echo '<h3>Admissions Info</h3>';
		echo '<div id="updateAdmissionsStatus">';
		if ( isset($_POST['updateAdmissions'])) {	
      	  if( updateAdmissions() ) {
      		echo "<p><b>Update Succeeded!</b></p>";
      	  } else {
      		echo "<p><b>Update Failed</b></p>";
      	  }
        }
		echo '</div>';		
		echo '<form method="post">';
		$admissions = getAdmissionsOffice($_GET['univId']);
		echo '<input type="hidden" name="id" value="' . $admissions['admissions_offices_id'] . '">';
		echo '<table>';
		echo '<tr><td>Website:</td>';
		echo '<td><input type="text" name="website" size="50" value="' . $admissions['website'] . '"/>' . '</td></tr>';
		echo '<tr><td>Phone:</td>';
		echo '<td><input type="text" name= "phone" size="12" value="' . $admissions['phone'] . '"/>' . '</td></tr>';
		echo '<tr><td><input type="submit" name="updateAdmissions" value="Update"></td></tr>';
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
<?php $dbConn = null; // Close connection ?>
</html>
