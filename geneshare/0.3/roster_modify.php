<?php
/* Acquiring rid from variable placed in header in roster_view.php */
$rid = $_GET['rid'];

require_once("includes/db.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

/* Selecting data in table row associated with rid */
$query = "SELECT * FROM `roster` WHERE rid=?;";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $rid);
$stmt->execute();
$stmt->bind_result($rid, $lname, $fname, $sex, $dob, $level, $proglang);
$stmt->fetch();
$stmt->close();
$con->close();

/* PHP arrays */
	/* A variable that holds multiple values in a specified order (think of a list) */
	/* Each value in array has an index or position */
	/* Specific value can be accessed by calling array name and index */
	/* Example $my_array[1] accesses the value of index one in the $my_array array variable */
	/* Note that arrays are 0 based such that $my_array[0] is the first position and $my_array[1] is the 2nd position */
	/* Declared in PHP via $my_array = array(value1, value2, value3, etc.) */

/* split function */
	/* Breaks a string into an array based on a delimiter */
	/* Example: split("-", "2009-02-01") == ["2009", "02", "01"] */
	/* Regex (pattern matching) can be used for delimiter */

/* list function */
	/* Assigns the values of an array to variables given as arguments to the list function */
	/* Order matters */

/* Assigning the parts of the date from the database to their own variables for ease */
list($dob_year, $dob_month, $dob_day) = split('[/.-]', $dob);
?>

<?php require_once("includes/header.php"); ?>
    <title>ChowningRoster 0.2</title>
  <body>
  <?php require_once("includes/menu.php"); ?>
    <div class="container">
    <div>
    
    <h1>Modify Student</h1>
    <!-- This form is auto-populated with the values already in the database -->
      <!-- Allows a user to modify only what they choose and leave the rest -->
    <form action="roster_modify_do.php" method="get">
      <!-- value: assigns a default value to a text input -->
      <!-- style: applies CSS rule directly to the element in which style is an attribute -->
        <!-- display: modifies how an element behaves when displayed on a web page -->
            <!-- none: makes an element invisible -->
      
      <?php echo "<input type=\"text\" class=\"form-control\" name=\"rid\" value=\"$rid\" style=\"display:none;\" />\n"; ?>
      <?php echo "<h4>First Name</h4> <input class=\"form-control\" type=\"text\" name=\"fname\" value=\"$fname\" />\n"; ?>
      <?php echo "<h4>Last Name</h4> <input class=\"form-control\" type=\"text\" name=\"lname\" value=\"$lname\" />\n"; ?>
      
      <h4>Sex: </h4>
      <select name="sex" class="form-control">
<?php

/* switch() */
	/* Tests whether an argument is equal to one of the given cases (an 'if' statement for multiple outcomes) */
	/* Executes code of matched case */
	/* default: executed if none of the above cases are matched */
	/* break: must be at the end of each case to prevent the switch statement from executing another case accidentally */
	/* Logic, such as >, <, or != cannot be used (see if statement below) */
	
/* This switch determines the sex of the individual selected to modify and puts that choice as default in dropdown */
switch($sex)
{
	case "Male":
		echo "
        <option class=\"form-control\" value=\"Male\" selected>Male</option>
        <option class=\"form-control\" value=\"Female\">Female</option>
        <option class=\"form-control\" value=\"Alien\">Alien</option>\n";
		break;
	case "Female":
		echo "
        <option class=\"form-control\" value=\"Male\">Male</option>
        <option class=\"form-control\" value=\"Female\" selected>Female</option>
        <option class=\"form-control\" value=\"Alien\">Alien</option>\n";
		break;
	case "Alien":
		echo "
        <option class=\"form-control\" value=\"Male\">Male</option>
        <option class=\"form-control\" value=\"Female\">Female</option>
        <option class=\"form-control\" value=\"Alien\" selected>Alien</option>\n";
		break;
	default:
		echo "
        <option class=\"form-control\" value=\"Male\">Male</option>
        <option class=\"form-control\" value=\"Female\">Female</option>
        <option class=\"form-control\" value=\"Alien\">Alien</option>\n";
		break;
}
?>
      </select><br />
      
      <h4>Date of Birth</h4> 
      <select name="dob_month" class="form-control">
