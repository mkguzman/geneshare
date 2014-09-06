<?php
$species = $_GET['species'];


/* require_once() */
	/* Makes current file act as if selected file's content is in current file */
	/* Different than require() in that require_once() will only allow the file to be accessed once and not again in the current file */
	/* Different than include() in that require() will terminate script if file is inaccessible */
	/* This specific file is added for security and stores sensitive database information in another file in variables that can be used in this file */
require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$query = "CREATE TABLE IF NOT EXISTS `species` ( speciesrid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, species VARCHAR(255) );";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->close();

$query = "INSERT INTO `species` VALUES ( '', ?);";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $species);
$stmt->execute();
$stmt->close();

$con->close();
?>
<html>
  <head>
    <title>Geneshare 0.1 - Add Species Complete</title>
  </head>
  <body>
    <h1>Add Species Complete</h1>
    <p>The following species has been successfully added:</p>
    <ul>
<?php
echo "
      <li>Name: $species</li>
      
";
?>
    </ul>
    <h1>Actions</h1>
    <ul>
      <li><a href="add.php">Add another species</a></li>
      <li><a href="roster_view.php">View roster</a></li>
      <li><a href="index.php">Home</a></li>
    </ul>
  </body>
</html>