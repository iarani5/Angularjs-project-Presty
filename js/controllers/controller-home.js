
Presty.controller("homeCtrl", function ($location,$http,$scope,$window,$routeParams) {

    //BANNER PUBLICIDAD
    var banners=document.getElementsByClassName("slide");
    $http({
        method: 'POST',
        url:"php/abm/traer.publicidad.home.php",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
        .then(function (response){
            let i;
            for(i = 0; i<response.data.length; i++) {
                var una_publicidad=angular.fromJson(response.data[i]);
                una_publicidad.IMG=una_publicidad.IMG.replace("C:/xampp/htdocs/Presty/", "");
                banners[i].style.background = 'url("'+una_publicidad.IMG+'") no-repeat center top';
                banners[i].style.backgroundSize = 'auto 100%';
                banners[i].id=una_publicidad.LINK;
                banners[i].onclick=function(){
                    $window.open(this.id, "_blank");
                }
            }

            if(response.data.length<5){
                var ban=document.getElementsByClassName("slide")[0];
                for(i = 0 ; i<banners.length; i++) {
                    if(banners[i].id===""){
                        banners[i].parentNode.removeChild(banners[i]);
                    }
                }
            }
        },function (error){

        });


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

