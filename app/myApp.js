//Module
var myApp = angular.module('myApp',["ngRoute","ngAnimate"]);

//Routing
myApp.config(['$routeProvider',function($routeProvider){
    
    $routeProvider
    .when('/admin',{
        templateUrl: 'views/admin.html',
        controller:'admin'
    })
    .when('/adjusterwise',{
        templateUrl: 'views/adjusterwise.html',
        controller:'supervisor'
    })
    .when('/supervisorwise',{
        templateUrl: 'views/supervisorwise.html',
        controller:'admin'
    })
    .when('/addAdjuster',{
        templateUrl: 'views/addadj.html',
        controller:'admin'
    })
    .when('/addSupervisor',{
        templateUrl: 'views/addsup.html',
        controller:'admin'
    })
    .when('/claim',{
        templateUrl: 'views/claimpage.html',
        controller:'claim'
    })
    .when('/offer',{
        templateUrl: 'views/offer.html',
        controller:'claim'
    })
    .when('/adjuster',{
        templateUrl: 'views/adjuster.html',
        controller:'adjuster'
    })
    .when('/supervisor',{
        templateUrl: 'views/supervisor.html',
        controller:'supervisor'
    });

}]);


// Directive for Highcharts Donut Chart
myApp.directive('hcPieChart', function () {
    return {
        restrict: 'E',
        template: '<div></div>',
        scope: {
            title: '@',
            data: '='
        },
        link: function (scope, element) {
            Highcharts.setOptions({
                //Defining Colors
                colors: Highcharts.map(['#66bcff', '#4877d6', '#d841b2', '#24CBE5', '#64E572', '#FF9655', '#FFF263','#6AF9C4'], function (color) {
                    return {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.3,
                            r: 0.5
                        },
                        stops: [
                            [0, color],
                            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                        ]
                    };
                })
              });
            Highcharts.chart(element[0], {
                chart: {
                    type: 'pie',
                    plotBackgroundColor: null,
                    width: 500
                },
                title: {
                    text: scope.title,
                    margin:0
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    innerSize: '50%',
                    data: scope.data
                }]
            });
        }
    };
})