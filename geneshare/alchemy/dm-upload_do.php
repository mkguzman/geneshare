<!?php include 'includes/header.inc.php'; ?>

    <title>Alchemy: Upload CSV Complete</title>

<?php include 'includes/body.inc.php'; ?>

<?php include 'includes/menu.inc.php'; ?>

<!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>Upload CSV Complete</h1>
        </div>

        <p class="lead">Your CSV file has finished uploading.</p>

<?php


// Do we have a file error?
if ($_FILES["file"]["error"] > 0)
{
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
}
// If not, then begin processing the file
else
{
	require_once("molecular/db.php");

	$lineseparator = "\n";
	$csvfile = $_FILES["file"]["tmp_name"];
	$addauto = 0;

	if(!file_exists($csvfile))
	{
		echo "File not found. Make sure you specified the correct path.\n";
		exit;
	}

	$file = fopen($csvfile,"r");

	if(!$file)
	{
		echo "Error opening data file.<br />";
		exit;
	}

	$size = filesize($csvfile);

	if(!$size)
	{
		echo "File is empty.<br />";
		exit;
	}

	$csvcontent = fread($file,$size);

	fclose($file);

	$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename) or die(mysqli_error($con));
	if (mysqli_connect_errno())
	{
		die('Could not connect: ' . mysqli_connect_error());
	}
	
	// Prepare SQL statements for duplicate count: molecular_diagnostics, qns, and error tables
	$query = "SELECT COUNT(*) AS cnt FROM `molecular_diagnostics` WHERE accession = ? AND ordered_test = ? AND resulted_test = ? AND order_date = ? AND recd_date = ? AND perf_date = ? AND result = ?;";
	$checkdup_stmt = $con->prepare($query);
	$checkdup_stmt->bind_param("sssssss", $accession, $ordered_test, $resulted_test, $order_date, $recd_date, $perf_date, $result);
	$checkdup_stmt->bind_result($isduplicate);
	
	$query = "SELECT COUNT(*) AS cnt FROM `qns` WHERE accession = ? AND ordered_test = ? AND resulted_test = ? AND order_date = ? AND recd_date = ? AND perf_date = ? AND result = ?;";
	$checkdupqns_stmt = $con->prepare($query);
	$checkdupqns_stmt->bind_param("sssssss", $accession, $ordered_test, $resulted_test, $order_date, $recd_date, $perf_date, $result);
	$checkdupqns_stmt->bind_result($isduplicate);

	$query = "SELECT COUNT(*) AS cnt FROM `error` WHERE accession = ? AND ordered_test = ? AND resulted_test = ? AND order_date = ? AND recd_date = ? AND perf_date = ? AND result = ?;";
	$checkduperror_stmt = $con->prepare($query);
	$checkduperror_stmt->bind_param("sssssss", $accession, $ordered_test, $resulted_test, $order_date, $recd_date, $perf_date, $result);
	$checkduperror_stmt->bind_result($isduplicate);

	// Prepare SQL statement for insertion into results table
	$query = "INSERT INTO `molecular_diagnostics` VALUES( '', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? );";
	$insert_stmt = $con->prepare($query);
	$insert_stmt->bind_param("sssssssssssssssssssss", $mrn, $location, $ordering_provider, $accession, $order_date, $recd_date, $perf_date, $tat_from_order_date, $tat_from_recd_date, $ordered_test, $resulted_test, $result, $result_in_range, $units, $order_status, $age, $gender, $race, $note, $oc_activity_subtype_disp, $oc_catalog_disp);

	// Prepare SQL statement for insertion into QNS table
	$query = "INSERT INTO `qns` VALUES( '', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? );";
	$qns_stmt = $con->prepare($query);
	$qns_stmt->bind_param("sssssssssssssssssssss", $mrn, $location, $ordering_provider, $accession, $order_date, $recd_date, $perf_date, $tat_from_order_date, $tat_from_recd_date, $ordered_test, $resulted_test, $result, $result_in_range, $units, $order_status, $age, $gender, $race, $note, $oc_activity_subtype_disp, $oc_catalog_disp);

	// Prepare SQL statement for insertion into error table
	$query = "INSERT INTO `error` VALUES( '', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? );";
	$error_stmt = $con->prepare($query);
	$error_stmt->bind_param("sssssssssssssssssssss", $mrn, $location, $ordering_provider, $accession, $order_date, $recd_date, $perf_date, $tat_from_order_date, $tat_from_recd_date, $ordered_test, $resulted_test, $result, $result_in_range, $units, $order_status, $age, $gender, $race, $note, $oc_activity_subtype_disp, $oc_catalog_disp);

	$lines = 0;
	$linesparsed = 0;
	$linesduped = 0;
	$linearray = array();
	$tempdataarray = array();
	$tempfloat = 0.5;
	$iscomment = 0;
	$isduplicate = 0;

	// Take out all null (0x00) characters before splitting
	$csvcontent = str_replace("\0", "", $csvcontent);

	foreach(split($lineseparator,$csvcontent) as $line)
	{
		$lines++;

		$line = trim($line," \t");
		$line = str_replace("\r","",$line);
		$line = str_replace("'", "\'", $line);			// escape apostrophes

		// get rid of all extraneous spaces
		$line = str_replace(",          ", ",", $line);
		$line = str_replace(",         ", ",", $line);
		$line = str_replace(",        ", ",", $line);
		$line = str_replace(",      ", ",", $line);
		$line = str_replace(",     ", ",", $line);
		$line = str_replace(",    ", ",", $line);
		$line = str_replace(",   ", ",", $line);
		$line = str_replace(", ", ",", $line);

		// get rid of commas in expressions like ">10,000,000"
		$line = str_replace(">10,000,000", ">10000000", $line);

		// turn 5.50E+11 into nothing (used for Lab Policy results)
		$line = str_replace("5.50E+11", "0", $line);
		/*************************************/

		$linearray = str_getcsv($line, ",", '"');
		/************************************
		At this point, $linearray correlates with SQL table fields as follows:
			$linearray[0] -> mrn
			$linearray[1] -> location
			$linearray[2] -> ordering_provider
			$linearray[3] -> accession #
			$linearray[4] -> orderdate
			$linearray[5] -> perfdate
			$linearray[6] -> tatdays
			$linearray[7] -> ordered_test
			$linearray[8] -> resulted_test
			$linearray[9] -> result
			$linearray[10] -> units
			$linearray[11] -> order_status
			$linearray[12] -> age
			$linearray[13] -> gender
			$linearray[14] -> race
			$linearray[15] -> oc_activity_subtype_disp
			$linearray[16] -> oc_catalog_disp
			$linearray[17] -> recd_cfo
			$linearray[18] -> tat_recd
			$linearray[19] -> note
		************************************/
		
		$mrn = $linearray[0];
		$location = $linearray[1];
		$ordering_provider = $linearray[2];
		$accession = $linearray[3];
		$order_date = $linearray[4];
		$perf_date = $linearray[5];
		$tat_from_order_date = $linearray[6];
		$ordered_test = $linearray[7];
		$resulted_test = $linearray[8];
		$result = $linearray[9];
		$units = $linearray[10];
		$order_status = $linearray[11];
		$age = $linearray[12];
		$gender = $linearray[13];
		$race = $linearray[14];
		$oc_activity_subtype_disp = $linearray[15];
		$oc_catalog_disp = $linearray[16];
		$recd_date = $linearray[17];
		$tat_from_recd_date = $linearray[18];
		$note = $linearray[19];
		
		switch($resulted_test)
		{
			case "BK Virus Quantitative":
				$resulted_test = "BKVQNTX";
				break;
		}
		
		$testcode = $resulted_test;
		$result_in_range = TRUE;

		if (is_numeric($mrn))
		{
			$iscomment = 0;

			// Reorder the date fields into the proper (YY-MM-DD) format
			$tempdataarray = explode("/", $order_date);
			$order_date = $tempdataarray[2] . "-" . $tempdataarray[0] . "-" . $tempdataarray[1];
			$tempdataarray = explode("/", $perf_date);
			$perf_date = $tempdataarray[2] . "-" . $tempdataarray[0] . "-" . $tempdataarray[1];
			$tempdataarray = explode("/", $recd_date);
			$recd_date = $tempdataarray[2] . "-" . $tempdataarray[0] . "-" . $tempdataarray[1];

			// Change the patient age to floating point format
			$tempdataarray = explode(" ", $age);
			if ($tempdataarray[1] != "Years")
			{
				$tempfloat = $tempdataarray[1]/12.0;
			}
			else $tempfloat = $tempdataarray[0];
			$age = $tempfloat;
			
			// Is test result QNS?
			if(strpos($result, 'QNS') !== false || strpos($result, 'qns') !== false)
			{
				$testcode = "QNS";
				$result = "QNS";
			}
			// Is test result an error?
			if(strpos($result, 'Error') !== false || 
			   strpos($result, 'error') !== false || 
			   strpos($result, 'No Specimen') !== false)
			{
				$testcode = "Error";
				$result = "Error";
			}

		}
		else $iscomment = 1;

		if (!$iscomment)
		{
			$isduplicate = 0;
			
			// First check to see if this line is already in the database; first look in molecular_diagnostics, then in qns (only if no dupes in molecular_diagnostics), then in error (only if no dupes in qns)
			$checkdup_stmt->execute();
			$checkdup_stmt->store_result();			
			$checkdup_stmt->fetch();
			if(!$isduplicate)
			{
				$checkdupqns_stmt->execute();
				$checkdupqns_stmt->store_result();
				$checkdupqns_stmt->fetch();
				if(!$isduplicate)
				{
					$checkduperror_stmt->execute();
					$checkduperror_stmt->store_result();
					$checkduperror_stmt->fetch();
				}
			}

			if(!$isduplicate)
			{
				switch($testcode)
				{
					case "BKVQNTX":
					case "CMVQNTX":
					case "HIV1QNTX":
					case "HCVQNTX":
						// These tests are quantitative tests that generally have an integer result; when outside the limits of quantitation, we get a string result instead
						if(!is_numeric($result)) $result_in_range = FALSE;
						
						// Insert record into database
						$linesparsed++;
						$insert_stmt->execute();
						$insert_stmt->store_result();
						break;
					case "QNS":
						$linesparsed++;
						$qns_stmt->execute();
						$qns_stmt->store_result();
						break;
					case "Error":
						$linesparsed++;
						$error_stmt->execute();
						$error_stmt->store_result();
						break;
					default:
						break;
				}

			}
			else
			{
				// echo "$mrn :: $location :: $ordering_provider :: $accession :: $order_date :: $perf_date :: $result :: $order_status :: $note<br />";
				// Handle duplicate line!
				switch($testcode)
				{
					case "BKVQNTX":
					case "CMVQNTX":
					case "HIV1QNTX":
					case "HCVQNTX":
					case "QNS":
					case "Error":
						$linesduped++;
						break;
					default:
						break;
				}
			}
		}
	}
}

$checkdup_stmt->close();
$checkdupqns_stmt->close();
$checkduperror_stmt->close();
$insert_stmt->close();
$qns_stmt->close();
$error_stmt->close();
$con->close();

echo '
        <table class="table table-striped">
          <tr>
            <th>Uploaded File</th>
            <th>File Size</th>
            <th>Records In File</th>
            <th>Records Inserted Into Database</th>
            <th>Duplicate Records (Not Inserted)</th>
          </tr>
          <tr>
            <td>' . $_FILES["file"]["name"] . '</td>
            <td>' . intval($_FILES["file"]["size"] / 1024) . ' kb</td>
            <td>' . $lines . '</td>
            <td>' . $linesparsed . '</td>
            <td>' . $linesduped . '</td>
          </tr>
        </table>
';
?>

        <p>Would you like to <a href="dm-upload.php">upload</a> another file?</p>
      </div>

<?php include 'includes/footer.inc.php'; ?>
