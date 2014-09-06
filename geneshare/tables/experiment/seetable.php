<?php
require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);
$query = "SELECT * FROM `experiment`;";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($experiment.rid, $experiment);


?>
<html>
    <body>
<?php
while($stmt->fetch())

{
	echo "
	  <tr>
        <td>  Name: $experiment  </td>
	
	  </tr>
	";
}
$stmt->close();
$con->close();

?>

  </body>
  </html>