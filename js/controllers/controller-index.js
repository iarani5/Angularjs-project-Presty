/**************************************** CONTROLLER INDEX ***************************************/
 
Presty.controller("indexCtrl", function ($location,$http,$scope,$window,$routeParams) {
    $http({
        method: 'POST',
        url:"php/abm/logueado.php",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
        .then(function (response){
            if(response.data!="1"||localStorage.getItem("user_presty")==undefined||localStorage.getItem("user_presty")==null){
                $scope.usuario=angular.fromJson(localStorage.getItem("user_presty"));
            }
            else{
                //no logueado
            }
        },function (error){

        });
    /*
        //me fijo si el usuario ya esta logueado.
        if(localStorage.getItem("dts_user")!=null){ //si ya existen sus datos almacenados en la web. esta logueado.
            var usuario=[];
            usuario=angular.fromJson(localStorage.getItem("dts_user"));

            //creo boton en nav-bar con el nombre de usuario
            if(id("nombre_usuario")==undefined){
                li=ce("li");
                li.className="scroll";
                nombre_usuario=ce("a");
                ac(li, nombre_usuario);
                nombre_usuario.href="#!/perfil"; //si se aprieta lo lleva al perfil del usuario.
                nombre_usuario.innerHTML=usuario.NOMBRE;
                nombre_usuario.id="nombre_usuario";
                ac(tn(id("navbar-menu"),"ul",0), li);
            }

            //saco los botones de login, registrarse y como funciona
            var botones=document.getElementsByClassName("sin_usuario");
            for(var i=0;i<botones.length;i++){
                rc(botones[i].parentNode, botones[i]);
            }


        }
        else{
            //no hay usuario logueado
        }*/
    $scope.logout=function(){
        $http({
            method: 'POST',
            url:"php/abm/logout.php",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function (response){
                if(response.data==="1"){
                    if(localStorage.getItem("user_presty")!==undefined||localStorage.getItem("user_presty")!==null){
                        localStorage.removeItem("user_presty");
                    }
                    $window.location.href="#!/";
                }
                else{
                    //error intentar mas tarde
                }

            },function (error){

            });

    };

});

