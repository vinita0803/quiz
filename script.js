var app = angular.module('main', ['ngRoute']);

app.config(function($routeProvider, $qProvider){
    $qProvider.errorOnUnhandledRejections(false);
    $routeProvider.when('/', {
        templateUrl:'./components/home.html',
        controller:'homecntrl'
    }).when('/login',{
        templateUrl:'./components/login.html',
        controller:'logincntrl'
    }).when('/dashboard',{        
        templateUrl:'./components/dashboard.html',
        resolve:{
            check:function($location, user){
                if(!user.isUserLoggedIn())
                {
                    $location.path('/login')
                }
            }
            },
        controller:'dashboardcntrl'
    }).when('/contact',{
        templateUrl:'./components/contact.html',
        controller:'contactcntrl'
    }).when('/register',{
        templateUrl:'./components/register.html',
        controller:'registercntrl'
    
    }).when('/quiz',{
        templateUrl:'./components/quiz.html',
        controller:'quizcntrl'
    })
    .otherwise({
        template:'404'
    })

});

app.service('user',function(){
    var username;
    var loggedin= false;
    var registered= false;
    var id;
    this.setName = function(name){
        username=name;
    };
    this.getName= function(){
        return username;
    };
    this.setId = function(userID){
        id=userId;
    };
    this.getId= function(){
        return usernidame;
    };
    this.isUserLoggedIn= function()
    {
      return loggedin;
    };
    this.userLoggedIn= function(){
        loggedin = true;
    };
   
});

app.controller('homecntrl', function($scope, $location){
    $scope.goToLogin = function(){
        $location.path('/login');
    };
    $scope.register= function(){
        $location.path('/register');
    }
    $scope.contact= function(){
        $location.path('/contact');
    }
});

app.controller('logincntrl', function($scope, $http, $location, user){
    $scope.login= function(){
        var username= $scope.username;
        var password= $scope.password;
        $http({
            url: 'http://localhost/A/server.php',
            method: 'POST',
            headers:{
                'Content-Type':'application/x-www-form-urlencoded'
            },
            data: 'username='+username+'&password='+password
        }).then(function(response) {
			if(response.data.status == 'loggedin') {
				user.userLoggedIn();
				user.setName(response.data.user);
				$location.path('/dashboard');
			} else {
				alert('invalid login');
			}
		})
	}
});


app.controller('registercntrl', function($scope, $http, $location){
    $scope.submitRegister= function(){
        $http({
         url: "http://localhost/A/serverregsiter.php",
         method: 'POST',
         headers:{
             'Content-Type':'application/x-www-form-urlencoded'
         },

        data: {
            'email':$scope.email,
            'pass':$scope.pass,
            'fname':$scope.fname,
            'lname':$scope.lname,
            'phone':$scope.phone
        },
    }).then(function(response) {
        if(response.data.status == 'registered') {
            $location.path('/login');
        } else {
            alert('Registration unsuccessfull');
        }
    })
}
        
});
app.controller('dashboardcntrl', function($scope,$location){
    $scope.goToQuiz= function(){
        $location.path('/quiz');
    }
});

app.controller('contactcntrl', function(){
});

app.controller('quizcntrl', function(){
});

/*
Data.post('signUp', {
            user1 : user1
        }).then(function(results){
            Data.toast(results);
            if(results.status=="Registered")
            {
                alert('Registration Successfull');
            }
            else{
                alert('Registration NOT Successfull');
            }
        })
    }
        
$http({
            url: 'http://localhost/A/serverregsiter.php',
            method: 'POST',
            headers:{
                'Content-Type':'application/x-www-form-urlencoded'
            },
            data:  user1
        }).then(function(response){
                if(response.data.status == 'Registered')
                {
                    alert('Registration Successfull');                }
                else
                {
                    alert('Registration NOT Successfull');

                }
                
        });
    }
 */