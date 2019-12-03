/******* CONTROLLER LOGIN ********/

Presty.controller("loginCtrl", function ($location,$http,$scope,$window) {

    //envio del form
    $scope.login = function (usuario){
        var item = [];
        var datos_login=tn(tn(document,'form',0),'input');
        for(var i in usuario){
            item.push( i+'='+usuario[i] );
        }
        //validar inputs en el submit
        var ban=0;
        for(var i=0;i<datos_login.length;i++){
            datos_login[i].style.borderBottom='none';
            var p=datos_login[i].nextSibling;
            if(p.className=="mensaje-validacion"){
                rc(p.parentNode,p);
            }
            validar_form(datos_login[i]);
            var p=datos_login[i].nextSibling;
            if(p.className=="mensaje-validacion"){
                ban=1;
            }
        }
        if(!ban){
            var union = item.join('&');
            //ABM: login
            $http({
                method: 'POST',
                url:"php/abm/login.php",
                data: union,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data){
                    if(data.data.BORRADO==="Si"){
                        var p=ce('p');
                        p.className='mensaje-validacion';
                        p.innerHTML='Usuario Eliminado';
                        datos_login[0].parentNode.insertBefore(p,datos_login[0]);
                    }
                    else if(data.data.ID!==undefined && data.data.ID !== null){
                        localStorage.setItem("user_presty",JSON.stringify(data.data));
                        localStorage.setItem("logueado",1);
                        $window.location.reload();
                       // $window.location.href = '#!/';
                    }
                    else{
                        if(document.getElementsByClassName("mensaje-validacion")[0]!==undefined){
                            rc(document.getElementsByClassName("mensaje-validacion")[0].parentNode,document.getElementsByClassName("mensaje-validacion")[0]);
                        }
                        var p=ce('p');
                        p.className='mensaje-validacion';
                        p.innerHTML='Mail o contraseña incorrectos';
                        datos_login[0].parentNode.insertBefore(p,datos_login[0]);
                    }

                },function (error){
                     // Sin conexion
                });
        }
    }


});






