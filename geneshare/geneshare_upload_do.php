<?php include 'includes/geneshareHeader.php'; ?>

	<title>GeneShare Upload Complete</title>
	
<?php include 'includes/geneshareBody.php'; ?>

<?php include 'includes/geneshareMenu.php'; ?>

	  <div class="container">
	    <div class="page-header">
	      <br />
	      <h1>Upload Complete</h1>
	    </div>
	    
	    <p class="lead">Your file has finished uploading.</p>
<?php

/*if ($_FILES["file"]["error"] > 0)
{
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
}

else
{*/
	require_once("includes/geneshareDB.php");

    $lineseparator = "\r";
	$Owner = $_POST["owner"];
	$Species = $_POST["species"];
	$Listdescript = $_POST["listdescript"];
	$tsvfile = $_FILES["file"]["tmp_name"];
	$addauto = 0;
	
	if(!file_exists($tsvfile))
	{
		echo "File not found. Make sure you specified the correct path.\n";
		exit;
	}
	
	$file = fopen($tsvfile,"r");
	
	if(!$file)
	{
		echo "Error opening data file.<br />";
		exit;
	}
	
	$size = filesize($tsvfile);
	
	if(!$size)
	{
		echo "File is empty.<br />";
		exit;
	}
	
	$tsvcontent = fread($file,$size);
	
	fclose($file);

	

	$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db) or die(mysqli_error($con));
	if (mysqli_connect_error())
	{
		die('Could not connect: ' . mysqli_connect_error());
	}
	
	/*$query = "CREATE TABLE IF NOT EXISTS `owner` (ownerrid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, Owner VARCHAR(255));";
	$stmt1 = $con->prepare($query);
	$stmt1->execute();*/
	
	$query = "CREATE TABLE IF NOT EXISTS `listdescript` (listdescriptrid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, listdescript VARCHAR(255));";
	$stmt2 = $con->prepare($query);
	$stmt2->execute();
	
	/*$query = "CREATE TABLE IF NOT EXISTS `species` (speciesrid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, Species VARCHAR(255));";
	$stmt3 = $con->prepare($query);
	$stmt3->execute();*/
	
	$query = "CREATE TABLE IF NOT EXISTS `genelist` (rid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, Gene VARCHAR(255), Locus VARCHAR(255), Log2 VARCHAR(255), G1 VARCHAR(255), G2 VARCHAR(255), pval VARCHAR(255), owner VARCHAR(255), listdescript VARCHAR(255), species VARCHAR(255) );";
	$stmt4 = $con->prepare($query);
	$stmt4->execute(); 
	
	/*$query = "INSERT INTO `owner` VALUES ('', ? );";
	$stmt5 = $con->prepare($query);
	$stmt5->bind_param("s", $owner);
	$stmt5->execute();*/
	
	$query = "INSERT INTO `listdescript` VALUES ('', ? );";
	$stmt6 = $con->prepare($query);
	$stmt6->bind_param("s", $Listdescript);
	$stmt6->execute();
	
	/*$query = "INSERT INTO `species` VALUES ('', ? );";
	$stmt7 = $con->prepare($query);
	$stmt7->bind_param("s", $species);
	$stmt7->execute();*/
	
	$query = "INSERT INTO `genelist` VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ? );";
	$stmt8 = $con->prepare($query);
	$stmt8->bind_param("sssssssss", $Gene, $Locus, $Log2, $G1, $G2, $Pval, $Owner, $Listdescript, $Species);
	
	$linearray = array();
	$lines = 0;

	
	foreach(split($lineseparator, $tsvcontent) as $line) {
		
		$lines++;
		if($lines==1) continue;
		
		$linearray = str_getcsv($line, "\t", '"');
		$Gene = $linearray[0];
		$Locus = $linearray[1];
		$Log2 = $linearray[2];
		$G1 = $linearray[3];
		$G2 = $linearray[4];
		$Pval = $linearray[5];
		$Owner = $_POST["owner"];
		$Species = $_POST["species"];
		$Listdescript = $_POST["listdescript"];
		
		
		$stmt8->execute();
		$stmt8->store_result();
	}	

	/*$stmt1->close();*/
    $stmt2->close();
    /*$stmt3->close();*/
    $stmt4->close();
    /*$stmt5->close();*/
    $stmt6->close();
    /*$stmt7->close();*/
    $stmt8->close(); 
	$con->close();

echo '
        <table class="table table-striped">
          <tr>
            <th>Uploaded File</th>
            <th>File Size</th>
            <th>Records In File</th>
          </tr>
          <tr>
            <td>' . $_FILES["file"]["name"] . '</td>
            <td>' . intval($_FILES["file"]["size"] / 1024) . ' kb</td>
            <td>' . $lines . '</td>
          </tr>
        </table>
';


?>

<?php include 'includes/geneshareFooter.php';?>