<nav>
<img src="public/images/TaskyLogo.png" width="10%" />
<a href="logout.php">Uitloggen</a>
<a href="add.php">Lijst toevoegen</a>
<?php
if ($userRow['admin'] == 1) {
	echo "<a href='admin.php'>Vakken toevoegen</a>";
} else {
	//do nothing
}
?>
</nav>