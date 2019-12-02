/**************************************** CONTROLLER PUBLICIDAD ***************************************/

Presty.controller("publicidadCtrl",  ['$scope', '$http', '$location', 'Upload', '$timeout','$window', function  ($scope, $http, $location, Upload, $timeout, $window) {
    window.scrollTo(0,0);

    //CREAR PUBLICIDAD
    $scope.titulo_publicidad="Crear publicidad";

    $scope.crear_publicidad=function(publicidad){

        if(publicidad.IMG!==undefined){
            publicidad.IMG.upload = Upload.upload({
                method: 'POST',
                url:"php/abm/crear.publicidad.php",
                data: publicidad,
            })
            .then(function(response){
                if(response.data==="1"){
                    alert("Publicidad creada con éxito");
                    $window.location.href="#!/Panel";
                }
                else{
                    alert("Hubo un error, intentelo nuevamente más tarde");
                }
            }
            ,function(response){

            });
        }
    };

//***** EDITAR PERFIL *****//
    if($location.path().indexOf("/Editar/")!==-1){
        if(localStorage.getItem("publi_presty")!==null&&localStorage.getItem("publi_presty")!==undefined) {
            $scope.publicidad  = angular.fromJson(localStorage.getItem("publi_presty"));
            $scope.titulo_publicidad = "Editar publicidad";

            $scope.editar=function(publicidad) {
                var item = [];
                var datos = tn(tn(document, 'form', 0), 'input');
                for (var i in publicidad) {
                    item.push(i + '=' + publicidad[i]);
                }
                item.push("ID="+$scope.publicidad.ID);
                //validar inputs en el submit
                var ban = 0;
                for (var i = 0; i < datos.length; i++) {
                    datos[i].style.borderBottom = 'none';
                    var p = datos[i].nextSibling;
                    if (p.className == "mensaje-validacion") {
                        rc(p.parentNode, p);
                    }
                    validar_form(datos[i]);
                    var p = datos[i].nextSibling;
                    if (p.className == "mensaje-validacion") {
                        ban = 1;
                    }
                }
                if (!ban) {
                    var union = item.join('&');

                    $http({
                        method: 'POST',
                        url: "php/abm/editar.publicidad.php",
                        data: union,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                        .then(function (response) {
                            console.log(response);
                        }, function (error) {

                        });
                }
        }

        }

    }

    /*
                        //ABM PUBLICIDAD (SUBMIT FORM)
                        $scope.submit = function (publicidad) {
                            $scope.titulo_publicidad === "Crear publicidad" ? $scope.crear_publicidad(publicidad) : $scope.cargar_form(publicidad);
                        };

                        //CARGAR FORM
                        $scope.cargar_form=function(publicidad){
                            $scope.listado_publis=false;
                            $scope.titulo_publicidad="Editar publicidad";
                            const elmnt = document.getElementById("content");
                            elmnt.scrollIntoView();
                            $scope.publicidad=publicidad;
                            console.log($scope.publicidad);
                        };

                        $scope.volver = function(){
                            $scope.titulo_publicidad="Crear publicidad";
                            $scope.listado_publis=true;
                            $scope.publicidad={};
                        };


                        //EDITAR PUBLICIDAD
                        $scope.editar_publicidad=function(publicidad){
                            console.log(publicidad);
                            /*if(publicidad.IMG!==undefined){
                                publicidad.IMG.upload = Upload.upload({
                                    method: 'POST',
                                    url:"php/abm/crear.publicidad.php",
                                    data: publicidad,
                                })
                                    .then(function(response){
                                            if(response.data==="1"){
                                                alert("Publicidad creada con éxito");
                                                location.reload();
                                            }
                                            else{
                                                alert("Hubo un error, intentelo nuevamente más tarde");
                                            }
                                        }
                                        ,function(response){
                                            //modal error
                                            console.log(response);
                                        });
                            }*/
}]);
