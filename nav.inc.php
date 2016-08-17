<nav>
<a href="home.php" id="logo" ><img src="public/images/TaskyLogo.png" width="25%" /></a>
<a href="logout.php">Uitloggen</a>
<a href="add.php">Lijst toevoegen</a>
<?php
if ($userRow['admin'] == 1) {
	echo "<a href='admin.php'>Vakken toevoegen</a>";
} else {
	//do nothing
}
?>
<a href="home.php">Mijn Lijsten</a> 
<a href="lijsten.php">Gedeelde Lijsten</a> 
</nav>