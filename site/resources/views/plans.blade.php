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
        			<li><a href="./">Dashboard</a></li>
        			<li class="active"><a href="./plans">Plans</a></li>
        			<li><a href="#">Page 2</a></li> 
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
        			<h4 class="modal-title">Create Plan</h4>
      			</div>
      			<div class="modal-body">
        			<!-- Forms -->
					<div class="row">
						<div class="col-sm-12">
    						<label for="name">Name:</label>
    						<input type="text" class="form-control" id="name">
  						</div>
					</div><br/>
					<div class="row">
						<div class="col-sm-12">
    						<label for="med">Medicine:</label>
    						<select class="form-control" id="med">
								<option value="id">Tylenol</option>
							</select>
  						</div>
					</div><br/>
					<div class="row">
						<div class="col-sm-6">
    						<label for="interval">Interval (hours):</label>
    						<input type="number" class="form-control" id="interval">
  						</div>
						<div class="col-sm-6">
    						<label for="offset">Offset (hours):</label>
    						<input type="number" class="form-control" id="ofsset">
  						</div>
					</div><br/>
					<div class="row">
						<div class="col-sm-6">
    						<label for="dose">Dose:</label>
    						<input type="text" class="form-control" id="dose">
  						</div>
						<div class="col-sm-6">
    						<label for="repeats">Repeats:</label>
    						<input type="number" class="form-control" id="repeats">
  						</div>
					</div>
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
			<h1 align="center">SmartMeds Plans List</h1>
		</div>
	</div>
</body>
</html>