<?php

require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);


$query = "SELECT * FROM `owner`;";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($owner.rid, $owner);

$query = "SELECT * FROM `experiment`;";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($experiment.rid, $experiment);

$query = "SELECT * FROM `species`;";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($species.rid, $species);



$con->close();
?>
<html>
  <head>
  <h2> Dr.Park LOVES Anions <h2>  <title>anion gap</title>
  </head>
  <body>
<?php
while($stmt->fetch())
{
	echo "
      mabye
	";
}

$stmt->close();
$con->close();
?>

  </body>
  </html>
  
  <?php
require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$query = "SELECT $experiment FROM `experiment`;";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($experiment);
$stmt->close();
$con->close();
?>