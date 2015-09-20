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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/roboto.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/ripples.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/material.min.css">
	
	<!-- CSS -->
	<link rel="stylesheet" href="css/styles.css">
	
	<!-- Let's start loading headers -->
	<script>
		var myApp = angular.module('indexApp', ['ngResource']).config(['$interpolateProvider', function($interpolateProvider){
			$interpolateProvider.startSymbol('[[').endSymbol(']]');
		}]);
		
		myApp.controller('mainController', ['$scope', '$resource', function($scope, $resource){
			window.scope = $scope;
			$scope.data = {};
			$scope.dates = [];
			$scope.login = false;
			$scope.signin = function(){
				$.getJSON('./api/patients/uid/'+$('#uniqueid').val(), function(data){
					for(var i = 0; i < data.plans.length; i++){
						
						data.plans[i].interval = Number(data.plans[i].interval);
						data.plans[i].offset = Number(data.plans[i].offset);
						data.plans[i].repeats = Number(data.plans[i].repeats);
						data.plans[i].med_id = Number(data.plans[i].med_id);
					}
					$scope.data =  data;
					$.each(data.plans, function(key, val){
						var start = moment(val.created_at).add(val.offset, 'h').subtract(val.interval, 'h'); //add offset hours to created_at
						for(var i = 0; i < val.repeats; i++){
							start = start.add(val.interval, 'h');
							if(start.unix() < moment().unix() || start.unix() - moment().unix() > 604800*1000) continue;
							$scope.dates.push({
								name: val.name,
								timestamp: start.unix(),
								date: start.format('ddd MMM D @ H:mmA'),
								med: $.extend({}, val.med),
								dose: val.dose
							});
						}
					});
					$scope.dates.sort(function(a, b) {
						return a.timestamp - b.timestamp;
					});
					$scope.login = true;
					$scope.$apply();
				});
			}
		}]);
	</script>
</head>
<body ng-controller="mainController">
	<nav class="navbar navbar-default">
  		<div class="container-fluid">
    		<div class="navbar-header">
      			<a class="navbar-brand" href="#"><img src="img/logo.png" />SmartMeds™</a>
    		</div>
  		</div>
	</nav>
	<div class="container shadow-z-2" ng-if="!login">
		<div id="header">
			<h1 align="center">Patient Login</h1>
			<div class="row">
				<div class="col-sm-12 login" align="left">
    				<label for="uniqueid">Unique ID:</label>
    				<input type="text" class="form-control" id="uniqueid">
					<button class="btn btn-primary" ng-click="signin()">Login</button>
					<br>
  				</div>
			</div>
		</div>
	</div>
	<div ng-if="login">
		<div class="container shadow-z-2">
			<div id="header">
				<h1 align="center">Med Schedule for [[data.name]]</h1>
			</div>
		</div>
		<div ng-repeat="event in dates" class="container shadow-z-1" style="margin-top:20px;padding:20px;position:relative;">
			<h4>[[event.med.name]]</h4><div class="pull-right">[[event.date]]</div>
			<div class="text-muted">[[event.name]]&nbsp;|&nbsp;[[event.med.manufacturer]]</div>
		</div>
		<br/>
		<br/>
	</div>
</body>
</html>