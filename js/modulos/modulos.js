/******************************************MODULOS*********************************************/

var Presty = angular.module('Presty', [
  'ngRoute', //rutas
  'mobile-angular-ui', //angular
  'mobile-angular-ui.gestures', //gestos (ej: arrastrar el dedo)
  'chart.js' // canvas stats
])

/////ADAPTACION DE PANTALLA

Presty.run(function($transform) {
  window.$transform = $transform;
});
