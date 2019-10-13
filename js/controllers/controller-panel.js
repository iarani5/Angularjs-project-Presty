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
                        //ESTADO DE PRESTAMO
                        $http({
                            method: 'POST',
                            url:"php/abm/estado.prestamo.php",
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        })
                            .then(function (response){
                                console.log(response);
                                if(response.data.STATE===undefined||response.data.STATE==="Denegado"){
                                    // PEDIR PRESTAMO
                                    $scope.mostrar_form=true;
                                    $scope.estado="Solicitar un prestamo";
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
                                if(response.data.STATE==="Pedido"){
                                    $scope.mostrar_form=false;
                                    $scope.estado="Su prestamo se encuentra en proceso de autorización";
                                }
                                else if(response.data.STATE==="Pre-Otorgado"){
                                    $scope.mostrar_form=false;
                                    $scope.estado="Listado de financieras";
                                }
                                else if(response.data.STATE==="Denegado"){
                                    $scope.mostrar_form=true;
                                    $scope.estado="Su prestamo ha sido denegado";
                                }

                            },function (error){

                            });
                }
                    /***** FINANCIERA *****/
                    else if($scope.usuario.USER_TYPE==="Financiera"){
                        //listado de usuarios que piden prestamo
                    }

                    /***** AUTORIZADOR *****/
                    else if($scope.usuario.USER_TYPE==="Autorizador"){
                        //VER PEDIDOS DE PRESTAMO
                        $http({
                            method: 'POST',
                            url:"php/abm/pedidos.prestamo.php",
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(function (response) {
                            if(response.data!=="") {
                                $scope.pedidos = response.data;

                                //PROCESAR DATA
                                $scope.procesar_data = function (pedido) {
                                    var item = [];
                                    for(var i in pedido){
                                        item.push( i+'='+pedido[i] );
                                    }
                                    var union = item.join('&');

                                    $http({
                                        method: 'POST',
                                        url: "php/abm/procesar.datos.php",
                                        data: union,
                                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                    }).then(function (response) {
                                        console.log(response);
                                        alert("El veraz ha comprobado el estado de la cuenta, el usuario "+pedido.NAME+" "+ pedido.LAST_NAME +" ha sido "+response.data);
                                        if(response.data==="Aprobado"){
                                           // id(usuario).parentNode.parentNode.style.backgroundColor="#5dd223";
                                           // rc(id(usuario).parentNode, id(usuario));
                                        }
                                        else if(response.data==="Reprobado") {
                                           // id(usuario).parentNode.parentNode.style.backgroundColor = "#d24d23";
                                           // rc(id(usuario).parentNode, id(usuario));
                                        }

                                    }, function (error) {

                                    });
                                }
                            }

                            },function (error){

                                });


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
