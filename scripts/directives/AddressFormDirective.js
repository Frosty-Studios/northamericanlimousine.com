app.directive('addressForm', function(){
  return {
    restrict: 'E',
    templateUrl: 'templates/addressform.html',
    controller: ['$scope','$http','AddressFormService','$state','$rootScope', function($scope, $http, AddressFormService, $state, $rootScope){

	$scope.addressObj = {
	  pickupaddress: {
		name: '',
		lat: '',
		long: ''
	  },
	  dropoffaddress: {
		name: '',
		lat: '',
		long: ''
	  },
	  passengers: '',
	  luggages: ''
	};




  $scope.submit = function(pickupvalid, dropoffvalid){
    if(pickupvalid == true && dropoffvalid == true){
      console.log('Form is Valid');
      $('#submit').prop('disabled', true);
      $scope.addressObj.passengers = document.getElementById('passengers').value;
      $scope.addressObj.luggages = document.getElementById('luggages').value;
      var dat = $scope.addressObj;
      var myDataPromise  = $http.post("api/index.php", dat).success(function(response){
        console.log("Posting the Form");
		AddressFormService.setPrices(response);
      }).error(function(error){
        console.error(error);
      });
	  myDataPromise.then(function(){
		console.log("Changing Pages");
		$state.go('carselect'); 
		AddressFormService.changeOk();		
	  });
    }
    else{
      console.log('Not Valid Address!');
      //TODO: Need to Alert the customer here.
    }
  }

    }]
  };
});
