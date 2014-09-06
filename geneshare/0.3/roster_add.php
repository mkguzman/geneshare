<?php require_once("includes/header.php"); ?>
    <title>ChowningRoster 0.2</title>
  
  <body>
  <?php require_once("includes/menu.php"); ?>
    <div class="container">
    <div>
    
    <h1>Add Student to Roster</h1>
    <form action="roster_add_do.php" method="get" role="form">
      <div class="form-group">  
        <h4>First Name: </h4>
        <input id="fname" class="form-control" type="text" name="fname" />
      </div>
      
      <div class="form-group"> 
        <h4>Last Name: </h4>
        <input id="lname" class="form-control" type="text" name="lname" />
      </div>  
     
      <div class="form-group">
        <h4>Sex: </h4>
        <select id="sex" class="form-control" name="sex">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Alien">Alien</option>
      </select>
      </div>
      
      <div class="form-group">
        <h4>Date of Birth: </h4>
        <select id="dob" class="form-control" name="dob_month">
          <option value="1">January</option>
          <option value="2">February</option>
          <option value="3">March</option>
          <option value="4">April</option>
          <option value="5">May</option>
          <option value="6">June</option>
          <option value="7">July</option>
          <option value="8">August</option>
          <option value="9">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      </div>
        
      <div class="form-group">
      <select name="dob_day" class="form-control">
<?php
for($x = 1; $x < 32; $x++)
{
	echo "        <option value=\"$x\">$x</option>\n";
}
?>
      </select>
      </div>
      
      
      <select name="dob_year" class="form-control">
<?php
$x = date("Y");
$y = $x - 100;
for($x; $x > $y; $x--)
{
	echo "        <option value=\"$x\">$x</option>\n";
}
?>
      </select>
      
      <div class="form-group">
      <h4>Level:</h4>
      <select class="form-control" name="level">
        <option value="MS-1">MS-1</option>
        <option value="MS-2">MS-2</option>
        <option value="MS-3">MS-3</option>
        <option value="MS-4">MS-4</option>
        <option value="PGY-1">PGY-1</option>
        <option value="PGY-2">PGY-2</option>
        <option value="PGY-3">PGY-3</option>
        <option value="PGY-4">PGY-4</option>
        <option value="Fellow">Fellow</option>
        <option value="Attending">Attending</option>      
      </select>
      </div>
     
      <div class="form-group">
      <h4>Favorite Programming Language: </h4>
      <select class="form-control" name="proglang">
        <option value="Assembly">Assembly</option>
        <option value="C">C</option>
        <option value="C++">C++</option>
        <option value="Java">Java</option>
        <option value="Javascript">Javascript</option>
        <option value="MUMPS">MUMPS</option>
        <option value="PHP">PHP</option>
        <option value="Python">Python</option> 
        <option value="SQL">SQL</option>
     </select>
     </div>
     <div class="form-group">
      <input class="btn btn-danger" type="submit" value="Submit" />
    </form>

    
<?php require_once("includes/footer.php");?>