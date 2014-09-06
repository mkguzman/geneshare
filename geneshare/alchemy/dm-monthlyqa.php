<?php include 'includes/header.inc.php'; ?>

    <title>Alchemy: Molecular Diagnostics</title>

<?php include 'includes/body.inc.php'; ?>

<?php include 'includes/menu.inc.php'; ?>

<!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>
            QA Report for <span id="print" class="print"></span>
            <div class="btn-group noprint">
              <button type="button" class="btn btn-default btn-lg btn-hdr" id="testselect">Select a Test ...</button>
              <button type="button" class="btn btn-default btn-lg btn-hdr dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#" onclick="switchTest('BKVQNTX')">BKVQNTX</a></li>
                <li><a href="#" onclick="switchTest('CMVQNTX')">CMVQNTX</a></li>
                <li><a href="#" onclick="switchTest('HCVQNTX')">HCVQNTX</a></li>
                <li><a href="#" onclick="switchTest('HCVQNTX-CDC')">HCVQNTX-CDC</a></li>                
                <li><a href="#" onclick="switchTest('HIV1QNTX')">HIV1QNTX</a></li>
                <li><a href="#" onclick="switchTest('HIV1QNTX-CDC')">HIV1QNTX-CDC</a></li>
              </ul>
            </div>
            <div id="reportrange" class="dateselect pull-right noprint" style="background: #fff; cursor: pointer; padding: 10px 20px; border: 1px solid #ccc">
              <i class="glyphicon glyphicon-calendar icon-calendar icon-large"></i>
              <span></span> <b class="caret"></b>
            </div>
          </h1>
        </div>

        <div class="row" id="txtHint">
          <p class="lead">QA analysis will be listed here.</p>
        </div>
      </div>
 
<?php include 'includes/footer.inc.php'; ?>
<script>
var finalTest = "";
var finalStart = "";
var finalEnd = "";

function switchTest(str)
{
	finalTest = str;
	document.getElementById("testselect").innerHTML = str.toUpperCase();
	showTest(finalTest, finalStart, finalEnd)
}

function showTest(test, start, end)
{
	if (test=="")
	{
		document.getElementById("txtHint").innerHTML="";
		return;
	}
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	}

	document.getElementById("print").innerHTML=test.toUpperCase()+": "+start+" to "+end;
	xmlhttp.open("GET","molecular/dm-monthlyqa_do.php?test="+test+"&start="+start+"&end="+end,true);
	xmlhttp.send();
}

$(document).ready(function()
{
	$('#reportrange').daterangepicker(
	{
		startDate: moment().subtract('days', 29),
		endDate: moment(),
		minDate: '01/01/2012',
		maxDate: '12/31/2014',
		dateLimit: { days: 365 },
		showDropdowns: true,
		showWeekNumbers: true,
		timePicker: false,
		timePickerIncrement: 1,
		timePicker12Hour: true,
		ranges:
		{
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
			'Last 7 Days': [moment().subtract('days', 6), moment()],
			'Last 30 Days': [moment().subtract('days', 29), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		},
		opens: 'left',
		buttonClasses: ['btn btn-default'],
		applyClass: 'btn-small btn-primary',
		cancelClass: 'btn-small',
		format: 'MM/DD/YYYY',
		separator: ' to ',
		locale:
		{
			applyLabel: 'Submit',
			fromLabel: 'From',
			toLabel: 'To',
			customRangeLabel: 'Custom Range',
			daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
			monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			firstDay: 1
		}
	},
	function(start, end) {
		$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		finalStart = start.format('YYYY-MM-DD');
		finalEnd = end.format('YYYY-MM-DD');
		showTest(finalTest, finalStart, finalEnd);
	});

	// Set the initial state of the pickers
	$('#reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
	document.getElementById("testselect").innerHTML = 'BKVQNTX';

	// Set the initial state of the global variables
	finalStart = moment().subtract('days', 29).format('YYYY-MM-DD');
	finalEnd = moment().format('YYYY-MM-DD');
	finalTest = 'BKVQNTX';

	// Initial display
	showTest(finalTest, finalStart, finalEnd);
});
</script>
