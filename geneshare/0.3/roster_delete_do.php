<?php
$rid = $_GET['rid'];

require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

/* SQL Query: DELETE */
	/* Deletes a row from the table indicated by FROM `table_name` */
	/* WHERE `column_name`='value' limits delete to only those rows that have the specified value in the specified column */
		/* Forgetting the WHERE statement will delete the entire table */

/* Deleting the row selected in roster_view.php and confirmed in roster_delete.php */
$query = "DELETE FROM `roster` WHERE rid=?;";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $rid);
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
    <!-- Confirmation message -->
    <h1>Delete Student Complete</h1>
    <p>The student has been deleted!</p>
    
<?php require_once("includes/footer.php");?>