<?php
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$sex = $_GET['sex'];
$dob = $_GET['dob_year'] . "-" . $_GET['dob_month'] . "-" . $_GET['dob_day'];
$level = $_GET['level'];
$proglang = $_GET['proglang'];

/* require_once() */
	/* Makes current file act as if selected file's content is in current file */
	/* Different than require() in that require_once() will only allow the file to be accessed once and not again in the current file */
	/* Different than include() in that require() will terminate script if file is inaccessible */
	/* This specific file is added for security and stores sensitive database information in another file in variables that can be used in this file */
require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$query = "CREATE TABLE IF NOT EXISTS `roster` ( rid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, lname VARCHAR(255), fname VARCHAR(255), sex VARCHAR(255), dob DATE, level VARCHAR(255), proglang VARCHAR(255) );";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->close();

$query = "INSERT INTO `roster` VALUES ( '', ?, ?, ?, ?, ?, ? );";
$stmt = $con->prepare($query);
$stmt->bind_param("ssssss", $lname, $fname, $sex, $dob, $level, $proglang);
$stmt->execute();
$stmt->close();

$con->close();
?>

<?php require_once("includes/header.php"); ?>
<?php require_once("includes/menu.php"); ?>
    <div class="container"> 
    <title>ChowningRoster 0.2</title>
  <body>
    <h1>Add User Complete</h1>
    <p>The following user has been successfully added:</p>
    <ul>
<?php
echo "
      <li>First Name: $fname</li>
      <li>Last Name: $lname</li>
      <li>Sex: $sex</li>
      <li>Date of Birth: $dob</li>
      <li>Level: $level</li>
      <li>Favorite Programming Language: $proglang</li>
";
?>
    </ul>
    <h1>Actions</h1>
    <ul>
      <li><a href="roster_add.php">Add another student</a></li>
      <li><a href="roster_view.php">View roster</a></li>
      <li><a href="index.php">Home</a></li>
    </ul>
 <?php require_once("includes/footer.php");?>