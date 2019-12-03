/**************************************** CONTROLLER REGISTRO ***************************************/

 Presty.controller("registroCtrl", function ($location,$http,$scope) {
	 $scope.usuario=[];
	 $scope.usuario.USER_TYPE = 'Cliente';

//***** ENVIO DE FORM *****//

	 $scope.submit=function(usuario){

		 //CREAR USUARIO
			 var item = [];
			 for (var i in usuario) {
			 	if(i==="BIRTH_DAY"){
					item.push(i + '=' + id("date").value);
				}
			 	else{
					item.push(i + '=' + usuario[i]);
				}
			 }

			 //EDITAR USUARIO
			 if($location.path().indexOf("/Editar/")!==-1) {
				 item.push("EDITAR=true");
			 }

		 //validar inputs en el submit
		 var datos_registro=tn(tn(document,'form',0),'input');

		 var ban=0;
		 for(var i=0;i<datos_registro.length;i++){

			 datos_registro[i].style.borderBottom='none';
			 var p=datos_registro[i].nextSibling;

			 if(p.className==="mensaje-validacion"){
				 rc(p.parentNode,p);
			 }
			 validar_form(datos_registro[i]);
			 var p=datos_registro[i].nextSibling;
			 if(p.className==="mensaje-validacion"){
				 ban=1;
			 }
		 }

		 if(!ban) {
			 var union = item.join('&');

			 //REGISTRO USUARIO O EDITO PERFIL
			 $http({
				 method: 'POST',
				 url: "php/abm/crear.usuario.php",
				 data: union,
				 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			 })
				 .then(function (response) {//EXITO se establecio la conexion
				 	console.log(response);
					 if (response.data === "existe") {
					 	alert("Este usuario ya existe en el sistema");
					 } else if (response.data === "") {
						 alert("Cuenta creada con éxito!");
						 $location.path("#!/Login");
					 }

				 }, function (error) { //ERROR no se pudo establecer la conexion

				 });
		 }

	 };

//***** EDITAR PERFIL *****//
if($location.path().indexOf("/Editar/")!==-1){
		if(localStorage.getItem("user_presty")!==null&&localStorage.getItem("user_presty")!==undefined) {
			$scope.usuario  = angular.fromJson(localStorage.getItem("user_presty"));
			for (let i in $scope.usuario) {
				if(!isNaN($scope.usuario[i])){
					$scope.usuario[i]=parseInt($scope.usuario[i],10);
				}
				if(i==="BIRTH_DAY"){
					$scope.usuario[i] = new Date($scope.usuario[i]);
					$scope.usuario[i].setDate($scope.usuario[i].getDate() + 1);

				}
			}

			$scope.titulo = "Editar datos";
			$scope.boton="Editar";
		}

}
	else{
		$scope.titulo="Registro";
		$scope.boton="Registrarme";
	}

 });
