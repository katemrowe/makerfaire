// Code goes here
var ribbonApp = angular.module('ribbonApp', [ 'ngRoute','angularUtils.directives.dirPagination']);
var firstBy=function(){function n(n,t){if("function"!=typeof n){var r=n;n=function(n,t){return n[r]<t[r]?-1:n[r]>t[r]?1:0}}return-1===t?function(t,r){return-n(t,r)}:n}function t(t,u){return t=n(t,u),t.thenBy=r,t}function r(r,u){var f=this;return r=n(r,u),t(function(n,t){return f(n,t)||r(n,t)})}return t}();

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
   // console.log('data-'+data);
    //console.log('key-'+key);
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
  
  $scope.random = function() {
        return 0.5 - Math.random();
    }
  $scope.years  = yearJson;
  $scope.loadData = function (faireYear) {    
      var postData = {
        'action': 'getRibbonData',
        'year': faireYear
    };
    
    $http.get('/wp-content/themes/makerfaire/partials/data/' + faireYear + 'ribbonData.json').success(function(data) {
        $scope.ribbons      = data; 
        //for random order
        shuffle($scope.ribbons);
        
        //clear out old data
        $scope.blueList = [];
        $scope.redList = [];
                
        angular.forEach(data, function(row, key) {
            /* create faires data */
            angular.forEach(row.faireData, function(value, faire) {
              if($scope.faires.indexOf(value.faire) == -1)
              {
                  $scope.faires.push(value.faire);
              }
            })
            $scope.faires.sort();    

            //create blue ribbon list data
            if(row.blueCount>0){
                $scope.blueList.push(row);
            }       
            //create red ribbon list data
            if(row.redCount>0){
                $scope.redList.push(row);
            }
       })
       
       //sort blue list by # of blue ribbons in reverse order, then by alphabetical
       var s = firstBy(function (v1, v2) { return parseFloat(v2.blueCount) - parseFloat(v1.blueCount); })
                 .thenBy(function (v1, v2) { return v1.project_name < v2.project_name ? -1 : (v1.project_name > v2.project_name ? 1 : 0); });
       $scope.blueList.sort(s);              
       
        //sort red list by # of red ribbons in reverse order
        $scope.redList.sort(function(a, b) {
            return parseFloat(b.redCount) - parseFloat(a.redCount);
        });
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
      /*console.log('meals page changed to ' + num);*/
  };
   
});

function sortByKey(array, key) {
    return array.sort(function(a, b) {
        var x = a[key]; var y = b[key];
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });
}

function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex ;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}