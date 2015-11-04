// Code goes here
var ribbonApp = angular.module('ribbonApp', [ 'ngRoute','angularUtils.directives.dirPagination']);

 ribbonApp.directive('fallbackSrc', function () {
  var fallbackSrc = {
    link: function postLink(scope, iElement, iAttrs) {
      iElement.bind('error', function() {
        angular.element(this).attr("src", iAttrs.fallbackSrc);
      });
    }
   }
   return fallbackSrc;
});


ribbonApp.controller('ribbonController', function ($scope, $http) {
  $scope.currentPage = 1;
  $scope.pageSize = 50;  
  $scope.faires = [];    
  
  $scope.years  = yearJson;
  $scope.loadData = function (faireYear) {    
    $http.get("/wp-content/themes/makerfaire/partials/ribbonJSON.php?year="+faireYear).
    success(function(data, status, headers, config) {
      $scope.ribbons  = data;
      angular.forEach(data, function(row, key) {        
        angular.forEach(row.faireData, function(value, faire) {
        if($scope.faires.indexOf(value.faire) == -1)
        {
            $scope.faires.push(value.faire);
        }
        
        }) 
       $scope.faires.sort();             
     })
     
    }).
    error(function(data, status, headers, config) {
      // log error
      alert ('error');
    });
  };
  
  //initial load   
  faireYear = $scope.years[0].name;
  $scope.loadData(faireYear);

  $scope.pageChangeHandler = function(num) {
      console.log('meals page changed to ' + num);
  };
   
});


