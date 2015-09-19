<!DOCTYPE html>
<html>
<head>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Bootstrap CSS -->
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	
	<!-- CSS -->
	<link rel="stylesheet" href="css/styles.css">
	
	<!-- Let's start loading headers -->
	<script>
		$(document).ready(function(){
       		$("#header").fadeIn(2000);
        	//$("#div2").fadeIn("slow");
        	//$("#div3").fadeIn(3000);
		});
	</script>
	
	<nav class="navbar navbar-default">
  		<div class="container-fluid">
    		<div class="navbar-header">
      			<a class="navbar-brand" href="#">SmartMeds™</a>
    		</div>
    		<div>
      			<ul class="nav navbar-nav navbar-right">
        			<li class="active"><a href="#">Dashboard</a></li>
        			<li style="color:green"><a href="#">Page 1</a></li>
        			<li><a href="#">Page 2</a></li> 
        			<li><a href="#">Page 3</a></li> 
      			</ul>
    		</div>
  		</div>
	</nav>
	
	<div id="add-patient" class="modal fade" role="dialog">
  		<div class="modal-dialog">
    		<!-- Modal content-->
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal">&times;</button>
        			<h4 class="modal-title">Add Patient Info</h4>
      			</div>
      			<div class="modal-body">
        			<!-- Forms -->
					<form role="form">
						<div class="form-group">
    						<label for="name">Name:</label>
    						<input type="text" class="form-control" id="name">
  						</div>
					</form>
					<form role="form">
						<div class="form-group">
    						<label for="uniqueid">Unique ID:</label>
    						<input type="text" class="form-control" id="uniqueid">
  						</div>
					</form>
					<form role="form">
						<div class="form-group">
    						<label for="medicine">Medicine Prescribed:</label>
    						<input type="text" class="form-control" id="medicine">
  						</div>
					</form>	
     			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-success" data-dismiss="modal">Save Changes</button>
      			</div>
    		</div>
  		</div>
	</div>
</head>
<body>
	<div style="display: relative">
		<button id = "absolute" type="button" class="btn btn-round btn-success" style="float:right" data-toggle="modal" data-target="#add-patient"> + </button>
		<div id="header">
			<h1 align="center">SmartMeds Patient List</h1>
		</div>
	</div>
</body>
</html>