/////RUTEO

Presty.config(function($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl : 'view/home.html',
			controller : 'indexCtrl'
		})
		.when('/Login', {
			templateUrl : 'view/login.html',
			controller : 'loginCtrl'
		})
		.when('/Registro', {
			templateUrl : 'view/registro.html',
			controller : 'registroCtrl'
		})
		.when('/Panel', {
			templateUrl : 'view/panel.html',
			controller : 'panelCtrl'
		})
		.when('/editar-perfil', { // EDITAR PERFIL
			templateUrl : 'view/registro.html',
			controller : 'registroCtrl'
		})
		.when('/perfil', { // PERFIL USUARIO
			templateUrl : 'view/perfil.html',
			controller : 'perfilCtrl'
		})
		.when('/como-funciona', { //COMO FUNCIONA
			templateUrl : 'view/como-funciona.html',
		})
		.when('/contacto', { // CONTACTO
			templateUrl : 'view/contacto.html',
			controller : 'contactoCtrl'
		})
		.when('/canchas', { //LISTADO DE CANCHAS. API GOOGLE MAPS. 
			templateUrl : 'view/canchas.html',
			controller : 'canchasCtrl'
		})
		.when('/verCancha/:id', { //VER UNA CANCHA
			templateUrl : 'view/cancha-ver.html',
			controller : 'canchaVerCtrl'
		})
		.when('/modal', { //MODAL PARA MENSAJES DE INTERACCION CON LA WEB
			templateUrl : 'view/overlay.html',
			controller : ''
		})
		.otherwise({ 
			redirectTo: '/'
		});
});
