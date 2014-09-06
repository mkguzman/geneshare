<?php
$experiment = $_GET['experiment'];


/* require_once() */
	/* Makes current file act as if selected file's content is in current file */
	/* Different than require() in that require_once() will only allow the file to be accessed once and not again in the current file */
	/* Different than include() in that require() will terminate script if file is inaccessible */
	/* This specific file is added for security and stores sensitive database information in another file in variables that can be used in this file */
require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$query = "CREATE TABLE IF NOT EXISTS `experiment` ( ridexperiment BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, experiment VARCHAR(255) );";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->close();

$query = "INSERT INTO `experiment` VALUES ( '', ?);";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $experiment);
$stmt->execute();
$stmt->close();

$con->close();
?>
<html>
  <head>
    <title>Geneshare 0.1 - Added Experiment Complete</title>
  </head>
  <body>
    <h1>Added Experiment Complete</h1>
    <p>The following experiment has been successfully added:</p>
    <ul>
<?php
echo "
      <li>Name: $experiment</li>
	  <li> Rid: $experimentrid</li>
      
";
?>
    </ul>
    <h1>Actions</h1>
    <ul>
      <li><a href="add.php">Add another experiment</a></li>
      <li><a href="roster_view.php">View roster</a></li>
      <li><a href="index.php">Home</a></li>
    </ul>
  </body>
</html>