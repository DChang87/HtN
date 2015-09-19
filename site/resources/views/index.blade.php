<!DOCTYPE html>
<html ng-app="indexApp">
<head>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Bootstrap CSS -->
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-resource.js"></script>
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
		var myApp = angular.module('indexApp', ['ngResource']).config(['$interpolateProvider', function($interpolateProvider){
			$interpolateProvider.startSymbol('[[').endSymbol(']]');
		}]);
		
		myApp.controller('mainController', ['$scope', '$resource', function($scope, $resource){
			var Patient = $resource('./api/patients/:id',
				{id:'@id'}, {
			});
			$scope.patients = [];
			var results = Patient.query(function(){
				$scope.patients = results;
			});
		}]);
	</script>
</head>
<body ng-controller="mainController">
	<nav class="navbar navbar-default">
  		<div class="container-fluid">
    		<div class="navbar-header">
      			<a class="navbar-brand" href="#">SmartMeds™</a>
    		</div>
    		<div>
      			<ul class="nav navbar-nav navbar-right">
        			<li class="active"><a href="./">Patients</a></li>
        			<li><a href="./plans">Plans</a></li>
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
        			<h4 class="modal-title">Add Patient Info</h4>
      			</div>
      			<div class="modal-body">
        			<!-- Forms -->
					<div class="row">
						<div class="col-sm-6">
    						<label for="name">Name:</label>
    						<input type="text" class="form-control" id="name">
  						</div>
						<div class="col-sm-6">
							<label for="age">Age:</label>
							<input type="text" class="form-control" id="age">
						</div>
					</div>
					<!-- Temporary <br> for spacing issues -->
					<br>	
					<div class="row">
						<div class="col-sm-12">
    						<label for="uniqueid">Unique ID:</label>
    						<input type="text" class="form-control" id="uniqueid">
  						</div>
					</div><br/>
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-primary alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Oxytocin Plan A</strong>
							</div>
						</div>
					</div><br/>
					<div class="row">
						<div class="col-sm-12">
							<label for="add">Add Plan:</label>
							<select id="add">
								<option name="id">Plan 1</option>
							</select>
						</div>
					</div>
     			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-success" data-dismiss="modal">Save Changes</button>
      			</div>
    		</div>
  		</div>
	</div>
	<div class="container">
		<button id = "absolute" type="button" class="btn btn-round btn-success" style="float:right" data-toggle="modal" data-target="#add-patient"> + </button>
		<div id="header">
			<h1 align="center">SmartMeds Patient List</h1>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Name</th>	
						<th>Age</th>
						<th>Identifier</th>
						<th>Plans</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="patient in patients">
						<td>[[patient.name]]</td>
						<td>[[patient.age]]</td>
						<td>[[patient.uid]]</td>
						<td>[[patient.plans.length]]</td>
						<td><a href="javascript:void(0);" class="text-primary">Edit</a>&nbsp;|&nbsp;<a href="javascript:void(0);" class="text-danger">Delete</a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>