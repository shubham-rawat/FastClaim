myApp.controller('adjuster',['$scope','$http', function($scope,$http){
    
    $http({
        method:"POST",
        url:"php/adjuster.php",
        data:{option: "1"}
    }).then(function(response){
        $scope.adjusterData=response.data;
        console.log($scope.adjusterData);
    });

    $http({
        method:"POST",
        url:"php/adjuster.php",
        data:{option: "5"}
    }).then(function(response){
        $scope.pieData=response.data;
        console.log(response.data);
    });


    $scope.getClaims=function(select){
        if(select==1){
            $http({
                method:"POST",
                url:"php/adjuster.php",
                data:{option: "2"}
            }).then(function(response){
                $scope.claims=response.data;
            });
        }
        else if(select==2){
            $http({
                method:"POST",
                url:"php/adjuster.php",
                data:{option: "3"}
            }).then(function(response){
                $scope.claims=response.data;
            });
        }
        else if(select==3){
            $http({
                method:"POST",
                url:"php/adjuster.php",
                data:{option: "4"}
            }).then(function(response){
                $scope.claims=response.data;
            });
        }
    }

    $scope.getClaims(1);

    $scope.say = function(num){
        if(num==""){}
        else{
            $http({
                method:"POST",
                url:"php/adjuster.php",
                data:{option:"6",claim:num}
            }).then(function(response){
                window.open("#!claim","_self");
            });
        }
    }

    $scope.logout=function(){
        $http({
            method:"POST",
            url:"php/logout.php"
        }).then(function(response){
            window.open("index.html","_self");
        });
    }

}]);