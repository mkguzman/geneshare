<?php include 'includes/header.inc.php'; ?>

    <title>Alchemy: Upload CSV (Molecular)</title>

<?php include 'includes/body.inc.php'; ?>

<?php include 'includes/menu.inc.php'; ?>

<!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>Upload CSV (Molecular)</h1>
        </div>

        <p class="lead">Upload a Molecular Diagnostics CSV file exported from the EMR (Cerner) here.</p>

        <div class="row">
          <div class="input-group">
            <span class="input-group-btn">
              <a class="btn btn-primary" onclick="$('input[id=file]').click();"><span class="glyphicon glyphicon-file"></span> Select a file ...</a>
            </span>
            <input id="filename" type="text" class="form-control" readonly>
            <span class="input-group-btn">
              <a class="btn btn-success" onclick="$('input[id=submit]').click();">... and upload it! <span class="glyphicon glyphicon-upload"></span></a>
            </span>
          </div>
        </div>

        <form action="dm-upload_do.php" method="post" enctype="multipart/form-data" style="display:none;">
          <input type="file" name="file" id="file">
          <input type="submit" name="submit" id="submit" value="Submit">
        </form>

      </div>
 
<?php include 'includes/footer.inc.php'; ?>

<script type="text/javascript">
$('input[id=file]').change(function()
{
	$('input[id=filename]').val($(this).val());
});
</script>
