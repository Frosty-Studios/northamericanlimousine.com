var app = angular
  .module('app', ['ui.router','vsGoogleAutocomplete']);

app.config(['$urlRouterProvider', '$stateProvider' , function($urlRouterProvider,$stateProvider){
  $urlRouterProvider.otherwise('/');

  $stateProvider
    .state('home', {
      url: '/',
      templateUrl: 'templates/home.html',
	  controller: 'homeCtrl'
    })
	.state('carselect', {
		url:'/selectcar',
		templateUrl: 'templates/carselect.html',
		controller: 'selectcarCtrl'
	});


}])
