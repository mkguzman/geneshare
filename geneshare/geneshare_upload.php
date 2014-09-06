<?php include 'includes/geneshareHeader.php';?>

  <title> GeneShare: Upload GeneList </title>

<?php include 'includes/geneshareBody.php';?>

<?php include 'includes/geneshareMenu.php';?>

    <div class="container">
    <div class="page-header">
      <br />
      <h1> Upload File </h1>
    </div>
    
    <p class="lead">Upload a Gene List here. File must be in .txt or .tsv format </p>
    
        
    <form action="geneshare_upload_do.php" method="post" enctype="multipart/form-data">
      <div class="form-group"> 
        <h4>Owner: </h4>
        <select id="owner" class="form-control" name="owner">
          <option value="2">Stephanie Robert</option>
          <option value="3">David Figge</option>
          <option value="4">Mikael Guzman Karlsson</option>
        </select>
      </div>  
      
      <div class="form-group"> 
        <h4>Gene List Description: </h4>
        <input id="listdescript" class="form-control" type="text" name="listdescript" />
      </div> 
      
      <div class="form-group">
        <h4>Species: </h4>
        <select id="species" class="form-control" name="species">
          <option value="2">Human</option>
          <option value="3">Rat</option>
          <option value="4">Mouse</option>
          <option value="5">Drosophila</option>
        </select>
      </div>
 
      <div class="form-group">
        <span class="input-group-addon"><a class='btn btn-primary' onclick="$('input[id=file]').click();"><span class="glyphicon glyphicon-file"></span>
          Choose File...
        </a> <br />
        &nbsp;
       <input id="filename" type="text" class="form-control" readonly></span>
       </div>

     
     <input type="file" id="file" style='display:none;' name="file" />
     

     <div class="btn">
       <input type="submit" id="submit" button type="button" class="btn btn-default"></button>
     </div>

    </form>

<br />

<?php include 'includes/geneshareFooter.php';?>

<script type="text/javascript">
$('input[id=file]').change(function()
{
	$('input[id=filename]').val($(this).val());
});
</script>