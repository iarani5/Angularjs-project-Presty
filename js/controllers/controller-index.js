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

    $scope.web=function(){
        $window.open("https://www.google.com", "_blank");
    };

    var banners=document.getElementsByClassName("slide");

    for(var i=0;i<banners.length;i++) {
        banners[0].style.background = 'url("images/Publicidad/remax.png") no-repeat center top';
        banners[0].style.backgroundSize = 'auto 100%';
        banners[1].style.background = 'url("images/Publicidad/peugeot.png") no-repeat center top';
        banners[1].style.backgroundSize = 'auto 100%';
        banners[2].style.background = 'url("images/Publicidad/Despegar.png") no-repeat center top';
        banners[2].style.backgroundSize = 'auto 100%';
    }

    $('.slider').each(function() {
        var $this = $(this);
        var $group = $this.find('.slide_group');
        var $slides = $this.find('.slide');
        var bulletArray = [];
        var currentIndex = 0;
        var timeout;

        function move(newIndex) {
            var animateLeft, slideLeft;

            advance();

            if ($group.is(':animated') || currentIndex === newIndex) {
                return;
            }

            bulletArray[currentIndex].removeClass('active');
            bulletArray[newIndex].addClass('active');

            if (newIndex > currentIndex) {
                slideLeft = '100%';
                animateLeft = '-100%';
            } else {
                slideLeft = '-100%';
                animateLeft = '100%';
            }

            $slides.eq(newIndex).css({
                display: 'block',
                left: slideLeft
            });
            $group.animate({
                left: animateLeft
            }, function() {
                $slides.eq(currentIndex).css({
                    display: 'none'
                });
                $slides.eq(newIndex).css({
                    left: 0
                });
                $group.css({
                    left: 0
                });
                currentIndex = newIndex;
            });
        }

        function advance() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                if (currentIndex < ($slides.length - 1)) {
                    move(currentIndex + 1);
                } else {
                    move(0);
                }
            }, 4000);
        }

        $('.next_btn').on('click', function() {
            if (currentIndex < ($slides.length - 1)) {
                move(currentIndex + 1);
            } else {
                move(0);
            }
        });

        $('.previous_btn').on('click', function() {
            if (currentIndex !== 0) {
                move(currentIndex - 1);
            } else {
                move(3);
            }
        });

        $.each($slides, function(index) {
            var $button = $('<a class="slide_btn">&bull;</a>');

            if (index === currentIndex) {
                $button.addClass('active');
            }
            $button.on('click', function() {
                move(index);
            }).appendTo('.slide_buttons');
            bulletArray.push($button);
        });

        advance();

    });

});

