<?php require_once("includes/header.php"); ?>
    <title>Genelist Name</title>
  
  <body>
  
    <div class="container">
    <div>
    
    <h1>Add Experiment to Roster</h1>
    <form action="add_do.php" method="get" role="form">
      <div class="form-group">  
        <h4> Name: </h4>
        <input id="experiment" class="form-control" type="text" name="experimentrid" />
     
      Owner: <input type="text" name="ownerrid" /><br />
      Gene:  <input type="text" name="Gene" /><br />
      Species: <input type="text" name="speciesrid" /><br />
      
     
      <input class="btn btn-danger" type="submit" value="Submit" />
    </form>

    
<?php require_once("includes/footer.php");?>