/**************************************** CONTROLLER PANEL ***************************************/

Presty.controller("panelCtrl", function ($location,$http,$scope,$window,$routeParams) {
        $http({
            method: 'POST',
            url:"php/abm/logueado.php",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function (response){
                if(response.data!=="1"||localStorage.getItem("user_presty")===undefined||localStorage.getItem("user_presty")==null){

                    $scope.usuario=angular.fromJson(localStorage.getItem("user_presty"));

                    if($scope.usuario.USER_TYPE==="Cliente"){

                        /***** CLIENTE *****/

                        $scope.pedir_prestamo=function(prestamo){
                            var item = [];
                            for(var i in prestamo){
                                item.push( i+'='+prestamo[i] );
                            }
                            var union = item.join('&');

                            $http({
                                method: 'POST',
                                url:"php/abm/pedir.prestamo.php",
                                data: union,
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            })
                            .then(function (response){
                                console.log(response);
                            },function (error){

                            });
                        }
                }
                    /***** FINANCIERA *****/
                    else if($scope.usuario.USER_TYPE==="Financiera"){
                        //listado de usuarios que piden prestamo
                    }
                    /***** AUTORIZADOR *****/
                    else if($scope.usuario.USER_TYPE==="Autorizador"){

                    }
                    /***** ADMINISTRADOR *****/
                    else if($scope.usuario.USER_TYPE==="Administrador"){

                    }

                }
                else{
                    //logout
                    alert("no estas logueado kapo");
                    $window.location.href = '#!/';
                }
            },function (error){

        });




});
