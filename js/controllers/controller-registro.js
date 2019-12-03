/**************************************** CONTROLLER REGISTRO ***************************************/

 Presty.controller("registroCtrl", function ($location,$http,$scope,$window) {
	 $scope.usuario = [];
	 $scope.usuario.USER_TYPE = 'Cliente';

//************** CAMBIAR CLAVE
	 $scope.mostrar_form = false;

	 $scope.eliminar_usuario = function() {
		 if (confirm('¿Seguro desea eliminar su cuenta? Perderá todos sus datos.')) {
			 $http({
				 method: 'POST',
				 url: "php/abm/eliminar.usuario.php",
				 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			 })
			 .then(function (response) {
			 	 if(response.data==="1"){
			 	 	localStorage.removeItem("user_presty");
			 	 	alert("Su cuenta ha sido eliminada.");
					 $scope.logout();
				 }
			 }, function (error) { //ERROR no se pudo establecer la conexion

			 });
		 }
	 };

	 $scope.mostrar_formulario = function() {
		 $scope.mostrar_form = true;
	 };

	 $scope.cambiar_clave = function(claves) {
		// ver si coincide la clave actual
			 if(claves.PASSWORD_ACTUAL==$scope.usuario.PASSWORD){
				 var ban=0;
				 id("clave_futura").style.borderBottom='none';
				 var p=id("clave_futura").nextSibling;
				 if(p.className==="mensaje-validacion"){
					 rc(p.parentNode,p);
				 }
				 validar_form(id("clave_futura"));
				 var p=id("clave_futura").nextSibling;
				 if(p.className==="mensaje-validacion"){
					 ban=1;
				 }
				 if(!ban) {
					 $http({
						 method: 'POST',
						 url: "php/abm/editar.clave.php",
						 data: "PASSWORD="+id("clave_futura").value,
						 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					 })
					 .then(function (response) {
					 	console.log(response);
					 	 if(response.data === "1"){
					 		 var user_actual = angular.fromJson(localStorage.getItem("user_presty"));
					 		 user_actual.PASSWORD = id("clave_futura").value;
					 		 localStorage.setItem("user_presty", angular.toJson(user_actual));
							 $scope.mostrar_form = false;
							 alert("Clave actualizada con exito");
					 	 }

					 }, function (error) { //ERROR no se pudo establecer la conexion

					 });
				 }
			 }
			 else{
				alert("la clave actual no coincide");
			 }
	 };

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
				 if (response.data === "existe") {
				 	alert("Este usuario ya existe en el sistema");
				 }
				 else if (response.data === "") {
					 alert("Cuenta creada con éxito!");
					 $location.path("#!/Login");
				 }
				 else if(typeof response.data === "object"){
				 	 var user_actual = angular.fromJson(localStorage.getItem("user_presty"));
					 user_actual.DNI = response.data.DNI;
					 user_actual.LAST_NAME = response.data.LAST_NAME;
					 user_actual.NAME = response.data.NAME;
					 user_actual.PHONE = response.data.PHONE;
					 user_actual.BIRTH_DAY = response.data.BIRTH_DAY;
					 localStorage.setItem("user_presty", angular.toJson(user_actual));
					 alert("Sus datos han sido actualizados con éxito");
				 }

			}, function (error) { //ERROR no se pudo establecer la conexion

			});
		 }

	 };

//***** EDITAR PERFIL *****//
if($location.path().indexOf("/Editar/")!==-1){
		if(localStorage.getItem("user_presty")!==null&&localStorage.getItem("user_presty")!==undefined) {
			$scope.usuario  = angular.fromJson(localStorage.getItem("user_presty"));

			console.log($scope.usuario);
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
