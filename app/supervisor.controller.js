myApp.controller('supervisor',['$scope','$http', function($scope,$http){


    // SUPERVISOR DATA
    $http({
        method:"POST",
        url:"php/supervisor.php",
        data:{option: "1"}
    }).then(function(response){
        $scope.supervisorData=response.data;
        console.log($scope.supervisorData);
    });

    // DATA FOR PIE CHART
    $http({
        method:"POST",
        url:"php/supervisor.php",
        data:{option: "5"}
    }).then(function(response){
        $scope.pieData=response.data;
        console.log(response.data);
    });

    // GETTING ADJUSTER LIST
    $http({
        method:"POST",
        url:"php/supervisor.php",
        data:{option: "6"}
    }).then(function(response){
        $scope.adjusterlist=response.data;
    });

    // GETTING ADJUSTER STATS
    $scope.id=0;
    $scope.stats=function(userid,color){
        $scope.id=userid;
        console.log(color);
        console.log(userid);
        $http({
            method:"POST",
            url:"php/supervisor.php",
            data:{option: "7",id: userid,colors: color}
        }).then(function(response){
            console.log(response.data);
            $scope.adjusterclaims=response.data;
        });
    }

    // GET CLAIMS TABLES
    $scope.getClaims=function(select){
        if(select==1){
            $http({
                method:"POST",
                url:"php/supervisor.php",
                data:{option: "2"}
            }).then(function(response){
                $scope.claims=response.data;
            });
        }
        else if(select==2){
            $http({
                method:"POST",
                url:"php/supervisor.php",
                data:{option: "3"}
            }).then(function(response){
                $scope.claims=response.data;
            });
        }
        else if(select==3){
            $http({
                method:"POST",
                url:"php/supervisor.php",
                data:{option: "4"}
            }).then(function(response){
                $scope.claims=response.data;
            });
        }
    }

    // LOGOUT FUNCTION
    $scope.logout=function(){
        $http({
            method:"POST",
            url:"php/logout.php"
        }).then(function(response){
            window.open("index.html","_self");
        });
    }

}]);