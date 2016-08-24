app.controller('selectcarCtrl', ['$scope','$rootScope','AddressFormService','$state',  function($scope, $rootScope, AddressFormService, $state){

	if(AddressFormService.getOk() == false)$state.go('home');


	$scope.price = AddressFormService.getPrices();




}]);
