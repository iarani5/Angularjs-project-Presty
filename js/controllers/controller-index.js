/**************************************** CONTROLLER INDEX ***************************************/


Presty.controller("indexCtrl", function ($location,$http,$scope,$window) {

    $scope.no_user=true;

    $scope.$watch('no_user', function() {

    });

    $http({
        method: 'POST',
        url:"php/abm/logueado.php",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
        .then(function (response){

            console.log(response);
            if(localStorage.getItem("user_presty")!==undefined&&localStorage.getItem("user_presty")!==null){
                $scope.no_user=false;
                $window.location.href="#!/Panel";
            }

        },function (error){

        });

    //******* LOGOUT
    $scope.logout=function(){
        $http({
            method: 'POST',
            url:"php/abm/logout.php",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function (response){
                if(response.data==="1"){
                    if(localStorage.getItem("user_presty")!==undefined&&localStorage.getItem("user_presty")!==null){
                        localStorage.removeItem("user_presty");
                    }
                    if(localStorage.getItem("logueado")!==undefined&&localStorage.getItem("logueado")!==null){
                        localStorage.removeItem("logueado");
                    }

                    $scope.no_user=true;
                    $window.location.href="#!/";
                }
                else{
                    //error intentar mas tarde
                }

            },function (error){

            });

    };

});