<?php

/* Keyed Array */
	/* An array in which the index is manually assigned by the user, can therefore be anything, including strings */
	/* Syntax:  $my_array = array( 'key' => 'value' ) yields $my_array['key'] = 'value' */

/* keyed array used to associate proper number with month for easier indexing */
$month_array = array(
	1 => "January", 
	2 => "February", 
	3 => "March", 
	4 => "April", 
	5 => "May", 
	6 => "June", 
	7 => "July", 
	8 => "August", 
	9 => "September", 
	10 => "October", 
	11 => "November", 
	12 => "December"
);

for($month_ctr = 1; $month_ctr < 13; $month_ctr++)
{
	echo "        <option value=\"$month_ctr\"";
	
	/* if() statement */
		/* Tests a condition and executes a block of code if condition is met */
		/* Conditions in PHP */
			/* Equal: == */
			/* Not Equal: != */
			/* Greater than: > */
			/* Less than: < */
			/* Greater than or equal: >= */
			/* Less than or equal: <= */
		/* Multiple lines to be executed must be surrounded in {}, a single line can be without */
		
	/* else if() statement */
		/* Gives an alternate condition to be tested */
		/* Executes if the condition is met and previous conditions are not (else if's can be used as many times as desired) */
		
	/* else */
		/* Executes only if all previous conditions fail */
	
	/* Selected: attribute of option, places that option as default in dropdown */
	/* This line of code echoes "selected" in <option> element if dob_month from database == number of the month */
	if($dob_month == $month_ctr) echo " selected";
	echo ">$month_array[$month_ctr]</option>\n";
}
?>
      </select>
      <select name="dob_day" class="form-control">
<?php

/* Similar setup to month for loop above */
for($day_ctr = 1; $day_ctr < 32; $day_ctr++)
{
	echo "        <option value=\"$day_ctr\"";
	if($dob_day == $day_ctr) echo " selected";
	echo ">$day_ctr</option>\n";
}
?>
      </select>
      <select name="dob_year" class="form-control">
<?php

/* Similar setup to month for loop above using 100 year range */
$year_ctr = date("Y");
$year_last = $year_ctr - 100;
for($year_ctr; $year_ctr > $year_last; $year_ctr--)
{
	echo "        <option value=\"$year_ctr\"";
	if($dob_year == $year_ctr) echo " selected";
	echo ">$year_ctr</option>\n";
}
?>
      </select><br />
      <h4>Level<h4>
      <select name="level" class="form-control">
<?php

/* Note the syntax of declaring an array */
$level_array = array( "MS-1", "MS-2", "MS-3", "MS-4", "PGY-1", "PGY-2", "PGY-3", "PGY-4", "Fellow", "Attending" );

/* count():  returns the number of values in an array */
	/* Due to the for loop starting at 0, going till $level_ctr < count($level_array) will still include every value (0 is the extra iteration) */
for($level_ctr = 0; $level_ctr < count($level_array); $level_ctr++)
{
	echo "        <option value=\"$level_array[$level_ctr]\"";
	if($level == $level_array[$level_ctr]) echo " selected";
	echo ">$level_array[$level_ctr]</option>\n";
}
?>
      </select><br />
      
      <h4>Favorite Programming Language</h4>
      <select class="form-control" name="proglang" class="form-control">
<?php

/* Similar setup to above */
$proglang_array = array( "Assembly", "C", "C++", "Java", "Javascript", "MUMPS", "PHP", "Python", "SQL" );
for($proglang_ctr = 0; $proglang_ctr < count($proglang_array); $proglang_ctr++)
{
	echo "        <option value=\"$proglang_array[$proglang_ctr]\"";
	if($proglang == $proglang_array[$proglang_ctr]) echo " selected";
	echo ">$proglang_array[$proglang_ctr]</option>\n";
}
?>
      </select><br />
      <input class="btn btn-danger" type="submit" value="Submit" />
    </form>

    

<?php require_once("includes/footer.php");?>