<?php
/* Acquiring values from HTTP header sent from roster_modify.php */
$rid = $_GET['rid'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$sex = $_GET['sex'];
$dob = $_GET['dob_year'] . "-" . $_GET['dob_month'] . "-" . $_GET['dob_day'];
$level = $_GET['level'];
$proglang = $_GET['proglang'];

require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

/* SQL Query: UPDATE */
	/* Changes the values in a database table */
	/* SET: lists the columns to change and what they should change to */
	/* WHERE: determines the rows to update based on the row having a specific value in the listed column */
		/* Note: without the WHERE statement, every row of the columns listed in SET will be updated to the new values */

/* Since this page is meant to modify, this statement uses the values sent from roster_modify.php to update the information in the database */
$query = "UPDATE `roster` SET lname=?, fname=?, sex=?, dob=?, level=?, proglang=? WHERE rid=?;";
$stmt = $con->prepare($query);
$stmt->bind_param("sssssss", $lname, $fname, $sex, $dob, $level, $proglang, $rid);
$stmt->execute();
$stmt->close();

$con->close();
?>
<?php require_once("includes/header.php"); ?>
    <title>ChowningRoster 0.2</title>
  <body>
  <?php require_once("includes/menu.php"); ?>
    <div class="container">
    <div>
    <h1>Modify User Complete</h1>
    <p>The following user has been successfully modified:</p>
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
    
<?php require_once("includes/footer.php");?>