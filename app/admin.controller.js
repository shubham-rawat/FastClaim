myApp.controller('admin',['$scope','$http', function($scope,$http){
    

    $http({
        method:"POST",
        url:"php/admin.php",
        data:{option: "1"}
    }).then(function(response){
        $scope.colors=response.data;
        console.log($scope.colors);
    });

    $http({
        method:"POST",
        url:"php/admin.php",
        data:{option: "5"}
    }).then(function(response){
        $scope.supervisorList=response.data;
    });

    $http({
        method:"POST",
        url:"php/admin.php",
        data:{option: "7"}
    }).then(function(response){
        $scope.pieData=response.data;
        console.log(response.data);
    });

    $scope.getClaims=function(select){
        if(select==1){
            $http({
                method:"POST",
                url:"php/admin.php",
                data:{option: "2"}
            }).then(function(response){
                $scope.claims=response.data;
            });
        }
        else if(select==2){
            $http({
                method:"POST",
                url:"php/admin.php",
                data:{option: "3"}
            }).then(function(response){
                $scope.claims=response.data;
            });
        }
        else if(select==3){
            $http({
                method:"POST",
                url:"php/admin.php",
                data:{option: "4"}
            }).then(function(response){
                $scope.claims=response.data;
            });
        }
    }

    $scope.getClaims(1);

    $scope.id=0;
    $scope.stats=function(userid,color){
        $scope.id=userid;
        console.log(color);
        console.log(userid);
        $http({
            method:"POST",
            url:"php/admin.php",
            data:{option: "6",id: userid,colors: color}
        }).then(function(response){
            console.log(response.data);
            $scope.supervisorclaims=response.data;
        });
    }

    $scope.logout=function(){
        $http({
            method:"POST",
            url:"php/logout.php"
        }).then(function(response){
            window.open("index.html","_self");
        });
    }

    $scope.say = function(num){
        if(num==""){}
        else{
            $http({
                method:"POST",
                url:"php/admin.php",
                data:{option:"9",claim:num}
            }).then(function(response){
                window.open("#!claim","_self");
            });
        }
    }

    $scope.addAdj = function(data){
        data.option=8;
        data.role="adjuster";
        console.log(data);
        $http({
            method:"POST",
            url:"php/admin.php",
            data:data
        }).then(function(response){
            bootbox.alert({
                size: "small",
                message: "<em>"+response.data.message+"</em>"
            });
            data.userid="";
            data.username="";
            data.email="";
        });
    }
    
    $scope.addSup = function(data){
        data.option=8;
        data.role="supervisor";
        console.log(data);
        $http({
            method:"POST",
            url:"php/admin.php",
            data:data
        }).then(function(response){
            bootbox.alert({
                size: "small",
                message: "<em>"+response.data.message+"</em>"
            });
            data.userid="";
            data.username="";
            data.email="";
        });
    }
}]);