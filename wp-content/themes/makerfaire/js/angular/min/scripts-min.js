function sortByKey(r,n){return r.sort(function(r,t){var e=r[n],a=t[n];return a>e?-1:e>a?1:0})}function shuffle(r){for(var n=r.length,t,e;0!==n;)e=Math.floor(Math.random()*n),n-=1,t=r[n],r[n]=r[e],r[e]=t;return r}var ribbonApp=angular.module("ribbonApp",["ngRoute","angularUtils.directives.dirPagination"]),firstBy=function(){function r(r,n){if("function"!=typeof r){var t=r;r=function(r,n){return r[t]<n[t]?-1:r[t]>n[t]?1:0}}return-1===n?function(n,t){return-r(n,t)}:r}function n(n,e){return n=r(n,e),n.thenBy=t,n}function t(t,e){var a=this;return t=r(t,e),n(function(r,n){return a(r,n)||t(r,n)})}return n}();ribbonApp.directive("fallbackSrc",function(){var r={link:function n(r,t,e){t.bind("error",function(){angular.element(this).attr("src",e.fallbackSrc)})}};return r});var uniqueItems=function(r,n){for(var t=[],e=0;e<r.length;e++){var a=r[e][n];-1==t.indexOf(a)&&t.push(a)}return t};ribbonApp.filter("groupBy",function(){return function(r,n){return null!==r?uniqueItems(r,n):void 0}}),ribbonApp.controller("ribbonController",function(r,n){r.layout="grid",r.currentPage=1,r.pageSize=50,r.faires=[],r.random=function(){return.5-Math.random()},r.years=yearJson,r.loadData=function(t){var e={action:"getRibbonData",year:t};n.get("/wp-content/themes/makerfaire/partials/data/"+t+"ribbonData.json").success(function(n){r.ribbons=n,shuffle(r.ribbons),r.blueList=[],r.redList=[],angular.forEach(n,function(n,t){angular.forEach(n.faireData,function(n,t){-1==r.faires.indexOf(n.faire)&&r.faires.push(n.faire)}),r.faires.sort(),n.blueCount>0&&r.blueList.push(n),n.redCount>0&&r.redList.push(n)});var t=firstBy(function(r,n){return parseFloat(n.blueCount)-parseFloat(r.blueCount)}).thenBy(function(r,n){return r.project_name<n.project_name?-1:r.project_name>n.project_name?1:0});r.blueList.sort(t),r.redList.sort(function(r,n){return parseFloat(n.redCount)-parseFloat(r.redCount)})}).error(function(r,n,t,e){alert("error")})},faireYear=r.years[0].name,r.loadData(faireYear),r.pageChangeHandler=function(r){}});