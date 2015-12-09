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

var uniqueItems = function (data, key) {
    var result = [];
    for (var i = 0; i < data.length; i++) {
        var value = data[i][key];
        if (result.indexOf(value) == -1) {
            result.push(value);
        }
    }
    return result;
};

ribbonApp.filter('groupBy',
            function () {
                return function (collection, key) {
                    if (collection === null) return;
                    return uniqueItems(collection, key);
        };
    });
    
ribbonApp.controller('ribbonController', function ($scope, $http) {
  $scope.layout = 'grid';
  $scope.currentPage = 1;
  $scope.pageSize = 50;  
  $scope.faires = [];    
  
  $scope.years  = yearJson;
  $scope.loadData = function (faireYear) {    
      var postData = {
        'action': 'getRibbonData',
        'year': faireYear
    };
    
    $http.get('/wp-content/themes/makerfaire/partials/data/' + faireYear + 'ribbonData.json').success(function(data) {
      $scope.ribbons      = data;       
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


