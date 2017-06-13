'use strict';

var app = angular.module('app',
    [
        // Angular modules
        'ngAnimate',
        // 'ngAria',
        'ngCookies',
        'ngResource',
        'ngRoute',

        // 3rd Party Modules
        'ui.bootstrap',

        // Templates
        'app-templates'
    ]
);

app.config([
    '$routeProvider', '$locationProvider', '$provide', 
    ($routeProvider, $locationProvider, $provide) => {

        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false,
        });
        
        let initData = () => {
            return {name: '123'};  
        };

        $routeProvider
            .when('/', {
                templateUrl: 'home.html',
                controller: 'HomeCtrl as Home',
                title: 'Home',
                resolve: {
                    initData: initData,
                },
            })
            .when('/404/', {
                templateUrl: '404.html',
                title: 'Page not found',
                controller: 'Page404Ctrl as Page404'
            })
            .otherwise({
                redirectTo: '/404/'
            });
    }
]).run([function() {
        console.info('Title: RUN');
    }
]);
