<?php
require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$query = "SELECT * FROM `roster`;";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($rid, $lname, $fname, $sex, $dob, $level, $proglang);
?>

<?php require_once("includes/header.php"); ?>
  <title>GeneShare</title>
  <body>
<?php require_once("includes/menu.php"); ?>
    <div class="container">
    <div>
    <h1>View Uploaded Genes</h1>
    <table class="table table-striped">
      <tr>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Sex</th>
        <th>Date of Birth</th>
        <th>Level</th>
        <th>Favorite Programming Language</th>
        <th>Actions</th>
      </tr>
<?php
while($stmt->fetch())
{
	echo "
      <tr>
        <td>$lname</td>
        <td>$fname</td>
        <td>$sex</td>
        <td>$dob</td>
        <td>$level</td>
        <td>$proglang</td>
        <td>
          <!-- Assignment of HTTP variables using a hyperlink -->
            <!-- Directly taking advantage of what a HTML form does when 'Submit' is pressed -->
            <!-- The links that are printed store the database rid of the individual in the HTTP variable rid -->
            <!-- This allows the next page to acquire the individual's rid through PHP \$_GET['rid'] (see roster_delete.php) -->
            <!-- This method saves values between pages -->
          <a href=\"roster_modify.php?rid=$rid\">Modify</a><br />
          <a href=\"roster_delete.php?rid=$rid\">Delete</a>
        </td>
      </tr>
	";
}

$stmt->close();
$con->close();
?>
    </table>
    
<?php require_once("includes/footer.php");?>