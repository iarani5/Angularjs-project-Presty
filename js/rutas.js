/////RUTEO

Presty.config(function($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl : 'view/home.html',
			controller : 'homeCtrl'
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
		.when('/Editar/:id', { // EDITAR PERFIL
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
		.otherwise({ 
			redirectTo: '/'
		});
});
