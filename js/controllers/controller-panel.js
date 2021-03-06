/**************************************** CONTROLLER PANEL ***************************************/

Presty.controller("panelCtrl",  ['$scope', '$http', '$location', 'Upload', '$timeout','$window', function  ($scope, $http, $location, Upload, $timeout, $window) {

    $scope.no_user=false;

    $http({
            url:'php/abm/logueado.php',
            method: 'POST',
            headers: {'Content-Type': "application/x-www-form-urlencoded"}
        })
            .then(function (response){
               /* if(response.data!=="1"&&localStorage.getItem("user_presty")!==undefined&&localStorage.getItem("user_presty")!==null){

                    $window.location.href="#!/Panel";
                }*/

                if(response.data!==""){

                    $scope.ID=response.data;

                    $scope.editar_user = function (id) {
                        $window.location.href="#!/Registro/Editar/"+id;
                    };

                    $scope.usuario=angular.fromJson(localStorage.getItem("user_presty"));

                    /***** ADMINISTRADOR *****/

                    if($scope.usuario.USER_TYPE==="Administrador") {

                        //STATS

                            $http({
                                url:'php/abm/stats.php',
                                method: 'POST',
                                headers: {'Content-Type': "application/x-www-form-urlencoded"}
                            })
                            .then(function (response) {
                                //USERS
                                var admin = 0;
                                var auto = 0;
                                var clie = 0;
                                var finan = 0;

                                $scope.borrados=0;
                                $scope.no_borrados=0;

                                $scope.usuarios_stats = response.data.users;
                                for(var k in response.data.users) {
                                    switch (response.data.users[k].USER_TYPE) {
                                        case "Administrador":
                                            admin++;
                                            break;
                                        case "Autorizador":
                                            auto++;
                                            break;
                                        case "Cliente":
                                            clie++;
                                            break;
                                        case "Financiera":
                                            finan++;
                                            break;
                                    }
                                    switch (response.data.users[k].BORRADO) {
                                        case "Si":
                                            $scope.borrados++;
                                            break;
                                        case "No":
                                            $scope.no_borrados++;
                                            break;
                                    }
                                }
                                $scope.labels = ["Clientes", "Financieras", "Autorizadores","Administradores"];
                                $scope.data = [clie, finan, auto, admin];

                                //PREESTAMOS
                                var pedido = 0;
                                var prpeot = 0;
                                var deneg = 0;
                                var otor = 0;

                                $scope.prestamos_stats = response.data.prestamos;
                                for(var k in response.data.prestamos) {
                                    switch (response.data.prestamos[k].STATE) {
                                        case "Pedido":
                                            pedido++;
                                            break;
                                        case "Pre-Otorgado":
                                            prpeot++;
                                            break;
                                        case "Denegado":
                                            deneg++;
                                            break;
                                        case "Otorgado":
                                            otor++;
                                            break;
                                    }
                                }
                                $scope.labels_dos = ["Pedido", "Pre-Otorgado", "Denegado", "Otorgado"];
                                $scope.data_dos = [pedido, prpeot, deneg, otor];

                            },function (error){

                             });;

                            //LISTADO PUBLICIDADES
                            $http({
                                method: 'POST',
                                url:"php/abm/traer.publicidad.php",
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            })
                            .then(function (response){
                                var data=angular.fromJson(response.data);
                                for(var i=0;i<data.length;i++) {
                                   // data[i].IMG=data[i].IMG.replace("C:/xampp/htdocs/Presty/", "");
                                    if(data[i].BORRADO==="Si"){
                                        data[i].checked=true;
                                    }
                                    else{
                                        data[i].checked=false;
                                    }
                                }
                                $scope.publicidades=data;

                                //BORRAR PUBLICIDAD // NO MOSTRARLA  EN BANNER
                                $scope.borrar=function(){
                                    var estado=0;
                                    if(this.una_publi.BORRADO==="No"){
                                        estado="Si";
                                        this.una_publi.checked=true;
                                    }
                                    else if(this.una_publi.BORRADO==="Si"){
                                        estado="No";
                                        this.una_publi.checked=false;
                                    }
                                    if(estado!==0){
                                         $http({
                                             method: 'POST',
                                             url:"php/abm/editar.publicidad.php",
                                             data:"estado="+estado+"&id="+this.una_publi.ID+"&borrado=true",
                                             headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                         })
                                         .then(function (response) {

                                         },function (error){

                                         });
                                    }
                                }
                            },function (error){

                            });

                            $scope.publicidad=function(){
                                $window.location.href="#!/Publicidad";
                            };

                            $scope.editar_publicidad = function (publi) {
                                localStorage.setItem("publi_presty",angular.toJson(publi));
                                $window.location.href="#!/Publicidad/Editar/"+publi.ID;
                            };

                    }

                    else if($scope.usuario.USER_TYPE==="Cliente"){

                        /***** CLIENTE *****/

                        $scope.pedir_prestamo = function (prestamo) {
                            const item = [];
                            for (var i in prestamo) {
                                item.push(i + '=' + prestamo[i]);
                            }
                            const union = item.join('&');

                            //validar monto
                            var ban=0;
                            id("monto").style.borderBottom='none';
                            var p=id("monto").nextSibling;

                            if(p.className==="mensaje-validacion"){
                                rc(p.parentNode,p);
                            }
                            validar_form(id("monto"));
                            var p=id("monto").nextSibling;

                            if(p.className==="mensaje-validacion"){
                                ban=1;
                            }

                            if(!ban) {
                                $http({
                                    method: 'POST',
                                    url: "php/abm/pedir.prestamo.php",
                                    data: union,
                                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                })
                                .then(function (response) {
                                    if (response.data === "1") {
                                        $scope.estado = "Prestamo solicitado, el mismo será pocesado para su autorización";
                                        $scope.mostrar_form = false;
                                    }
                                    else{
                                        alert("Ups! hubo un error, vuelva a intentarlo mas tarde");
                                    }
                                }, function (error) {

                                });
                            }
                        };

                        //ESTADO DE PRESTAMO
                        $http({
                            method: 'POST',
                            url:"php/abm/estado.prestamo.php",
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        })
                            .then(function (response){
                                if(response.data==="false"){
                                    $scope.estado = "Solicitar un prestamo";
                                    $scope.mostrar_form = true;
                                }
                                else {
                                    $scope.en_proceso=true;
                                    //que pasa cuando response.data=false. no hay prestamo pedido
                                    if (response.data.STATE === undefined) {
                                        // PEDIR PRESTAMO
                                        $scope.mostrar_form = true;
                                        $scope.estado = "Solicitar un prestamo";
                                    }
                                    if (response.data.STATE === "Pedido") {
                                        $scope.mostrar_form = false;
                                        $scope.estado = "Su prestamo de $"+response.data.AMOUNT+" pedido el "+response.data.CREATED_DATE+"  se encuentra en proceso de autorización";
                                    }
                                    else if (response.data.STATE === "Pre-Otorgado") {
                                        const union = "FK_PRESTAMO=" + response.data.ID;

                                        //LISTADO DE FINANCIERAS
                                            $http({
                                                method: 'POST',
                                                url:"php/abm/listado.financieras.php",
                                                data: union,
                                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                            })
                                            .then(function (response2){

                                                if(response2.data.length===0){
                                                    $scope.mensaje="Aun no hay ofertas financieras.";
                                                }
                                                else if(response2.data.length>0){
                                                    $scope.listado_financieras=response2.data;

                                                    //ACEPTAR CLIENTE
                                                    $scope.aceptar=function($id){
                                                        const union = "FK_FINANCIERA=" + $id + "&FK_PRESTAMO=" + response.data.ID;
                                                        $http({
                                                            method: 'POST',
                                                            url: "php/abm/aceptar.financiera.php",
                                                            data: union,
                                                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                                        }).then(function (response){
                                                            if(response.data===""){
                                                                rc(tn(id($id).parentNode,"button",0).parentNode,tn(id($id).parentNode,"button",0));
                                                                rc(tn(id($id).parentNode,"button",0).parentNode,tn(id($id).parentNode,"button",0));
                                                                id($id).parentNode.style.background="#7cbd1e";
                                                                const filas = tn(tn(document, "table", 0), "tr");
                                                                for(let i=1; i<filas.length; i++){
                                                                    if(tn(filas[i],"td",0).id!==$id){
                                                                        rc(filas[i].parentNode,filas[i]);
                                                                    }
                                                                }
                                                                alert("Has concretado la peticion de tu prestamo. La financiera se podrá en contacto con vos a la brevedad via mail o telefono.");;
                                                            }

                                                        }, function (error) {

                                                        });
                                                    };

                                                    //RECHAZAR CLIENTE
                                                    $scope.denegar=function($id){
                                                        const union = "FK_FINANCIERA=" + $id + "&FK_PRESTAMO=" + response.data.ID;
                                                        $http({
                                                            method: 'POST',
                                                            url: "php/abm/denegar.financiera.php",
                                                            data: union,
                                                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                                        }).then(function (response) {
                                                            if(response.data===""){
                                                                rc(tn(id($id).parentNode,"button",0).parentNode,tn(id($id).parentNode,"button",0));
                                                                rc(tn(id($id).parentNode,"button",0).parentNode,tn(id($id).parentNode,"button",0));
                                                                id($id).parentNode.style.background="#f23a2e";
                                                            }

                                                        }, function (error) {

                                                        });
                                                    };
                                                }
                                            },function (error){

                                            });

                                        $scope.mostrar_form = false;
                                        $scope.estado = "Su prestamo de $"+response.data.AMOUNT+" pedido el "+response.data.CREATED_DATE+" ha sido aprobado";
                                        $scope.mensaje = "Listado de financieras interesadas en otorgarte el prestamo";
                                    } else if (response.data.STATE === "Denegado") {
                                        $scope.estado = "Su prestamo de $"+response.data.AMOUNT+" pedido el "+response.data.CREATED_DATE+" ha sido denegado :(";
                                        $scope.mensaje = "La denegación de un prestamo se debe a que el usuario se encuentra registrado en el veraz.";
                                    }
                                    else if (response.data.STATE === "Otorgado") {
                                        $scope.mostrar_form = false;
                                        $scope.mensaje_otorgado = "¡La financiera que elegiste se pondrá en contacto con vos a la brevedad!";
                                        $scope.estado = "Solicitar un nuevo prestamo";
                                        $scope.mostrar_form = true;
                                    }

                                }

                            },function (error){

                            });
                }
                    /***** FINANCIERA *****/

                    //LISTAR PRESTAMOS A EVALUAR
                    else if($scope.usuario.USER_TYPE==="Financiera"){
                        $http({
                            method: 'POST',
                            url: "php/abm/solicitud.prestamos.php",
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(function (response) {
                            console.log(response);

                            if(response.data!=="") {
                                $scope.pedidos_cliente = response.data;
                            }
                        }, function (error) {

                        });

                        //ACEPTAR CLIENTE
                        $scope.ofertar_prestamo=function(id){
                            $http({
                                method: 'POST',
                                url: "php/abm/ofertar.php",
                                data: "FK_PRESTAMO=" + id,
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).then(function (response2) {
                                console.log(response2);
                                if(response2.data===""){
                                    rc(tn(document.getElementById(id).parentNode,"button",0).parentNode,tn(document.getElementById(id).parentNode,"button",0));
                                    rc(tn(document.getElementById(id).parentNode,"button",0).parentNode,tn(document.getElementById(id).parentNode,"button",0));
                                    document.getElementById(id).parentNode.style.background="#7cbd1e";
                                }

                            }, function (error) {

                            });
                        };

                        //RECHAZAR CLIENTE
                        $scope.denegar_prestamo=function($id){
                            const union = "FK_PRESTAMO=" + $id;
                            $http({
                                method: 'POST',
                                url: "php/abm/denegar.php",
                                data: union,
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).then(function (response2) {
                                if(response2.data===""){
                                    rc(tn(id($id).parentNode,"button",0).parentNode,tn(id($id).parentNode,"button",0));
                                    rc(tn(id($id).parentNode,"button",0).parentNode,tn(id($id).parentNode,"button",0));
                                    id($id).parentNode.style.background="#f23a2e";
                                }

                            }, function (error) {

                            });
                        };


                        //LISTAR PRESTAMOS BRINDADOS
                        $http({
                            method: 'POST',
                            url: "php/abm/pedidos.concretados.php",
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(function (response) {
                            console.log(response);
                            if(response.data=="null"){
                                $scope.pedidos_concretados=[];
                            }
                            else{
                                $scope.pedidos_concretados=response.data;
                            }


                        }, function (error) {

                        });
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
                                    const item = [];
                                    for(var i in pedido){
                                        item.push( i+'='+pedido[i] );
                                    }
                                    const union = item.join('&');

                                    $http({
                                        method: 'POST',
                                        url: "php/abm/procesar.datos.php",
                                        data: union,
                                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                    }).then(function (response) {
                                        alert("El veraz ha comprobado el estado de la cuenta, el usuario "+pedido.NAME+" "+ pedido.LAST_NAME +" ha sido "+response.data);
                                        if(response.data==="Aprobado"){
                                           id(pedido.ID).parentNode.style.backgroundColor="#5dd223";
                                           rc(id(pedido.FK_CLIENT).parentNode, id(pedido.FK_CLIENT));
                                        }
                                        else if(response.data==="Reprobado") {
                                            id(pedido.ID).parentNode.style.backgroundColor="#d24d23";
                                            rc(id(pedido.FK_CLIENT).parentNode, id(pedido.FK_CLIENT));
                                        }

                                    }, function (error) {

                                    });
                                }
                            }

                            },function (error){

                            });


                    }
                }
              else{
                    //logout
                    $scope.no_user=true;

                    alert("no estas logueado kapo");
                    $window.location.href = '#!/';
                }
            },function (error){

        });




}]);
