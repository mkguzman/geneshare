<?php require_once("includes/header.php"); ?>
    <title>Owner</title>
  
  <body>
  
    <div class="container">
    <div>
    
    <h1>Add Owner to Roster</h1>
    <form action="add_do.php" method="get" role="form">
      <div class="form-group">  
        <h4> Name: </h4>
        <input id="owner" class="form-control" type="text" name="owner" />
      </div>
      
     
      <input class="btn btn-danger" type="submit" value="Submit" />
    </form>

    
<?php require_once("includes/footer.php");?>