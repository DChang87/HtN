<!DOCTYPE html>
<html ng-app="indexApp">
<head>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Bootstrap CSS -->
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/material.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/ripples.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-resource.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/roboto.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/ripples.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/material.min.css">
	
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
			var Med = $resource('./api/meds/:id',
				{id:'@id'}, {
  				'update': { method:'PUT' }	
			});
			$scope.selected = {};
			$scope.empty = {
				id: -1,
				name: '',
				manufacturer: ''
			}
			window.scope = $scope;
			$scope.meds = [];
			function reload(){
				var results = Med.query(function(){
					$scope.meds = results;
				});
			}
			$scope.emptySelected = function(){
				$scope.selected = $.extend({}, $scope.empty);
				$('#add-med').modal('show');	
			};
			$scope.edit = function(val){
				$scope.selected = $.extend({}, val);
				$('#add-med').modal('show');
			}
			$scope.delete = function(val){
				if(!confirm('Are you sure')) return;
				new Med(val).$delete().then(reload);
			}
			$scope.save = function(){
				if($scope.selected.id == -1){
					$scope.selected.id=null;
					new Med($scope.selected).$save().then(reload);
				}else{
					new Med($scope.selected).$update().then(reload);
				}
				$('#add-med').modal('hide');
			};
			reload();
		}]);
	</script>
</head>
<body ng-controller="mainController">
	<nav class="navbar navbar-default">
  		<div class="container-fluid">
    		<div class="navbar-header">
      			<a class="navbar-brand" href="#"><img src="img/logo.png" />SmartMeds™</a>
    		</div>
    		<div>
      			<ul class="nav navbar-nav navbar-right">
        			<li><a href="./">Patients</a></li>
        			<li><a href="./plans">Plans</a></li>
        			<li class="active"><a href="./meds">Medications</a></li>
      			</ul>
    		</div>
  		</div>
	</nav>
	
	<div id="add-med" class="modal fade" role="dialog">
  		<div class="modal-dialog">
    		<!-- Modal content-->
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal">&times;</button>
        			<h4 class="modal-title">Add Medication</h4>
      			</div>
      			<div class="modal-body">
        			<!-- Forms -->
					<div class="row">
						<div class="col-sm-6">
    						<label for="name">Name:</label>
    						<input type="text" ng-model="selected.name" class="form-control" id="name">
  						</div>
						<div class="col-sm-6">
							<label for="manufacturer">Manufacturer:</label>
							<input type="text" ng-model="selected.manufacturer" class="form-control" id="manufacturer">
						</div>
					</div>
     			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-success" ng-click="save()">Save Changes</button>
      			</div>
    		</div>
  		</div>
	</div>
	<div class="container shadow-z-2">
		<button class="btn btn-fab btn-raised btn-primary" id="absolute" ng-click="emptySelected()"><i class="mdi-content-add"></i></button>
		<div id="header">
			<h1 align="center">Medications</h1>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Name</th>	
						<th>Manufacturer</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="med in meds">
						<td>[[med.name]]</td>
						<td>[[med.manufacturer]]</td>
						<td><a href="javascript:void(0);" class="text-primary" ng-click="edit(med)">Edit</a>&nbsp;|&nbsp;<a href="javascript:void(0);" class="text-danger" ng-click="delete(med)">Delete</a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>