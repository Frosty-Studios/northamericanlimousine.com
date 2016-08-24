app.service('AddressFormService', function(){
var prices = '';
var x = false;
return{	
		getPrices: function(){
			console.log("Getting Prices");
			return prices;
		},
		setPrices: function(res){
			console.log("Setting Prices");
			prices = res;
		},
		changeOk: function(){
			x = !x;
		},
		getOk: function(){
			return x;
		}
	};
});