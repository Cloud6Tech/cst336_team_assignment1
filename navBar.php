<div id="navBar">
	<?php
		if(!empty($_SESSION['username'])) {
			echo "Welcome, <a href='changePassword.php'>" . $_SESSION['username'] . "</a> | ";
			echo "<a href='editSchools.php'>Edit DB</a> | ";
			echo "<a href='logout.php'>Logout</a>";
		}
	?>
	
	<a href="findSchool.php" class="titleLink"><h1>California Public University Admissions Database</h1></a>
</div>
