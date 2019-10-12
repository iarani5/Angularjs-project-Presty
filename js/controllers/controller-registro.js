/**************************************** CONTROLLER REGISTRO ***************************************/

 Presty.controller("registroCtrl", function ($location,$http,$scope,$window,$routeParams) {
	 $scope.usuario=[];
	 $scope.usuario.USER_TYPE = 'Cliente';

//***** ENVIO DE FORM *****//

	 $scope.submit=function(usuario){
		 var item = [];
		 for(var i in usuario){
			 item.push( i+'='+usuario[i] );
		 }
		 var union = item.join('&');

		 //REGISTRO USUARIO O EDITO PERFIL
		 $http({
			 method: 'POST',
			 url:"php/abm/crear.usuario.php",
			 data: union,
			 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		 })
			 .then(function (response){//EXITO se establecio la conexion
				 if(response.data==="existe"){
					 //mensaje de mail ya existe
				 }
				 else if(response.data===""){
					 alert("Cuenta creada con éxito!");
					 $location.path("#!/Login");
				 }

			 },function (error){ //ERROR no se pudo establecer la conexion

			 });
	 }
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