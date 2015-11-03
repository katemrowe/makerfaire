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
  $scope.years = [];  
  var year = jQuery("#ribbYear").val();
  var ribbonDiv = '';
  $http.get("/wp-content/themes/makerfaire/partials/ribbonJSON.php?year="+year).
    success(function(data, status, headers, config) {
      $scope.ribbons  = data;
      angular.forEach(data, function(row, key) {
        
        angular.forEach(row.faireData, function(value, faire) {
        if($scope.faires.indexOf(value.faire) == -1)
        {
            $scope.faires.push(value.faire);
        }
         
        if($scope.years.indexOf(value.year) == -1)
        {
            $scope.years.push(value.year);
        }
        }) 
       $scope.faires.sort();
       $scope.years.sort(function(a, b){return b-a});
       $scope.query.faireData.year = $scope.years[0];
     })
     
    }).
    error(function(data, status, headers, config) {
      // log error
      alert ('error');
    });
  
  

  $scope.pageChangeHandler = function(num) {
      console.log('meals page changed to ' + num);
  };
   
});
