/**************************************** CONTROLLER PANEL ***************************************/

Presty.controller("panelCtrl", function ($location,$http,$scope,$window,$routeParams) {
        $http({
            method: 'POST',
            url:"php/abm/logueado.php",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response){
                if(response.data!="1"||localStorage.getItem("user_presty")==undefined||localStorage.getItem("user_presty")==null){
                  //logout
                    $window.location.href = '#!/';
                }
                else{
                    $scope.usuario=angular.fromJson(localStorage.getItem("user_presty"));

                    /***** CLIENTE *****/
                    if($scope.usuario.TYPE_USER=="Cliente"){

                        $scope.pedir_prestamo=function(monto){
                            var item = [];
                            for(var i in monto){
                                item.push( i+'='+monto[i] );
                            }
                            var union = item.join('&');

                            $http({
                                method: 'POST',
                                url:"php/abm/pedir.prestamo.php",
                                data: union,
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            })
                            .then(function (response){


                            },function (error){

                            });
                        }
                    }
                    /***** FINANCIERA *****/
                    else if($scope.usuario.TYPE_USER=="Financiera"){

                    }
                    /***** AUTORIZADOR *****/
                    else if($scope.usuario.TYPE_USER=="Autorizador"){

                    }
                    /***** ADMINISTRADOR *****/
                    else if($scope.usuario.TYPE_USER=="Administrador"){

                    }

                }
            },function (error){

        });




});

//***** EDITAR PERFIL *****//
/*
if($location.path()=="/editar-perfil"){
//llega a la vista registro a travez del boton editar perfil. Le cargo al formulario los datos de ese usuario.
	if(localStorage.getItem("dts_user")!=null){ //si ya existen sus datos almacenados en la web. esta logueado.
		var usr=[];
		usr=angular.fromJson(localStorage.getItem("dts_user"));
		$scope.usuario=[];
		$scope.usuario.NOMBRE=usr.NOMBRE;
		$scope.usuario.APELLIDO=usr.APELLIDO;
		$scope.usuario.EMAIL=usr.EMAIL;

	}
	$scope.titulo="Editar datos";
}
else{
	$scope.titulo="Registro";
}
**/