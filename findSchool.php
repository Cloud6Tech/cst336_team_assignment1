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

  <title>Pick your perfect school!</title>
  <meta name="description" content="">
  <meta name="author" content="Jason Lloyd">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  
  <link rel="stylesheet" type="text/css" href="univ.css">

  <?php
    require 'db_connection.php';
	
    function getSystems() {
    	global $dbConn;
    	$sql = "SELECT college_system 
    			FROM public_universities
    			GROUP BY college_system";
		$stmt = $dbConn->query($sql);
		return $stmt->fetchAll();
    }
  
    function getCounties() {
    	global $dbConn;
		$sql = "SELECT county 
				FROM public_universities
				GROUP BY county";
		$stmt = $dbConn->query($sql);
		return $stmt->fetchAll();
    }
	
	function getSchools($where) {
		global $dbConn;
		$sql = "SELECT 
				  public_university_id,
		          federal_school_code, 
				  college_system,
				  name, 
				  city, 
				  county, 
				  students,
				  fall_2015_acceptance_percentage
				FROM public_universities "
				. $where;
		if(isset($_GET['sort'])) {
			switch($_GET['sort']){
				case "name":
					$sql .= ' ORDER BY name';
					break;
				case "city":
					$sql .= ' ORDER BY city';
					break;
				case "size":
					$sql .= ' ORDER BY students';
					break;
				case "rate":
					$sql .= ' ORDER BY fall_2015_acceptance_percentage';
					break;
			}
		}
		$stmt = $dbConn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();		
	}
	
	if (isset($_POST['submit'])) {
		$where = "WHERE ";
		if (isset($_POST['system']) and $_POST['system'] != "") {
			$where .= "college_system = ";
			$where .= '"' . $_POST['system'] . '"';
			$where .= " AND ";
		}
		if (isset($_POST['county']) and $_POST['county'] != "") {
			$where .= "county = ";
			$where .= '"'. $_POST['county'] . '"';
			$where .= " AND ";
		}
		if (isset($_POST['maxStudents']) and $_POST['maxStudents'] != "") {
			$where .= "students < ";
			$where .= $_POST['maxStudents'];
			$where .= " AND ";
		}
		$where .= "public_university_id IS NOT NULL ";
		$_SESSION['where'] = $where;
	} else if (isset($_SESSION['where'])) {
		$where = $_SESSION['where'];
	}
	
	
  ?>

</head>

<body>
	<?php include 'navBar.php' ?>
  <div>

	<h3 style="text-align:center;">Welcome to Cloud6 Tech's School Finder</h3>
		
	<p style="text-align:center;">. Select the options that mean the most to you, and hit submit!</p>
	
  </div>	
  <div border="1">
	<form method="POST">
		<table id="schoolFinder">
			<tr>
				<td>System:</td>
				<td><select name="system">
						<option value=""> Any </option>
						<?php
						$systems = getSystems();
						foreach($systems as $system){
							echo '<option value="' . $system['college_system'] . '">' . $system['college_system'] . '</option>';
						}
						?>
				</select></td>
			</tr>
			<tr>
				<td>County:</td>
				<td>
					<select name="county"> 
						<option value=""> Any </option>
						<?php
						$counties = getCounties();
						foreach($counties as $county){
							echo '<option value="' . $county['county'] . '">' . $county['county'] . '</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Number of Students:</td>
				<td>
					<select name="maxStudents">
						<option value=""> Any </option>
						<option value="10000"> less than 10,000</option>
						<option value="25000"> less than 25,000</option>
						<option value="100000"> over 25,000</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="submit" type="submit"/> <input type="reset"/>
				</td>
			</tr>
		</table>
	</form>
  </div>
  <?php
    if (isset($_POST['submit']) or isset($_SESSION['where'])) {
  ?>
  <div id="results">
  	<form>
  		<table id="showSchools">
  			<tr>
  				<th>Federal<br/>Code</th>
  				<th>System</th>
  				<th><a href="findSchool.php?sort=name">University</a></th>
  				<th><a href="findSchool.php?sort=city">City</a></th>
  				<th>County</th>
  				<th><a href="findSchool.php?sort=size">Student Size</a></th>
  				<th><a href="findSchool.php?sort=rate">Acceptance<br/> Rate (%)</a></th>
  			</tr>
  			<?php
  			  $records = getSchools($where);
  			  foreach($records as $record) {
  			  	echo '<tr>';
				for ($i = 0; $i < count($record)/2; $i++) {
				  if ($i != 0) {
				  	echo '<td>';	
				    if ($i == 3) {
				  	  echo '<a href=admissions.php?id=' . $record[0] . '>';
					  echo htmlentities($record[$i]);
					  echo '</a>';
					} else {
				  	echo htmlentities($record[$i]);
					}
					echo '</td>';
				  } 
				}
				echo '</tr>';				
  			  }
			?>
  		</table>
  	</form>
  </div>
  <?php
	}
  ?>
</body>
<?php $dbConn = null; // Close connection ?>
</html>
