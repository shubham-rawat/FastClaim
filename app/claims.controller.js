myApp.controller('claim',['$scope','$http', function($scope,$http){

    $http({
        method:"POST",
        url:"php/claim.php",
        data:{option: "1"}
    }).then(function(response){
        console.log(response.data);
        $scope.claimant=response.data;
    });

    $scope.makeOffer = function(data){
        data.option="2";
        $http({
            method:"POST",
            url:"php/claim.php",
            data:data
        }).then(function(response){
            bootbox.alert({
                size: "small",
                message: "<em>New Offer Made</em>"
            });
            data="";
            window.open("#!claim","_self");
        }); 
    }

}]);