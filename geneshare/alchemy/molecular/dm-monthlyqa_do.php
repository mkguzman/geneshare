<?php
$testcode = $_GET['test'];
$startdate = $_GET['start'];
$enddate = $_GET['end'];
$tempcount = 0;
$fullcount = 0;

require_once("db.php");

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (mysqli_connect_errno())
{
	die('Could not connect: ' . mysqli_connect_error());
}

switch($testcode)
{
	case "BKVQNTX":
		$constant_query = "resulted_test = 'BKVQNTX' AND perf_date BETWEEN ? AND ? ORDER BY perf_date, recd_date ASC;";
		$results_ranges = array( array("< 500", NULL), array(500, 5000), array(5001, 50000), array(50001, 500000), array(500001, 5000000), array("> 5000000", NULL) );
		break;
	case "CMVQNTX":
		$constant_query = "resulted_test = 'CMVQNTX' AND perf_date BETWEEN ? AND ? ORDER BY perf_date, recd_date ASC;";
		$results_ranges = array( array("< 137", NULL), array(137, 1000), array(1001, 10000), array(10001, 500000), array(100001, 1000000), array(1000001, 9100000), array("> 9100000", NULL) );
		break;
	case "HCVQNTX":
		$constant_query = "resulted_test = 'HCVQNTX' AND perf_date BETWEEN ? AND ? ORDER BY perf_date, recd_date ASC;";
		$results_ranges = array( array("Target Not Detected", NULL), array("< 43", NULL), array(43, 10000), array(10001, 100000), array(100001, 1000000), array(1000001, 10000000), array(10000001, 50000000), array(50000001, 69000000), array("> 69000000", NULL) );
		break;
	case "HIV1QNTX":
		$constant_query = "resulted_test = 'HIV1QNTX' AND perf_date BETWEEN ? AND ? ORDER BY perf_date, recd_date ASC;";
		$results_ranges = array( array("< 20", NULL), array(20, 1000), array(1001, 10000), array(10001, 100000), array(100001, 1000000), array(1000001, 10000000), array("> 10000000", NULL) );
		break;
	case "HCVQNTX-CDC":
		$constant_query = "ordered_test = 'CDC HCV QNT' AND perf_date BETWEEN ? AND ? ORDER BY perf_date, recd_date ASC;";
		$results_ranges = array( array("Target Not Detected", NULL), array("< 43", NULL), array(43, 10000), array(10001, 100000), array(100001, 1000000), array(1000001, 10000000), array(10000001, 50000000), array(50000001, 69000000), array("> 69000000", NULL) );
		break;
	case "HIV1QNTX-CDC":
		$constant_query = "ordered_test = 'CDC HIV1 Qnt' AND perf_date BETWEEN ? AND ? ORDER BY perf_date, recd_date ASC;";
		$results_ranges = array( array("< 20", NULL), array(20, 1000), array(1001, 10000), array(10001, 100000), array(100001, 1000000), array(1000001, 10000000), array("> 10000000", NULL) );
		break;
	default:
		break;
}

// Generate summary table
echo "
          <h2>Summary</h2>
          <table class='table table-striped'>
            <tr>
              <th>Category</th>
              <th>Result</th>
            </tr>";

// Average TAT days row
$query = "SELECT AVG(tat_from_recd_date) AS avg FROM `molecular_diagnostics` WHERE " . $constant_query;
$stmt = $con->prepare($query);
$stmt->bind_param("ss", $startdate, $enddate);
$stmt->bind_result($avg_tat_days);
$stmt->execute();
$stmt->fetch();
$stmt->close();
echo "
            <tr>
              <td><em>Average TAT Days</em></td>
              <td>" . number_format($avg_tat_days, 2, '.', '') . "</td>
            </tr>";

// Tests performed row
$query = "SELECT COUNT(*) AS cnt FROM `molecular_diagnostics` WHERE " . $constant_query;
$stmt = $con->prepare($query);
$stmt->bind_param("ss", $startdate, $enddate);
$stmt->bind_result($tests_performed);
$stmt->execute();
$stmt->fetch();
$stmt->close();
echo "
            <tr>
              <td><em>Tests Performed</em></td>
              <td>" . $tests_performed . "</td>
            </tr>";

// Tests overdue row
$query = "SELECT COUNT(*) AS cnt FROM `molecular_diagnostics` WHERE tat_from_recd_date > 7 AND " . $constant_query;
$stmt = $con->prepare($query);
$stmt->bind_param("ss", $startdate, $enddate);
$stmt->bind_result($tests_overdue);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$tests_overdue_percent = number_format((100 * $tests_overdue / $tests_performed), 2, '.', '');
echo "
            <tr>
              <td><em>Tests Overdue</em></td>
              <td>" . $tests_overdue . "</td>
            </tr>
            <tr>
              <td><em>Percent Overdue</em></td>
              <td>" . $tests_overdue_percent . "%</td>
            </tr>";

