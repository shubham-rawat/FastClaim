myApp.controller('login',['$scope','$http', function($scope,$http){

    $scope.login=function(data){
        
        console.log(data.userid);
        console.log(data.password);

        $http({
            method:"POST",
            url:"./php/login.php",
            data:data
        }).then(function(response){
            if(response.data.message=="Absent"){
                bootbox.alert({
                    size: "small",
                    message: "<em>Wrong Userid or Password</em>"
                });
            }
            else{
                if(response.data.role=="admin"){
                    window.open("dashboardAdmin.html#!/admin","_self");
                }
                else if(response.data.role=="adjuster"){
                    window.open("dashboardAdjuster.html#!/adjuster","_self");
                }
                else if(response.data.role=="supervisor"){
                    window.open("dashboardSupervisor.html#!/supervisor","_self");
                }
                
            }
        });
    }

}]);