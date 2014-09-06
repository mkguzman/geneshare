<?php
/* Acquires the rid of individual selected in roster_view.php */
$rid = $_GET['rid'];

require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

/* Using the acquired HTTP variable rid (through $_GET) to SELECT data from database */
$query = "SELECT * FROM `roster` WHERE rid=?;";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $rid);
$stmt->execute();
$stmt->bind_result($rid, $lname, $fname, $sex, $dob, $level, $proglang);
$stmt->fetch();
$stmt->close();

$con->close();
?>
<?php require_once("includes/header.php"); ?>
    <title>ChowningRoster 0.2</title>
  <body>
  <?php require_once("includes/menu.php"); ?>
    <div class="container">
    <div>
    <h1>Delete Student</h1>
    <p>Are you sure you'd like to delete the following student?</p>
    <ul>
<?php

/* Printing out selected row's data for confirmation */
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
    
    <!-- Confirmation link -->
      <!-- Assigning $rid to HTTP variable for use in roster_delete_do.php -->
    <p><?php echo "<a href=\"roster_delete_do.php?rid=$rid\">"; ?>Yes, go ahead</a></p>
    
    <!-- Negatory link -->
    <p><a href="roster_view.php">No, go back</a></p>
    
<?php require_once("includes/footer.php");?>