if($testcode == 'BKVQNTX')
{
	$query = "SELECT COUNT(*) AS cnt FROM `molecular_diagnostics` WHERE tat_from_recd_date < 6 AND " . $constant_query;
	$stmt = $con->prepare($query);
	$stmt->bind_param("ss", $startdate, $enddate);
	$stmt->bind_result($tests_within_five_days);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();

	$tests_within_five_days_percent = number_format((100 * $tests_within_five_days / $tests_performed), 2, '.', '');

	echo "
            <tr>
              <td><em>Tests Completed Within 5 Days</em></td>
              <td>" . $tests_within_five_days . "</td>
            </tr>
            <tr>
              <td><em>Percent Completed Within 5 Days</em></td>
              <td>" . $tests_within_five_days_percent . "%</td>
            </tr>";
}

echo "
          </table>";

// Results ranges
echo "
          <h2>Results Ranges</h2>
          <table class='table table-striped'>
            <tr>
              <th>Range</th>
              <th>Number</th>
              <th>Percent</th>
            </tr>";

$notinrange_query = "SELECT COUNT(*) AS cnt FROM `molecular_diagnostics` WHERE result = ? AND " . $constant_query;
$notinrange_stmt = $con->prepare($notinrange_query);
$notinrange_stmt->bind_param("sss", $range_begin, $startdate, $enddate);
$notinrange_stmt->bind_result($tests_in_range);

$inrange_query = "SELECT COUNT(*) AS cnt FROM `molecular_diagnostics` WHERE result BETWEEN ? AND ? AND " . $constant_query;
$inrange_stmt = $con->prepare($inrange_query);
$inrange_stmt->bind_param("iiss", $range_begin, $range_end, $startdate, $enddate);
$inrange_stmt->bind_result($tests_in_range);

for($x = 0; $x < (count($results_ranges)); $x++)
{
	if($results_ranges[$x][1] == NULL)
	{
		$range_begin = $results_ranges[$x][0];
		$notinrange_stmt->execute();
		$notinrange_stmt->store_result();
		$notinrange_stmt->fetch();
		$tests_in_range_percent = number_format((100 * $tests_in_range / $tests_performed), 2, '.', '');
		echo "
            <tr>
              <td><em>" . $results_ranges[$x][0] . "</em></td>
              <td>" . $tests_in_range . "</td>
              <td>" . $tests_in_range_percent . "%</td>
            </tr>";
	}
	else
	{
		$range_begin = $results_ranges[$x][0];
		$range_end = $results_ranges[$x][1];
		$inrange_stmt->execute();
		$inrange_stmt->store_result();
		$inrange_stmt->fetch();
		$tests_in_range_percent = number_format((100 * $tests_in_range / $tests_performed), 2, '.', '');
		echo "
            <tr>
              <td><em>" . $results_ranges[$x][0] . " - " . $results_ranges[$x][1] . "</em></td>
              <td>" . $tests_in_range . "</td>
              <td>" . $tests_in_range_percent . "%</td>
            </tr>";
	}
	
}

$notinrange_stmt->close();
$inrange_stmt->close();

echo "
          </table>";

// Final raw table dump
$query = "SELECT units FROM `molecular_diagnostics` WHERE " . $constant_query;
$stmt = $con->prepare($query);
$stmt->bind_param("ss", $startdate, $enddate);
$stmt->bind_result($units);
$stmt->execute();
while($stmt->fetch()) if($units != NULL) $final_units = $units;
$stmt->close();

$query = "SELECT accession, recd_date, perf_date, tat_from_recd_date, resulted_test, result FROM `molecular_diagnostics` WHERE " . $constant_query;
$stmt = $con->prepare($query);
$stmt->bind_param("ss", $startdate, $enddate);
$stmt->bind_result($accession, $recd_date, $perf_date, $tat_from_recd_date, $resulted_test, $result);
$stmt->execute();

echo "
          <h2>Raw Data</h2>
          <table class='table table-striped'>
            <tr>
              <th>Accession #</th>
              <th>Received</th>
              <th>Performed</th>
              <th>TAT Days</th>
              <th>Resulted Test</th>
              <th>Result ($units)</th>
            </tr>";

while($stmt->fetch())
{
	echo "
            <tr>
              <td>$accession</td>
              <td>$recd_date</td>
              <td>$perf_date</td>
              <td>$tat_from_recd_date</td>
              <td>$resulted_test</td>
              <td>$result</td>
            </tr>";
}
echo "
          </table>";

$stmt->close();
$con->close();
?> 
