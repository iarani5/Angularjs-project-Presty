/**************************************** CONTROLLER INDEX ***************************************/



Presty.controller("indexCtrl", function ($location,$http,$scope,$window) {

    if(localStorage.getItem("user_presty_logout")!==undefined&&localStorage.getItem("user_presty_logout")!==null){
        localStorage.removeItem("user_presty_logout");
        $window.location.reload();
    }

    $scope.no_user=true;
    $http({
        method: 'POST',
        url:"php/abm/logueado.php",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
        .then(function (response){
            console.log(response);
            if(response.data!=="1"&&localStorage.getItem("user_presty")!==undefined&&localStorage.getItem("user_presty")!==null){
                $scope.no_user=false;

                /*   $scope.usuario=angular.fromJson(localStorage.getItem("user_presty"));
                   $scope.logueado=true;
                   var dato_menu="";
                   switch ($scope.usuario.USER_TYPE) {
                       case "Client":
                           dato_menu=$scope.usuario.NAME;
                           break;
                       case "Financiera":
                           dato_menu=$scope.usuario.COMPANY;
                           break;
                       default:
                           dato_menu=$scope.usuario.EMAIL;
                           break;
                   }
                   //MENU
                   $scope.opts=[
                       { text:  "Home", href: "#!/" },
                       { text:  "Panel", href: "#!/Panel" },
                       { text:  dato_menu, href: "" }
                   ];

                   $window.location.href="#!/Panel";*/
            }
            else{
                //no logueado

                console.log("no logueado");
               /* $scope.logueado=false;

                $scope.opts=[
                    { text:  "Home", href: "#!/" },
                    { text:  "Login", href: "#!/Login" },
                    { text:  "Registro", href: "#!/Registro" }
                ];*/

            }
        },function (error){

        });

    $scope.logout=function(){
        $http({
            method: 'POST',
            url:"php/abm/logout.php",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function (response){
                if(response.data==="1"){
                    if(localStorage.getItem("user_presty")!==undefined&&localStorage.getItem("user_presty")!==null){
                        localStorage.removeItem("user_presty");
                    }
                    localStorage.setItem("user_presty_logut",1);
                    $window.location.href="#!/";
                }
                else{
                    //error intentar mas tarde
                }

            },function (error){

            });

    };

});

