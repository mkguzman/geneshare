<?php
require_once("includes/geneshareDB.php");
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$query = "SELECT genelist.rid, genelist.Gene, genelist.Locus, genelist.Log2, genelist.G1, genelist.G2, genelist.pval, owner.owner, listdescript.listdescript, species.species FROM `genelist`, `species`, `owner`, `listdescript` WHERE genelist.species = species.speciesrid AND genelist.owner = owner.ownerrid AND genelist.listdescript = listdescript.listdescript;";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($rid, $Gene, $Locus, $Log2, $G1, $G2, $Pval, $Owner, $Listdescript, $Species);
?>

<?php require_once("includes/geneshareHeader.php"); ?>	
  
  <title>GeneShare 0.1 - View Gene List</title>

<?php require_once("includes/geneshareBody.php"); ?>

<?php require_once("includes/geneshareMenu.php"); ?>

    <div class="container">
        <div class="page-header"><br />
        <h1>View Gene List</h1>
    </div>
     <p class="lead"> Select from the following categories.</p>
    
    <form action="geneshare_genelist_search.php" method="get">
      <div class="form-group">  
        <label for="owner">Owner: <label>
        <select id="owner" name="owner">
          <option value="1">None</option>
          <option value="2">Stephanie Robert</option>
          <option value="3">David Figge</option>
          <option value="4">Mikael Guzman Karlsson</option>
        </select>
        <label for="listdescript">Gene List Description: <label>
        <input type="text" name="listdescript">
        <label for sex">Species </label>
        <select id="species" name="species">
          <option value="1">None</option>
          <option value="2">Human</option>
          <option value="3">Rat</option>
          <option value="4">Mouse</option>
          <option value="5">Drosophila</option>
        </select> 
        <input class="btn btn-default" type="submit" value="Submit" />
      </div>    
    </form>
    
    <table class="table table-striped">
      <tr>
        <th>Gene</th>
        <th>Locus</th>
        <th>Log2</th>
        <th>G1</th>
        <th>G2</th>
        <th>Pval</th>
        <th>Owner</th>
        <th>Gene List</th>
        <th>Species</th>
      </tr>
<?php
while($stmt->fetch())
{
	echo "
      <tr>
        <td>$Gene</td>
        <td>$Locus</td>
        <td>$Log2</td>
        <td>$G1</td>
        <td>$G2</td>
        <td>$Pval</td>
        <td>$Owner</td>
        <td>$Listdescript</td>
        <td>$Species</td>
        <td>
          <!-- Assignment of HTTP variables using a hyperlink -->
            <!-- Directly taking advantage of what a HTML form does when 'Submit' is pressed -->
            <!-- The links that are printed store the database rid of the individual in the HTTP variable rid -->
            <!-- This allows the next page to acquire the individual's rid through PHP \$_GET['rid'] (see roster_delete.php) -->
            <!-- This method saves values between pages -->
        </td>
      </tr>
	";
}

$stmt->close();
$con->close();
?>
    </table>
<?php require_once("includes/geneshareFooter.php"); ?>  