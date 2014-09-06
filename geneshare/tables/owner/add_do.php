<?php
$owner = $_GET['owner'];


/* require_once() */
	/* Makes current file act as if selected file's content is in current file */
	/* Different than require() in that require_once() will only allow the file to be accessed once and not again in the current file */
	/* Different than include() in that require() will terminate script if file is inaccessible */
	/* This specific file is added for security and stores sensitive database information in another file in variables that can be used in this file */
require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$query = "CREATE TABLE IF NOT EXISTS `owner` ( ownerrid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, owner VARCHAR(255) );";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->close();

$query = "INSERT INTO `owner` VALUES ( '', ?);";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $owner);
$stmt->execute();
$stmt->close();

$con->close();
?>
<html>
  <head>
    <title>Geneshare 0.1 - Add Owner Complete</title>
  </head>
  <body>
    <h1>Add User Complete</h1>
    <p>The following user has been successfully added:</p>
    <ul>
<?php
echo "
      <li>Name: $owner</li>
      
";
?>
    </ul>
    <h1>Actions</h1>
    <ul>
      <li><a href="add.php">Add another owner</a></li>
      <li><a href="roster_view.php">View roster</a></li>
      <li><a href="index.php">Home</a></li>
    </ul>
  </body>
</html>